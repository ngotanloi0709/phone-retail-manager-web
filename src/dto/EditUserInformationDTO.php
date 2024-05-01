<?php

namespace app\dto;

use app\models\UserRole;
use DateTime;
use Exception;

class EditUserInformationDTO
{
    private string $id;
    private string $name;
    private string $identityNumber;
    private string $phone;
    private string $address;
    private bool $isFemale;
    private DateTime $dateOfBirth;
    private UserRole $role;
    private bool $isLocked;
    private ?string $avatar;

    public function fromRequest(array $data = []): self
    {
        // log all data from request
        $_SESSION['logger'][] = $data["avatar"];

        // end log all data from request
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->identityNumber = $data['identityNumber'];
        $this->phone = $data['phone'];
        $this->address = $data['address'];
        $this->isFemale = $data['isFemale'] === '1';
        $this->dateOfBirth = DateTime::createFromFormat('Y-m-d', $data['dateOfBirth']);
        $this->role = $data['role'] === 'admin' ? UserRole::ADMIN : UserRole::USER;
        $this->isLocked = $data['isLocked'] === '1';
        $this->avatar = $data['avatar'];

        return $this;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): EditUserInformationDTO
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): EditUserInformationDTO
    {
        $this->name = $name;
        return $this;
    }

    public function getIdentityNumber(): string
    {
        return $this->identityNumber;
    }

    public function setIdentityNumber(string $identityNumber): EditUserInformationDTO
    {
        $this->identityNumber = $identityNumber;
        return $this;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): EditUserInformationDTO
    {
        $this->phone = $phone;
        return $this;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): EditUserInformationDTO
    {
        $this->address = $address;
        return $this;
    }

    public function isFemale(): bool
    {
        return $this->isFemale;
    }

    public function setIsFemale(bool $isFemale): EditUserInformationDTO
    {
        $this->isFemale = $isFemale;
        return $this;
    }

    public function getDateOfBirth(): DateTime
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(DateTime $dateOfBirth): EditUserInformationDTO
    {
        $this->dateOfBirth = $dateOfBirth;
        return $this;
    }

    public function getRole(): UserRole
    {
        return $this->role;
    }

    public function setRole(UserRole $role): EditUserInformationDTO
    {
        $this->role = $role;
        return $this;
    }

    public function isLocked(): bool
    {
        return $this->isLocked;
    }

    public function setIsLocked(bool $isLocked): EditUserInformationDTO
    {
        $this->isLocked = $isLocked;
        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): EditUserInformationDTO
    {
        $this->avatar = $avatar;
        return $this;
    }
}