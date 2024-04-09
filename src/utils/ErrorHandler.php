<?php

namespace app\utils;

use JetBrains\PhpStorm\NoReturn;

class ErrorHandler
{
    public static function handleInternalErrors(): callable
    {
        return function () {
            if (error_get_last()) {
                header('Location: /error-500.php');
                exit();
            }
        };
    }

    #[NoReturn] public static function handleNotFound(): void
    {
        header('Location: /error-not-found');
        exit();
    }
}