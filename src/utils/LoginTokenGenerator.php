<?php

namespace app\utils;

class LoginTokenGenerator
{
    public static function generateToken(string $email): string
    {
        return md5($email . time());
    }
}