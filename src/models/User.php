<?php

namespace app\models;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity, Table(name: 'users')]
class User
{
    #[Id, Column, GeneratedValue]
    private int|null $id = null;
    #[Column(unique: true)]
    private string $email;
    #[Column]
    private string $password;
    #[Column(unique: true)]
    private string $username;
    #[Column]
    private string $name;
    #[Column(type: 'blob')]
    private $avatar;
    #[Column]
    private bool $isLocked = false;
    #[Column(type: 'string', enumType: UserRole::class)]
    private UserRole $role = UserRole::ADMIN;
    /** @var Collection */
    #[OneToMany(targetEntity: Transaction::class, mappedBy: 'user')]
    private Collection $transactions;

    public function getId(): int|null
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getRole(): UserRole
    {
        return $this->role;
    }

    public function setRole(UserRole $role): void
    {
        $this->role = $role;
    }

    public function __toString(): string
    {
        return sprintf(
            'User(id: %d, email: %s, password: %s)',
            $this->id,
            $this->email,
            $this->password
        );
    }
}