<?php
// src/models/Transaction.php

namespace app\models;

use DateTime;
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
    #[Column]
    private int $givenMoney;
    #[Column]
    private DateTime $created;

    /** @var Collection */
    #[OneToMany(targetEntity: TransactionDetail::class, mappedBy: 'order')]
    private Collection $items;
    #[ManyToOne(targetEntity: User::class)]
    private User $user;
    #[ManyToOne(targetEntity: Customer::class)]
    private Customer $customer;
}