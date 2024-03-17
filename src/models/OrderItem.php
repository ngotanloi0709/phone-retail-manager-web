<?php

namespace app\models;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity, Table(name: 'order_items')]
class OrderItem
{
    #[Id, ManyToOne(targetEntity: Order::class)]
    private Order|null $order = null;

    #[Id, ManyToOne(targetEntity: Product::class)]
    private Product|null $product = null;

    #[Column]
    private int $amount = 1;

    #[Column]
    private int $price;

    public function __construct(Order $order, Product $product, int $amount = 1)
    {
        $this->order = $order;
        $this->product = $product;
        $this->price = $product->getPrice();
    }
}