<?php

namespace app\dto;

use app\models\User;
use app\models\UserRole;
use Exception;

class SessionUserDTO
{
    private ?string $id;
    private ?string $username;
    private ?string $email;
    private ?UserRole $role;
    private ?string $avatar;
    private bool $isNeededToChangePassword = false;

    /**
     * @throws Exception
     */
    public static function fromUserEntity(User $user): self
    {
        $sessionUser =  new self();

        $sessionUser->id = $user->getId() != null ? $user->getId() : null;
        $sessionUser->username = $user->getUsername() != null ? $user->getUsername() : null;
        $sessionUser->email = $user->getEmail() != null ? $user->getEmail() : null;
        $sessionUser->role = $user->getRole() != null ? $user->getRole() : null;
        $sessionUser->avatar = $user->getAvatar() != null ? $user->getAvatar() : null;

        if (password_hash($user->getUsername(), PASSWORD_DEFAULT) == $user->getPassword()) {
            $sessionUser->isNeededToChangePassword = true;
        }

        return $sessionUser;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): SessionUserDTO
    {
        $this->id = $id;
        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): SessionUserDTO
    {
        $this->username = $username;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): SessionUserDTO
    {
        $this->email = $email;
        return $this;
    }

    public function getRole(): ?UserRole
    {
        return $this->role;
    }

    public function getRoleString(): ?string
    {
        return $this->role->toString();
    }

    public function setRole(UserRole $role): SessionUserDTO
    {
        $this->role = $role;
        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): SessionUserDTO
    {
        $this->avatar = $avatar;
        return $this;
    }

    public function isNeededToChangePassword(): bool
    {
        return $this->isNeededToChangePassword;
    }

    public function setIsNeededToChangePassword(bool $isNeededToChangePassword): SessionUserDTO
    {
        $this->isNeededToChangePassword = $isNeededToChangePassword;
        return $this;
    }
}