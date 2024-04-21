<?php

namespace app\dto;

use DateTime;

class EditablePersonalInformationDTO
{
    const GENDER_FEMALE = "F";
    const GENDER_MALE = "M";

    private string $gender;
    private ?string $dateOfBirth;
    private ?string $address;

    public function fromRequest(array $data = []): self
    {
        $this->gender = $data['gender'];
        $this->dateOfBirth = $data['dateOfBirth'];
        $this->address = $data['address'];

        return $this;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;
        return $this;
    }

    public function isFemale(): bool
    {
        return $this->gender === self::GENDER_FEMALE;
    }

    public function getDateOfBirth(): ?string
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(string $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;
        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;
        return $this;
    }

}