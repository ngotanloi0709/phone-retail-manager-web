<?php

namespace app\controllers;

class AdminController
{
    public function index(): void
    {
        echo $this->engine->render('admin');
    }
}