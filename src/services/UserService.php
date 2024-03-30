<?php

namespace app\services;

use app\models\User;
use app\repositories\UserRepository;
use app\utils\Logger;
use app\utils\LoginInputValidator;
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
    public function register(string $username, string $email, string $password): bool
    {
        if ($this->userRepository->findByEmail($email)) {
            $_SESSION['alerts'][] = 'Email đã tồn tại';
            return false;
        }

        $errors = LoginInputValidator::validate($username, $password);

        if (!empty($errors)) {
            foreach ($errors as $error) {
                $_SESSION['alerts'][] = $error;
            }

            return false;
        }

        $user = new User();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPassword(password_hash($password, PASSWORD_DEFAULT));

        $this->userRepository->save($user);

        return true;
    }
}