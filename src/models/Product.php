<?php

namespace app\models;

use DateTime;
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
    #[Column(nullable: true)]
    private string $name;
    #[Column(nullable: true)]
    private string $description;
    #[Column(nullable: true)]
    private int $price;
    #[Column(nullable: true)]
    private int $import_price;
    #[Column(nullable: true)]
    private int $stock;
    #[Column(unique: true, nullable: true)]
    private int $barcode;
    #[Column(nullable: true)]
    private DateTime $created;
    #[ManyToOne(targetEntity: Category::class)]
    private Category $category;
}