<?php

namespace app\controllers;

use app\models\UserRole;
use app\services\AuthenticationService;
use app\services\UserService;
use DI\Container;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use League\Plates\Engine;

class HomeController extends Controller
{
    public function __construct(
        Engine                       $engine,
        AuthenticationService        $authenticationService,
    )
    {
        parent::__construct($engine, $authenticationService);
    }

    public function index(): void
    {
        $this->render('home', ['name' => 'Jonathan']);
    }

    public function errorNotFound(): void
    {
        $this->render('error-404');
    }

    public function getLogin(): void
    {
        if ($this->authenticationService->isAuthenticated()) {
            header('Location: /');
            exit();
        }

        $this->render('login');
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function postLogin(): void
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if ($this->authenticationService->login($username, $password)) {
            $_SESSION['alerts'][] = 'Đăng nhập thành công';
            header('Location: /');
        } else {
            $_SESSION['alerts'][] = 'Đăng nhập thất bại';
            header('Location: /login');
        }
    }

    public function postLogout(): void
    {
        $this->authenticationService->logout();
        header('Location: /');
    }

    /**
     * @throws ORMException
     */
    public function loginByEmail(): void
    {
        $token = $_GET['token'];
        $email = $_GET['email'];

        if ($this->authenticationService->loginByEmail($token, $email)) {
            $_SESSION['alerts'][] = 'Đăng nhập thành công';
        } else {
            $_SESSION['alerts'][] = 'Đăng nhập thất bại';
        }

        header('Location: /');
    }
}