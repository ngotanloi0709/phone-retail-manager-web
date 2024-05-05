<?php

namespace app\services;

use app\dto\EditablePersonalInformationDTO;
use app\dto\EditUserInformationDTO;
use app\dto\SessionUserDTO;
use app\models\User;
use app\models\UserRole;
use app\repositories\LoginEmailRepository;
use app\repositories\UserRepository;
use app\utils\AuthenticationValidateHelper;
use DateTime;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Exception;

class UserService
{
    public function __construct(
        private readonly UserRepository       $userRepository,
        private readonly EmailService         $emailService,
        private readonly AuthenticationService $authenticationService
    )
    {
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

            $user = new User($email, password_hash($password, PASSWORD_DEFAULT), explode('@', $email)[0], '', $role);

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
    public function changePersonalPassword(string $oldPassword, string $newPassword, string $repeatPassword): bool
    {
        try {
            $currentUser = $this->findUserById($_SESSION['user']->getId());

            if (!password_verify($oldPassword, $currentUser->getPassword())) {
                $_SESSION['alerts'][] = 'Mật khẩu cũ không đúng';
                return false;
            }

            $username = $currentUser->getUsername();
            if ($newPassword === $username) {
                $_SESSION['alerts'][] = 'Mật khẩu mới không được trùng với tên đăng nhập';
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

            $_SESSION['user'] = SessionUserDTO::fromUserEntity($currentUser);
            $_SESSION['isNeededChangePassword'] = false;
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

    /**
     * @throws ORMException
     */
    public function createNewUserByAdmin(string $email, string $name, UserRole $role): bool
    {
        try {
            if ($this->userRepository->findByEmail($email)) {
                $_SESSION['alerts'][] = 'Email đã tồn tại';
                return false;
            }

            $username = explode('@', $email)[0];

            if (strlen($username) < 6 || strlen($username) > 18) {
                $_SESSION['alerts'][] = 'Email có độ dài không hợp lệ (6-18 ký tự)';
                return false;
            }

            $user = new User($email, password_hash($username, PASSWORD_DEFAULT), $username, $name, $role);

            if ($role == UserRole::USER) {


                if ($this->emailService->sendLoginEmailOnAccountCreation($email)) {
                    $_SESSION['alerts'][] = 'Đã gửi email đăng nhâp cho người dùng';
                }
            }

            $this->userRepository->save($user);
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    public function findAllUsers(): array
    {
        return $this->userRepository->findAll();
    }

    /**
     * @throws ORMException
     */
    public function deleteUser(string $id): bool
    {
        try {
            /** @var SessionUserDTO $currentUserId */
            $currentUserId = $_SESSION['user']->getId();

            if ($currentUserId == (int) $id) {
                $_SESSION['alerts'][] = 'Không thể xóa tài khoản của chính mình';
                return false;
            }

            $user = $this->userRepository->find($id);

            if ($user == null) {
                $_SESSION['alerts'][] = 'Người dùng không tồn tại';
                return false;
            }

            $this->userRepository->delete($user);
        } catch (Exception $e) {
            $_SESSION['alerts'][] = 'Người dùng đã sinh dữ liệu giao dịch với khách hàng';
            return false;
        }

        return true;
    }

    /**
     * @throws ORMException
     */
    public function editUser(EditUserInformationDTO $editUserInformationDTO): bool
    {
        try {
            $user = $this->userRepository->find($editUserInformationDTO->getId());

            if ($user == null) {
                $_SESSION['alerts'][] = 'Người dùng không tồn tại';
                return false;
            }

            $user->setName($editUserInformationDTO->getName());
            $user->setIdentityNumber($editUserInformationDTO->getIdentityNumber());
            $user->setPhone($editUserInformationDTO->getPhone());
            $user->setAddress($editUserInformationDTO->getAddress());
            $user->setIsFemale($editUserInformationDTO->isFemale());
            $user->setDateOfBirth($editUserInformationDTO->getDateOfBirth());
            $user->setAvatar($editUserInformationDTO->getAvatar());

            /** @var SessionUserDTO $currentUser */
            $currentUser = $this->authenticationService->getCurrentUser();

            if ($currentUser->getId() == $user->getId()) {
                $_SESSION['alerts'][] = 'Không thể chỉnh sửa thông tin vai trò và trạng thái của chính mình';
            } else {
                $user->setRole($editUserInformationDTO->getRole());
                $user->setIsLocked($editUserInformationDTO->isLocked());
            }

            $this->userRepository->save($user);

            if ($currentUser->getId() == $user->getId()) {
                $_SESSION['user'] = SessionUserDTO::fromUserEntity($user);
            }
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * @throws ORMException
     */
    public function changeUserPassword(string $userId, string $newPassword, string $repeatPassword): bool
    {
        try {
            if ($userId == $_SESSION['user']->getId()) {
                $_SESSION['alerts'][] = 'Không thể đổi mật khẩu của chính mình';
                return false;
            }

            $user = $this->userRepository->find($userId);

            if ($user == null) {
                $_SESSION['alerts'][] = 'Người dùng không tồn tại';
                return false;
            }

            $username = $user->getUsername();

            if ($newPassword === $username) {
                $_SESSION['alerts'][] = 'Mật khẩu mới không được trùng với tên đăng nhập của người dùng';
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

            $this->userRepository->save($user);
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * @throws ORMException
     */
    public function changePasswordFirstTime(string $newPassword, string $repeatPassword): bool
    {
        try {
            $currentUser = $this->findUserById($_SESSION['user']->getId());

            $username = $currentUser->getUsername();
            if ($newPassword === $username) {
                $_SESSION['alerts'][] = 'Mật khẩu mới không được trùng với tên đăng nhập';
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

            $_SESSION['user'] = SessionUserDTO::fromUserEntity($currentUser);
            $_SESSION['isNeededChangePassword'] = false;
        } catch (Exception $e) {
            return false;
        }

        return true;
    }
}