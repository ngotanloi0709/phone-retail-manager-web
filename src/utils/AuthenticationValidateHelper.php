<?php

namespace app\utils;

class AuthenticationValidateHelper
{
    public static function validatePassword(string $password): array
    {
        $errors = [];

        if (empty($password)) {
            $errors['password'] = 'Password không được để trống';
        }

        if (strlen($password) < 6) {
            $errors['password'] = 'Password phải có ít nhất 6 ký tự';
        }

        return $errors;
    }

    public static function validateLogin(string $username, string $password): array
    {
        $errors = [];

        if (empty($username)) {
            $errors['username'] = 'Thiếu Username';
        }

        if (strlen($username) < 6) {
            $errors['username'] = 'Username phải có ít nhất 6 ký tự';
        }

        if (empty($password)) {
            $errors['password'] = 'Thiếu Password';
        }

        if (strlen($password) < 6) {
            $errors['password'] = 'Password phải có ít nhất 6 ký tự';
        }

        return $errors;
    }
}