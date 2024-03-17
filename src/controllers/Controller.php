<?php

namespace app\controllers;

use League\Plates\Engine;

class Controller
{
    protected Engine $engine;

    public function __construct(Engine $engine)
    {
        $this->engine = $engine;
    }
}