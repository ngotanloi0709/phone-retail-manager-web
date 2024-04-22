<?php

require_once __DIR__ . '/../../vendor/autoload.php'; // Adjust this to your project's autoload file path

use app\utils\EmailHelper;

//$email = $argv[1];
//$token = $argv[2];

$email = "ngotanloi0709@gmail.com";
$token = "6a334aae75f6c77ba67b952a6d8d547e";

EmailHelper::sendLoginEmail($email, $token);