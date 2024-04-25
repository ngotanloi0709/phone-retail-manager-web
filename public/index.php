<?php

use app\core\RequestHandler;
use app\utils\ErrorHandler;

date_default_timezone_set('Asia/Ho_Chi_Minh');
error_reporting(0);

require_once __DIR__ . "/../vendor/autoload.php";

set_error_handler(ErrorHandler::handleInternalErrors());
register_shutdown_function(ErrorHandler::handleInternalErrors());

$container = require_once __DIR__ . '/../src/bootstrap.php';
$container->get(RequestHandler::class)->handle();




