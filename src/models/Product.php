<?php

namespace app\models;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity, Table(name: 'products')]
class Product
{
    #[Id, Column, GeneratedValue]
    private int|null $id = null;

    #[Column]
    private string $name;

    #[Column]
    private int $price;

    public function getPrice(): int
    {
        return $this->price;
    }
}