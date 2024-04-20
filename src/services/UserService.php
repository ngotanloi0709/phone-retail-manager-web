<?php

namespace app\services;

use app\models\User;
use app\models\UserRole;
use app\repositories\UserRepository;
use app\utils\AuthenticationValidateHelper;
use app\utils\SessionUser;
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

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function changePassword(string $oldPassword, string $newPassword, string $repeatPassword): bool
    {
        $currentUser = $this->findUserById($_SESSION['user']->getId());

        if (!password_verify($oldPassword, $currentUser->getPassword())) {
            $_SESSION['alerts'][] = 'Mật khẩu cũ không đúng';
            return false;
        }

        if ($newPassword !== $repeatPassword) {
            $_SESSION['alerts'][] = 'Mật khẩu mới không khớp';
            return false;
        }

        $errors = AuthenticationValidateHelper::validateRegister($newPassword);

        if (!empty($errors)) {
            foreach ($errors as $error) {
                $_SESSION['alerts'][] = $error;
            }

            return false;
        }

        $currentUser->setPassword(password_hash($newPassword, PASSWORD_DEFAULT));

        $this->userRepository->save($currentUser);

        $sessionUser = SessionUser::fromUserEntity($currentUser);

        $_SESSION['user'] = $sessionUser;

        return true;
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function findUserById(int $id): User
    {
        return $this->userRepository->find($id);
    }
}