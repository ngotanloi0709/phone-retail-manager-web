<?php

namespace app\utils;

use JetBrains\PhpStorm\NoReturn;

class ErrorHandler
{
    #[NoReturn] public static function customErrorHandler($errno, $errstr, $errfile, $errline): void
    {
        error_log("Error: [$errno] $errstr on line $errline in file $errfile");
        header('Location: /error-not-found');
        exit();
    }

    public static function shutdownHandler(): void
    {
        $error = error_get_last();
        if ($error !== NULL) {
            self::customErrorHandler($error['type'], $error['message'], $error['file'], $error['line']);
        }
    }
}