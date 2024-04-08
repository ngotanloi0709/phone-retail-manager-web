<?php

use app\core\RequestHandler;
use DI\DependencyException;
use DI\NotFoundException;

require_once __DIR__ . "/../vendor/autoload.php";
$container = require_once __DIR__ . '/../src/bootstrap.php';

try {
    $container->get(RequestHandler::class)->handle();
} catch (DependencyException|NotFoundException $e) {
    $_SESSION['logger'][] = "Lỗi: " . $e->getMessage();
    header('Location: /error-500');
    exit();
}



