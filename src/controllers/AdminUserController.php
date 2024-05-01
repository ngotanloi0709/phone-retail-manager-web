<?php

namespace app\controllers;

use app\dto\EditUserInformationDTO;
use app\models\UserRole;
use app\services\AuthenticationService;
use app\services\EmailService;
use app\services\TransactionService;
use app\services\UserService;
use app\utils\LoginTokenGenerator;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use League\Plates\Engine;

class AdminUserController extends Controller
{
    public function __construct(
        Engine                        $engine,
        AuthenticationService         $authenticationService,
        private readonly UserService  $userService,
        private readonly EmailService $emailService,
        private readonly TransactionService $transactionService
    )
    {
        parent::__construct($engine, $authenticationService);
    }

    /**
     * @throws ORMException
     */
    public function createNewUser(): void
    {
        $email = $_POST['email'];
        $name = $_POST['name'];
        $role = $_POST['role'] == 'admin' ? UserRole::ADMIN : UserRole::USER;

        if ($this->userService->createNewUserByAdmin($email, $name, $role)) {
            $_SESSION['alerts'][] = 'Tạo người dùng mới thành công';
        } else {
            $_SESSION['alerts'][] = 'Tạo người dùng mới thất bại';
        }

        header('Location: /admin/user-management');
    }

    /**
     * @throws ORMException
     */
    public function sendLoginEmail(): void
    {
        $email = $_POST['email'];
        $token = LoginTokenGenerator::generateToken($email);

        if ($this->emailService->sendLoginEmail($email)) {
            $_SESSION['alerts'][] = 'Gửi email thành công';
        } else {
            $_SESSION['alerts'][] = 'Gửi email thất bại';
        }

        header('Location: /admin/user-management');
    }

    /**
     * @throws ORMException
     */
    public function deleteUser(): void
    {
        $userId = $_POST['id'];

        if ($this->userService->deleteUser($userId)) {
            $_SESSION['alerts'][] = 'Xóa người dùng thành công';
        } else {
            $_SESSION['alerts'][] = 'Xóa người dùng thất bại';
        }

        header('Location: /admin/user-management');
    }

    /**
     * @throws ORMException
     */
    public function editUser(): void
    {
        $editUserInformationDTO = new EditUserInformationDTO();
        $editUserInformationDTO->fromRequest($_POST);

        if ($this->userService->editUser($editUserInformationDTO)) {
            $_SESSION['alerts'][] = 'Chỉnh sửa thông tin người dùng thành công';
        } else {
            $_SESSION['alerts'][] = 'Chỉnh sửa thông tin người dùng thất bại';
        }

        header('Location: /admin/user-management');
    }

    public function changeUserPassword(): void
    {
        $userId = $_POST['id'];
        $newPassword = $_POST['newPassword'];
        $repeatPassword = $_POST['repeatPassword'];

        if ($this->userService->changeUserPassword($userId, $newPassword, $repeatPassword)) {
            $_SESSION['alerts'][] = 'Đổi mật khẩu người dùng thành công';
        } else {
            $_SESSION['alerts'][] = 'Đổi mật khẩu người dùng thất bại';
        }

        header('Location: /admin/user-management');
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function getUserSaleInformation(): void
    {
        $userId = $_GET['id'];
        /** @var array $user */
        $user = $this->userService->findUserById($userId);
        /** @var array $transactions */
        $transactions = $this->transactionService->getTransactionsByUserId($userId);


        $this->render('admin/user-sale-information', [
            'header' => "Lịch sử bán hàng của " . $user->getName(),
        ]);
    }
}