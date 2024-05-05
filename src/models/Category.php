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
    private ?int $id = null;
    #[Column(nullable: true)]
    private ?string $name;
    #[OneToMany(targetEntity: Product::class, mappedBy: 'category')]
    private Collection $products;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Category
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): Category
    {
        $this->name = $name;
        return $this;
    }

    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function setProducts(Collection $products): Category
    {
        $this->products = $products;
        return $this;
    }
}