<?php

namespace app\services;

use app\dto\SessionUserDTO;
use app\models\User;
use app\models\UserRole;
use app\repositories\UserRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

class AuthenticationService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
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

        $_SESSION['user'] = SessionUserDTO::fromUserEntity($user);

        return true;
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
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

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function getCurrentUser(): ?User
    {
        return isset($_SESSION['user']) ? $this->userRepository->find($_SESSION['user']->getId()) : null;
    }
}