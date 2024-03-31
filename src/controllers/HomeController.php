<?php

namespace app\controllers;

use app\services\AuthenticationService;
use app\services\UserService;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use League\Plates\Engine;

class HomeController extends Controller
{
    private UserService $userService;

    public function __construct(Engine $engine, UserService $userService, AuthenticationService $authenticationService)
    {
        parent::__construct($engine, $authenticationService);
        $this->userService = $userService;
    }

    public function index(): void
    {
        $this->render('home', ['name' => 'Jonathan']);
    }

    public function errorNotFound(): void
    {
        $this->render('errorNotFound');
    }

    public function getLogin(): void
    {
        if ($this->authenticationService->isAuthenticated()) {
            header('Location: /');
            exit();
        }

        $this->render('login');
    }

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

    public function getRegister(): void
    {
        if ($this->authenticationService->isAuthenticated()) {
            header('Location: /');
            exit();
        }

        $this->render('register');
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function postRegister(): void
    {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $repeatPassword = $_POST['repeatPassword'];

        if ($this->userService->register($email, $password, $repeatPassword)) {
            $_SESSION['alerts'][] = 'Đăng ký thành công';
            header('Location: /login');
        } else {
            $_SESSION['alerts'][] = 'Đăng ký thất bại';
            header('Location: /register');
        }
    }

    public function postLogout(): void
    {
        unset($_SESSION['user']);
        $this->authenticationService->logout();
        header('Location: /');
    }
}