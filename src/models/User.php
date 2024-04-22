<?php

namespace app\models;

use DateTime;
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
    private ?int $id = null;
    #[Column(unique: true)]
    private ?string $email;
    #[Column]
    private ?string $password;
    #[Column(unique: true)]
    private ?string $username;
    #[Column(nullable: true)]
    private ?string $name;
    #[Column(nullable: true)]
    private ?string $address;
    #[Column(nullable: true)]
    private ?string $phone;
    #[Column(nullable: true)]
    private ?string $identityNumber;
    #[Column]
    private bool $isFemale = false;
    #[Column(nullable: true)]
    private ?DateTime $dateOfBirth = null;
    #[Column(type: 'text', nullable: true)] // save as base64 dataURL
    private ?string $avatar;
    #[Column]
    private bool $isLocked = false;
    #[Column]
    private bool $isFirstTimeLogin = true;
    #[Column(type: 'string', enumType: UserRole::class)]
    private UserRole $role = UserRole::USER;
    /** @var Collection */
    #[OneToMany(targetEntity: Transaction::class, mappedBy: 'user')]
    private Collection $transactions;

    /**
     * @param string $email
     * @param string $password
     * @param string $username
     * @param UserRole $role
     */
    public function __construct(string $email, string $password, string $username, UserRole $role)
    {
        $this->email = $email;
        $this->password = $password;
        $this->username = $username;
        $this->role = $role;

        if ($role == UserRole::ADMIN) $this->isFirstTimeLogin = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): User
    {
        $this->id = $id;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): User
    {
        $this->password = $password;
        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): User
    {
        $this->username = $username;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): User
    {
        $this->name = $name;
        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): User
    {
        $this->avatar = $avatar;
        return $this;
    }

    public function isLocked(): bool
    {
        return $this->isLocked;
    }

    public function setIsLocked(bool $isLocked): User
    {
        $this->isLocked = $isLocked;
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

    public function setRole(UserRole $role): User
    {
        $this->role = $role;
        return $this;
    }

    public function getTransactions(): ?Collection
    {
        return $this->transactions;
    }

    public function setTransactions(Collection $transactions): User
    {
        $this->transactions = $transactions;
        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): User
    {
        $this->address = $address;
        return $this;
    }

    public function getIdentityNumber(): ?string
    {
        return $this->identityNumber;
    }

    public function setIdentityNumber(string $identityNumber): User
    {
        $this->identityNumber = $identityNumber;
        return $this;
    }

    public function isFemale(): bool
    {
        return $this->isFemale;
    }

    public function setIsFemale(bool $isFemale): User
    {
        $this->isFemale = $isFemale;
        return $this;
    }

    public function getDateOfBirth(): ?DateTime
    {
        return $this->dateOfBirth;
    }

    public function getDateOfBirthString(): ?string
    {
        return $this->dateOfBirth->format('d-m-Y');
    }

    public function setDateOfBirth(?DateTime $dateOfBirth): User
    {
        $this->dateOfBirth = $dateOfBirth;
        return $this;
    }

    public function isFirstTimeLogin(): bool
    {
        return $this->isFirstTimeLogin;
    }

    public function setIsFirstTimeLogin(bool $isFirstTimeLogin): User
    {
        $this->isFirstTimeLogin = $isFirstTimeLogin;
        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): User
    {
        $this->phone = $phone;
        return $this;
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