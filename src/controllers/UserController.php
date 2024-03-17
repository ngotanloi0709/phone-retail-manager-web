<?php

namespace app\controllers;

use app\services\UserService;
use DI\Container;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(Container $container, UserService $userService)
    {
        parent::__construct($container);
        $this->userService = $userService;
    }

    public function getLogin(): void
    {
        require __DIR__ . '/../../public/login.php';
    }

    public function postLogin(): void
    {

    }
}