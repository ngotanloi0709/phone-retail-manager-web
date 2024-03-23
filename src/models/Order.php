<?php
// src/models/Order.php

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

#[Entity, Table(name: 'orders')]
class Order
{
    #[Id, Column, GeneratedValue]
    private int|null $id = null;

    /** @var Collection */
    #[OneToMany(targetEntity: OrderItem::class, mappedBy: 'order')]
    private Collection $items;

    #[Column]
    private bool $paid = false;
    #[Column]
    private bool $shipped = false;
    #[Column]
    private DateTime $created;
    #[ManyToOne(targetEntity: User::class)]
    private User $user;

    public function __construct() {
        $this->items = new ArrayCollection();
        $this->created = new DateTime("now");
    }
}