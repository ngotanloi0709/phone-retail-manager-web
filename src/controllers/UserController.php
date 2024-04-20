<?php

namespace app\controllers;

use app\services\AuthenticationService;
use app\services\UserService;
use DI\Container;
use League\Plates\Engine;

class UserController extends Controller
{
    public function __construct(Engine $engine, AuthenticationService $authenticationService, private readonly UserService $userService)
    {
        parent::__construct($engine, $authenticationService);
    }
}