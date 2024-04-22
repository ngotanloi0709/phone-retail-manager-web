<?php

namespace app\controllers;

use app\models\UserRole;
use app\repositories\LoginEmailRepository;
use app\services\AuthenticationService;
use app\services\UserService;
use Doctrine\ORM\Exception\ORMException;
use League\Plates\Engine;

class AdminUserController extends Controller
{
    public function __construct(
        Engine                                $engine,
        AuthenticationService                 $authenticationService,
        private readonly UserService          $userService,
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
}