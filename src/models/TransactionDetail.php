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
    private ?Transaction $order = null;

    #[Id, ManyToOne(targetEntity: Product::class)]
    private ?Product $product = null;

    #[Column(nullable: true)]
    private int $quantity = 1;

    public function __construct(Transaction $order, Product $product, int $quantity)
    {
        $this->order = $order;
        $this->product = $product;
        $this->quantity = $quantity;
    }

    public function getOrder(): ?Transaction
    {
        return $this->order;
    }

    public function setOrder(?Transaction $order): TransactionDetail
    {
        $this->order = $order;
        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): TransactionDetail
    {
        $this->product = $product;
        return $this;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): TransactionDetail
    {
        $this->quantity = $quantity;
        return $this;
    }
}