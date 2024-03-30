<?php

namespace app\models;

use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Schema\Table;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;

#[Entity, Table(name: 'categories')]
class Category
{
    #[Id, Column, GeneratedValue]
    private int $id;
    #[Column]
    private string $name;
    #[OneToMany(targetEntity: Product::class, mappedBy: 'category')]
    private Collection $products;

}