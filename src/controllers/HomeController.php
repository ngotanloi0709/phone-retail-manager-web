<?php

namespace app\controllers;

use app\services\AuthenticationService;
use app\services\UserService;
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

    public function error(): void
    {
        echo $this->engine->render('error');
    }

    public function getLogin(): void
    {
        if ($this->authenticationService->isAuthenticated()) {
            header('Location: /');
            exit();
        }

        echo $this->engine->render('login');
    }

    public function postLogin(): void
    {
        $username = $_POST['username'];
        $password = $_POST['password'];


    }
}