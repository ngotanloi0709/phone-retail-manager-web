<?php

namespace app\controllers;

use app\services\AuthenticationService;
use app\services\UserService;
use DI\Container;
use League\Plates\Engine;

class UserController extends Controller
{
    private UserService $userService;
    public function __construct(Engine $engine, UserService $userService, AuthenticationService $authenticationService)
    {
        parent::__construct($engine, $authenticationService);
        $this->userService = $userService;
    }
}