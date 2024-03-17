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
    #[Column]
    private string $email;
    #[Column]
    private string $password;
    /** @var Collection */
    #[OneToMany(targetEntity: Order::class, mappedBy: 'user')]

    private Collection $orders;

    public function getId(): int|null
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
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