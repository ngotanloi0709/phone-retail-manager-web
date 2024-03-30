<?php

namespace app\models;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity, Table(name: 'transaction_details')]
class TransactionDetail
{
    #[Id, ManyToOne(targetEntity: Transaction::class)]
    private Transaction|null $order = null;

    #[Id, ManyToOne(targetEntity: Product::class)]
    private Product|null $product = null;

    #[Column]
    private int $quantity = 1;
}