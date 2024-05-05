<?php

namespace app\dto;


use Exception;

class EditCustomerInformationDTO
{
    private string $id;
    private ?string $name;
    private ?string $email;
    private ?string $phone;
    private ?string $address;
    public function fromRequest(array $data = []): self
    {
        // log all data from request
        $_SESSION['logger'][] = $data["avatar"];

        // end log all data from request
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->email = $data['email'];
        $this->phone = $data['phone'];
        $this->address = $data['address'];
        return $this;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): EditCustomerInformationDTO
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): ?string
    {
        if ($this->name == null) {
            return 'Chưa có dữ liệu';
        }
        return $this->name;
    }

    public function setName(string $name): EditCustomerInformationDTO
    {
        $this->name = $name;
        return $this;
    }

    public function getEmail(): ?string
    {
        if ($this->email == null) {
            return 'Chưa có dữ liệu';
        }
        return $this->email;
    }
    public function setEmail(string $email): EditCustomerInformationDTO
    {
        $this->email = $email;
        return $this;
    }

    public function getPhone(): ?string
    {
        if ($this->phone == null) {
            return 'Chưa có dữ liệu';
        }
        return $this->phone;
    }

    public function setPhone(string $phone): EditCustomerInformationDTO
    {
        $this->phone = $phone;
        return $this;
    }

    public function getAddress(): ?string
    {
        if ($this->address == null) {
            return 'Chưa có dữ liệu';
        }
        return $this->address;
    }

    public function setAddress(string $address): EditCustomerInformationDTO
    {
        $this->address = $address;
        return $this;
    }

}