<?php

namespace app\services;

use app\models\User;
use app\models\UserRole;
use app\models\Product;
use app\repositories\ProductRepository;

class ProductService
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getProducts() : array {
        return $this->productRepository->findAll();
    }

    public function getProductById($id) {
        return $this->productRepository->findByID($id);
    }

    public function createProduct($name, $price, $stock) {
        $product = new Product($name, $price, $stock);
        $this->productRepository->save($product);
    }
}