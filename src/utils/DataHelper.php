<?php

namespace app\utils;

class DataHelper
{
    public static function emailToUsername(string $email): string
    {
        return substr($email, 0, strpos($email, '@'));
    }
}