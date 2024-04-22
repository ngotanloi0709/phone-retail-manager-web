<?php

namespace app\models;

use DateTime;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity, Table(name: 'login_emails')]
class LoginEmail
{
    #[Id, Column, GeneratedValue]
    private ?int $id = null;
    #[Column(nullable: true)]
    private string $email;
    #[Column(nullable: true)]
    private string $token;
    #[Column(nullable: true)]
    private DateTime $expiredAt;

    /**
     * @param string $email
     * @param string $token
     */
    public function __construct(string $email, string $token)
    {
        $this->email = $email;
        $this->token = $token;
        $this->expiredAt = new DateTime('+1 minute');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): LoginEmail
    {
        $this->id = $id;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): LoginEmail
    {
        $this->email = $email;
        return $this;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function setToken(string $token): LoginEmail
    {
        $this->token = $token;
        return $this;
    }

    public function getExpiredAt(): DateTime
    {
        return $this->expiredAt;
    }

    public function setExpiredAt(DateTime $expiredAt): LoginEmail
    {
        $this->expiredAt = $expiredAt;
        return $this;
    }
}