<?php

namespace app\controllers;

class HomeController extends Controller
{
    public function index(): void
    {
        echo $this->engine->render('home', [
            'name' => 'Jonathan',
            'title' => 'Home',
            'header' => 'Đây là trang chủ']);
    }
}