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
    private string $email;
    #[Column(nullable: true)]
    private string $phone;
    #[OneToMany(targetEntity: Transaction::class, mappedBy: 'customer')]
    private Collection $transactions;
}