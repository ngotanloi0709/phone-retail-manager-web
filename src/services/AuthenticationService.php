<?php

namespace app\services;

use app\models\User;
use app\models\UserRole;
use app\repositories\UserRepository;
use app\utils\SessionUser;

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

        if ($username == 'admin' && !$user) {
            $this->createAdminBuiltInAccount();
            $user = $this->userRepository->findByUsername($username);
        }

        if (!$user) {
            $_SESSION['alerts'][] = 'Tài khoản không tồn tại';
            return false;
        }

        if (!password_verify($password, $user->getPassword())) {
            $_SESSION['alerts'][] = 'Sai mật khẩu';
            return false;
        }

        $sessionUser = SessionUser::fromUserEntity($user);

        $_SESSION['user'] = $sessionUser;

        return true;
    }

    private function createAdminBuiltInAccount(): void
    {
        $admin = new User('admin@email.com', password_hash('admin', PASSWORD_DEFAULT), 'admin', UserRole::ADMIN);
        $this->userRepository->save($admin);
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