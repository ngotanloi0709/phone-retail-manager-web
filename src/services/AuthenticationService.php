<?php

namespace app\services;

use app\models\User;
use app\repositories\UserRepository;

class AuthenticationService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login(string $email, string $password): bool
    {
        $user = $this->userRepository->findByEmail($email);

        if ($user && password_verify($password, $user->getPassword())) {
            $_SESSION['user_id'] = $user->getId();
            $_SESSION['user_role'] = $user->getRole();
            return true;
        }

        return false;
    }

    public function logout(): void
    {
        unset($_SESSION['user_id']);
    }

    public function isAuthenticated(): bool
    {
        return isset($_SESSION['user_id']);
    }

    public function isAdmin(): bool
    {
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
    }

    public function getCurrentUser(): ?User
    {
        return isset($_SESSION['user_id']) ? $this->userRepository->find($_SESSION['user_id']) : null;
    }
}