<?php

namespace app\models;

use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Schema\Table;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;

#[Entity, Table(name: 'customers')]
class Customer
{
    #[Id, Column, GeneratedValue]
    private ?int $id = null;
    #[Column(nullable: true)]
    private string $name;
    #[Column(nullable: true)]
    private ?string $email;
    #[Column(nullable: true)]
    private string $phone;
    #[OneToMany(targetEntity: Transaction::class, mappedBy: 'customer')]
    private Collection $transactions;

    public function __construct(string $phone)
    {
        $this->name = 'Chưa có dữ liệu';
        $this->phone = $phone;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function getTransactionCount(): ?int
    {
        return count($this->transactions);
    }

    public function getTransactionTotal(): int
    {
        $total = 0;
        foreach ($this->transactions as $transaction) {
            $total += $transaction->getGivenMoney();
        }
        return $total;
    }

    public function getTransactionAverage(): float
    {
        return $this->getTransactionTotal() / $this->getTransactionCount();
    }
}