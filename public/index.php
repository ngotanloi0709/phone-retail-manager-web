<?php

use app\core\RequestHandler;
use app\utils\ErrorHandler;

require_once __DIR__ . "/../vendor/autoload.php";

//set_error_handler(ErrorHandler::handleInternalErrors());
register_shutdown_function(ErrorHandler::handleInternalErrors());

$container = require_once __DIR__ . '/../src/bootstrap.php';
$container->get(RequestHandler::class)->handle();




