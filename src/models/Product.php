<?php

namespace app\models;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity, Table(name: 'products')]
class Product
{
    #[Id, Column, GeneratedValue]
    private ?int $id = null;
    #[Column]
    private string $name;
    #[Column]
    private string $description;
    #[Column]
    private int $price;
    #[Column(unique: true)]
    private int $barcode;
    #[Column]
    private DateTime $created;
    #[ManyToOne(targetEntity: Category::class)]
    private Category $category;
}