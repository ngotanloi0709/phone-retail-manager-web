<?php

namespace app\controllers;

use DI\Container;
use Jenssegers\Blade\Blade;

class Controller
{
    protected Blade $blade;

    public function __construct(Container $container)
    {

    }
}