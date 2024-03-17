<?php

use app\core\RequestHandler;
use DI\DependencyException;
use DI\NotFoundException;

require __DIR__ . '/../vendor/autoload.php';
$container = require_once __DIR__ . '/../src/bootstrap.php';

session_start();

try {
    $container->get(RequestHandler::class)->handle();
} catch (DependencyException|NotFoundException $e) {
    error_log($e->getMessage());
}



