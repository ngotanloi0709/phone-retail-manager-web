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
    public function changePersonalPassword(): void
    {
        $oldPassword = $_POST['oldPassword'];
        $newPassword = $_POST['newPassword'];
        $repeatPassword = $_POST['repeatPassword'];
        $currentLocation = $_POST['currentLocation'];

        if ($this->userService->changePersonalPassword($oldPassword, $newPassword, $repeatPassword)) {
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
            $_SESSION['alerts'][] = 'Thay đổi thông tin thất bại';
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

    public function getChangePasswordFirstTime(): void
    {
        if (!$_SESSION['isNeededChangePassword']) {
            header('Location: /');
            exit();
        }

        $this->render('change-password-first-time');
    }

    /**
     * @throws ORMException
     */
    public function postChangePasswordFirstTime(): void
    {
        $newPassword = $_POST['newPassword'];
        $repeatPassword = $_POST['repeatPassword'];

        if ($this->userService->changePasswordFirstTime($newPassword, $repeatPassword)) {
            $_SESSION['alerts'][] = 'Đổi mật khẩu thành công';
            header("Location: /");
        } else {
            $_SESSION['alerts'][] = 'Đổi mật khẩu thất bại';
            header("Location: /user/change-password-first-time");
        }
    }
}