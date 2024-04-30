<?php

namespace app\models;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity, Table(name: 'transactions')]
class Transaction
{
    #[Id, Column, GeneratedValue]
    private ?int $id = null;
    #[Column(nullable: true)]
    private int $givenMoney;
    #[Column(nullable: true)]
    private DateTime $created;

    /** @var Collection */
    #[OneToMany(targetEntity: TransactionDetail::class, mappedBy: 'order')]
    private Collection $items;
    #[ManyToOne(targetEntity: User::class)]
    private User $user;
    #[ManyToOne(targetEntity: Customer::class)]
    private ?Customer $customer;

    public function __construct(int $givenMoney, User $user, ?Customer $customer)
    {
        $this->givenMoney = $givenMoney;
        $this->items = new ArrayCollection();
        $this->user = $user;
        $this->customer = $customer;
        $this->created = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGivenMoney(): int
    {
        return $this->givenMoney;
    }

    public function getCreated(): DateTime
    {
        return $this->created;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function getItems(): Collection
    {
        return $this->items;
    }

    public function setItems(Collection $items): void
    {
        $this->items = $items;
    }
}