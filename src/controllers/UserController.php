<?php

namespace app\controllers;

use app\dto\EditablePersonalInformationDTO;
use app\services\AuthenticationService;
use app\services\UserService;
use DI\Container;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use League\Plates\Engine;

class UserController extends Controller
{
    public function __construct(
        Engine                       $engine,
        AuthenticationService        $authenticationService,
        private readonly UserService $userService)
    {
        parent::__construct($engine, $authenticationService);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function changePassword(): void
    {
        $oldPassword = $_POST['oldPassword'];
        $newPassword = $_POST['newPassword'];
        $repeatPassword = $_POST['repeatPassword'];
        $currentLocation = $_POST['currentLocation'];

        if ($this->userService->changePassword($oldPassword, $newPassword, $repeatPassword)) {
            $_SESSION['alerts'][] = 'Đổi mật khẩu thành công';
        } else {
            $_SESSION['alerts'][] = 'Đổi mật khẩu thất bại';
        }

        header("Location: $currentLocation");
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function getPersonalInformation(): void
    {
        $user = $this->userService->findUserById($_SESSION['user']->getId());

        $this->render('personal-information', ['userInformation' => $user]);
    }

    /**
     * @throws ORMException
     */
    public function changPersonalInformation(): void
    {
        $editablePersonalInformation = new EditablePersonalInformationDTO();
        $editablePersonalInformation->fromRequest($_POST);

        if ($this->userService->changPersonalInformation($editablePersonalInformation)) {
            $_SESSION['alerts'][] = 'Thay đổi thông tin thành công';
        } else {
            $_SESSION['alerts'][] = 'Thay đổi thông tin thành công';
        }

        header("Location: /user/personal-information");
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function changeAvatar(): void
    {
        $avatar = $_POST['avatar'];

        if ($this->userService->changeAvatar($avatar)) {
            $_SESSION['alerts'][] = 'Đổi ảnh đại diện thành công';
        } else {
            $_SESSION['alerts'][] = 'Đổi ảnh đại diện thất bại';
        }

        header("Location: /user/personal-information");
    }
}