<?php

namespace app\services;

use app\models\User;
use app\models\UserRole;
use app\repositories\UserRepository;
use app\utils\Logger;
use app\utils\AuthenticationValidateHelper;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

class UserService
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
    public function register(string $email, string $password, string $repeatPassword, UserRole $role): bool
    {
        if ($password !== $repeatPassword) {
            $_SESSION['alerts'][] = 'Mật khẩu không khớp';
            return false;
        }

        if ($this->userRepository->findByEmail($email)) {
            $_SESSION['alerts'][] = 'Email đã tồn tại';
            return false;
        }

        $errors = AuthenticationValidateHelper::validateRegister($password);

        if (!empty($errors)) {
            foreach ($errors as $error) {
                $_SESSION['alerts'][] = $error;
            }

            return false;
        }

        $user = new User($email, password_hash($password, PASSWORD_DEFAULT), explode('@', $email)[0], $role);

        $this->userRepository->save($user);

        return true;
    }
}