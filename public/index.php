<?php

require_once __DIR__ . "/../src/configs/config.php";

$GLOBALS['shouldEnableDebug'] = $config['APP']['env'] === ENV_DEV;

ini_set('display_errors', $shouldEnableDebug ? '1' : '0');
ini_set('display_startup_errors', $shouldEnableDebug ? '1' : '0');
error_reporting($shouldEnableDebug ? E_ALL : 0);

use app\core\RequestHandler;
use app\utils\ErrorHandler;

date_default_timezone_set('Asia/Ho_Chi_Minh');

require_once __DIR__ . "/../vendor/autoload.php";

set_error_handler(ErrorHandler::handleInternalErrors());
register_shutdown_function(ErrorHandler::handleInternalErrors());

$container = require_once __DIR__ . '/../src/bootstrap.php';
$container->get(RequestHandler::class)->handle();




