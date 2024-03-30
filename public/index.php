<?php

use app\core\RequestHandler;
use DI\DependencyException;
use DI\NotFoundException;

require_once __DIR__ . "/../vendor/autoload.php";
$container = require_once __DIR__ . '/../src/bootstrap.php';
require_once __DIR__ . "/../src/create_schema.php"; // for dev purposes only

session_start();

try {
    $container->get(RequestHandler::class)->handle();
} catch (DependencyException|NotFoundException $e) {
    error_log($e->getMessage());
    header('Location: /error');
    exit();
}



