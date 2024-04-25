<?php

namespace app\controllers;

use app\services\AuthenticationService;
use app\services\UserService;
use League\Plates\Engine;

class AdminController extends Controller
{
    public function __construct(
        Engine                $engine,
        AuthenticationService $authenticationService,
        private readonly UserService $userService
    )
    {
        parent::__construct($engine, $authenticationService);
    }

    public function index(): void
    {
        $this->render('admin/admin');
    }

    public function getUserManagement(): void
    {
        $users = $this->userService->findAllUsers();

        $this->render('admin/user-management', ['users' => $users]);
    }
}