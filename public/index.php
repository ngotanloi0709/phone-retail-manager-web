<?php

use app\core\RequestHandler;
use app\repositories\UserRepository;
use DI\DependencyException;
use DI\NotFoundException;

require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../src/create_schema.php"; // for dev purposes only

$container = require_once __DIR__ . '/../src/bootstrap.php';

session_start();

try {
    $container->get(RequestHandler::class)->handle();
} catch (DependencyException|NotFoundException $e) {
    error_log($e->getMessage());
}



