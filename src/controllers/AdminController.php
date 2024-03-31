<?php

namespace app\controllers;

use app\services\AuthenticationService;
use League\Plates\Engine;

class AdminController extends Controller
{
    public function __construct(Engine $engine, AuthenticationService $authenticationService)
    {
        parent::__construct($engine, $authenticationService);
    }

    public function index(): void
    {
        $this->render('admin/admin');
    }

    public function getUserManagement(): void
    {
        $this->render('admin/user_management');
    }
}