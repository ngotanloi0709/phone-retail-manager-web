<?php

namespace app\controllers;

use app\services\AuthenticationService;
use app\services\UserService;
use app\utils\Logger;
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
    }

    public function getRegister(): void
    {
        if ($this->authenticationService->isAuthenticated()) {
            header('Location: /');
            exit();
        }

        $this->render('register');
    }

    public function postRegister(): void
    {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        if ($this->userService->register($username, $email, $password)) {
            $_SESSION['alerts'][] = 'Đăng ký thành công';
            header('Location: /login');
        } else {
            $_SESSION['alerts'][] = 'Đăng ký thất bại';
            header('Location: /register');
        }
    }
}