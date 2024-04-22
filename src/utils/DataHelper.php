<?php

namespace app\utils;

class DataHelper
{
    public static function emailToUsername(string $email): string
    {
        return substr($email, 0, strpos($email, '@'));
    }

    public static function getDisplayStringData(?string $input, bool $isReturnEmptyString = false): string
    {
        if ($isReturnEmptyString) {
            return $input != null && $input != '' ? $input : '';
        }

        return $input != null && $input != '' ? $input : 'Chưa có dữ liệu';
    }
}