<?php

namespace app\utils;

class LoginInputValidator
{
    public static function validate(string $username, string $password): array
    {
        $errors = [];

        if (empty($username)) {
            $errors['username'] = 'Username is required';
        }

        if (strlen($username) < 6) {
            $errors['username'] = 'Username must be at least 6 characters';
        }

        if (empty($password)) {
            $errors['password'] = 'Password is required';
        }

        if (strlen($password) < 6) {
            $errors['password'] = 'Password must be at least 6 characters';
        }

        return $errors;
    }
}