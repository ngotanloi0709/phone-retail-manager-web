<?php

namespace app\utils;

class ErrorHandler
{
    public static function handleInternalErrors(): ?callable
    {
        if ($GLOBALS['shouldEnableDebug']) {
            return function () {};
        }

        return function () {
            if (error_get_last()) {
                return require __DIR__ . '/../../public/error-500.php';
            }
        };
    }

    public static function handleNotFound(): void
    {
        header('Location: /error-not-found');
        exit();
    }
}