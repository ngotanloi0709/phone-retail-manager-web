<?php

namespace app\services;

use app\dto\EditablePersonalInformationDTO;
use app\dto\SessionUserDTO;
use app\models\User;
use app\models\UserRole;
use app\repositories\UserRepository;
use app\utils\AuthenticationValidateHelper;
use DateTime;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Exception;

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
        try {
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
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function changePassword(string $oldPassword, string $newPassword, string $repeatPassword): bool
    {
        try {
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

            $sessionUser = SessionUserDTO::fromUserEntity($currentUser);

            $_SESSION['user'] = $sessionUser;
        } catch (Exception $e) {
            return false;
        }

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

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function changeAvatar(string $avatar): bool
    {
        try {
            $currentUser = $this->findUserById($_SESSION['user']->getId());

            $currentUser->setAvatar($avatar);

            $this->userRepository->save($currentUser);

            $_SESSION['user'] = SessionUserDTO::fromUserEntity($currentUser);
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * @throws ORMException
     */
    public function changPersonalInformation(EditablePersonalInformationDTO $editablePersonalInformation): bool
    {
        try {
            $currentUser = $this->findUserById($_SESSION['user']->getId());

            $currentUser->setPhone($editablePersonalInformation->getPhone());
            $currentUser->setIsFemale($editablePersonalInformation->isFemale());
            $currentUser->setAddress($editablePersonalInformation->getAddress());
            $currentUser->setDateOfBirth(
                DateTime::createFromFormat(
                    'Y-m-d',
                    $editablePersonalInformation->getDateOfBirth()
                )
            );

            $this->userRepository->save($currentUser);

            $_SESSION['user'] = SessionUserDTO::fromUserEntity($currentUser);
        } catch (Exception $e) {
            return false;
        }

        return true;
    }
}