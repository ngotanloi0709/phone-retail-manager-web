<?php

namespace app\services;

use app\models\User;
use app\models\UserRole;
use app\repositories\UserRepository;

class AuthenticationService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login(string $username, string $password): bool
    {
        $user = $this->userRepository->findByUsername($username);

        if (!$user) {
            $_SESSION['alerts'][] = 'Tài khoản không tồn tại';
            return false;
        }

        if (!password_verify($password, $user->getPassword())) {
            $_SESSION['alerts'][] = 'Sai mật khẩu';
            return false;
        }

        $_SESSION['user'] = $user;

        return true;
    }

    public function logout(): void
    {
        unset($_SESSION['user']);
    }

    public function isAuthenticated(): bool
    {
        return isset($_SESSION['user']);
    }

    public function isAdmin(): bool
    {
        return isset($_SESSION['user']) && $_SESSION['user']->getRole() == UserRole::ADMIN;
    }

    public function getCurrentUser(): ?User
    {
        return isset($_SESSION['user']) ? $this->userRepository->find($_SESSION['user']->getId()) : null;
    }
}