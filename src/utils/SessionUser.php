<?php

namespace app\utils;

use app\models\User;
use app\models\UserRole;

class SessionUser
{
    private string $id;
    private string $username;
    private string $email;
    private UserRole $role;

    public static function fromUserEntity(User $user): self
    {
        $sessionUser =  new self();

        $sessionUser->id = $user->getId();
        $sessionUser->username = $user->getUsername();
        $sessionUser->email = $user->getEmail();
        $sessionUser->role = $user->getRole();

        return $sessionUser;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): SessionUser
    {
        $this->id = $id;
        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): SessionUser
    {
        $this->username = $username;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): SessionUser
    {
        $this->email = $email;
        return $this;
    }

    public function getRole(): UserRole
    {
        return $this->role;
    }

    public function getRoleString(): string
    {
        return $this->role->toString();
    }

    public function setRole(UserRole $role): SessionUser
    {
        $this->role = $role;
        return $this;
    }
}