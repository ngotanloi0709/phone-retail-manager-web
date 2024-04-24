<?php

namespace app\controllers;

use app\models\UserRole;
use app\services\AuthenticationService;
use app\services\EmailService;
use app\services\UserService;
use app\utils\LoginTokenGenerator;
use Doctrine\ORM\Exception\ORMException;
use League\Plates\Engine;

class AdminUserController extends Controller
{
    public function __construct(
        Engine                                $engine,
        AuthenticationService                 $authenticationService,
        private readonly UserService          $userService,
        private readonly EmailService         $emailService
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
}