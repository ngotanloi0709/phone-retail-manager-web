<?php

namespace app\controllers;

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

    public function getPersonalInformation(): void
    {
        $this->render('personal-information');
    }

    public function changPersonalInformation(): void
    {

        header("Location: /user/personal-information");
    }
}