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
    #[Column]
    private string $name;
    #[Column]
    private string $email;
    #[Column]
    private string $phone;
    #[OneToMany(targetEntity: Transaction::class, mappedBy: 'customer')]
    private Collection $transactions;
}