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
    private ?int $barcode = null;
    #[Column(nullable: true)]
    private DateTime $created;
    #[ManyToOne(targetEntity: Category::class)]
    private Category $category;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Product
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Product
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): Product
    {
        $this->description = $description;
        return $this;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): Product
    {
        $this->price = $price;
        return $this;
    }

    public function getImportPrice(): int
    {
        return $this->import_price;
    }

    public function setImportPrice(int $import_price): Product
    {
        $this->import_price = $import_price;
        return $this;
    }
    public function getProfit(): int
    {
        return $this->price - $this->import_price;
    }
    public function getStock(): int
    {
        return $this->stock;
    }

    public function setStock(int $stock): Product
    {
        $this->stock = $stock;
        return $this;
    }

    public function getBarcode(): ?int
    {
        return $this->barcode;
    }

    public function setBarcode(?int $barcode): Product
    {
        $this->barcode = $barcode;
        return $this;
    }

    public function getCreated(): DateTime
    {
        return $this->created;
    }

    public function setCreated(DateTime $created): Product
    {
        $this->created = $created;
        return $this;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): Product
    {
        $this->category = $category;
        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'import_price' => $this->import_price,
            'stock' => $this->stock,
            'barcode' => $this->barcode,
            'created' => $this->created,
            //chỗ này thêm toArray() thì có lỗi (khum bt)
            'category' => $this->category
        ];
    }
}