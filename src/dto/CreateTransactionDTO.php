<?php

namespace app\dto;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class CreateTransactionDTO
{
    private ?string $customerPhone;
    private ?int $givenMoney;
    private ?Collection $items;
    private ?array $productIdArray;
    private ?array $productQuantityArray;


    public function fromRequest(array $data = []): self
    {
        $this->customerPhone = $data['customerPhone'];
        $this->givenMoney = (int)str_replace(",", "", $data['givenMoney']);
        $this->items = new ArrayCollection();
        $this->productIdArray = $data['productId'];
        $this->productQuantityArray = $data['productQuantity'];

        return $this;
    }

    public function getCustomerPhone(): ?string
    {
        return $this->customerPhone;
    }

    public function setCustomerPhone(?string $customerPhone): CreateTransactionDTO
    {
        $this->customerPhone = $customerPhone;
        return $this;
    }

    public function getGivenMoney(): ?int
    {
        return $this->givenMoney;
    }

    public function setGivenMoney(?int $givenMoney): CreateTransactionDTO
    {
        $this->givenMoney = $givenMoney;
        return $this;
    }

    public function getItems(): ?Collection
    {
        return $this->items;
    }

    public function setItems(?Collection $items): CreateTransactionDTO
    {
        $this->items = $items;
        return $this;
    }

    public function getProductIdArray(): ?array
    {
        return $this->productIdArray;
    }

    public function setProductIdArray(?array $productIdArray): CreateTransactionDTO
    {
        $this->productIdArray = $productIdArray;
        return $this;
    }

    public function getProductQuantityArray(): ?array
    {
        return $this->productQuantityArray;
    }

    public function setProductQuantityArray(?array $productQuantityArray): CreateTransactionDTO
    {
        $this->productQuantityArray = $productQuantityArray;
        return $this;
    }
}