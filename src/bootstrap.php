<?php

session_set_cookie_params(3600);
session_start();

$container = require_once __DIR__ . "/../src/core/service_config.php";
require_once __DIR__ . "/../src/create_schema.php"; // for dev purposes only


return $container;