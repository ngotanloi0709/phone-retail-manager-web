<?php

namespace app\services;

use app\dto\SessionUserDTO;
use app\models\User;
use app\models\UserRole;
use app\repositories\LoginEmailRepository;
use app\repositories\UserRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Exception;

class AuthenticationService
{
    public function __construct(
        private readonly UserRepository       $userRepository,
        private readonly LoginEmailRepository $loginEmailRepository
    )
    {
        //
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     * @throws Exception
     */
    public function login(string $username, string $password): bool
    {
        try {
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

            if ($user->isFirstTimeLogin()) {
                $_SESSION['alerts'][] = 'Xin hãy kiểm tra Email và đăng nhập bằng đường link được cung cấp!';
                return false;
            }

            $_SESSION['user'] = SessionUserDTO::fromUserEntity($user);
        } catch (Exception $e) {
            $_SESSION['alerts'][] = 'Đã xảy ra lỗi trong quá trình đăng nhập!';
            return false;
        }

        return true;
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    private function createAdminBuiltInAccount(): void
    {
        $admin = new User('admin@email.com', password_hash('admin', PASSWORD_DEFAULT), 'admin', '', UserRole::ADMIN);
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

    /**
     * @throws ORMException
     */
    public function loginByEmail(string $token, string $email): bool
    {
        try {
            $loginEmail = $this->loginEmailRepository->findByEmailAndToken($email, $token);

            if (!$loginEmail) {
                $_SESSION['alerts'][] = 'Đường link đăng nhập không hợp lệ!';
                return false;
            }

            if ($loginEmail->isExpired()) {
                $_SESSION['alerts'][] = 'Đường link đăng nhập đã hết hạn (1 phút)!';
                return false;
            }

            /** @var User $user */
            $user = $this->userRepository->findByEmail($email);

            if (!$user) {
                $_SESSION['alerts'][] = 'Tài khoản không tồn tại!';
                return false;
            }

            $user->setIsFirstTimeLogin(false);
            $this->userRepository->save($user);

            $_SESSION['user'] = SessionUserDTO::fromUserEntity($user);
        } catch (Exception $e) {
            $_SESSION['alerts'][] = 'Đã xảy ra lỗi với đường link đăng nhập! Hãy liên hệ với quản trị viên để nhận lại Email!';
            return false;
        }

        return true;
    }
}