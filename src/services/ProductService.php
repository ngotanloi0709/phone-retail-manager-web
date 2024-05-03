<?php

namespace app\services;

use app\models\Category;
use app\models\User;
use app\models\UserRole;
use app\models\Product;
use app\models\Transaction;
use app\repositories\CategoryRepository;
use app\repositories\ProductRepository;
use app\repositories\UserRepository;
use app\repositories\UserRoleRepository;
use app\services\CategoryService;
use app\services\TransactionDetailService;
use app\services\TransactionService;
use app\repositories\TransactionRepository;
use app\repositories\TransactionDetailRepository;

class ProductService
{

    private $productRepository;
    private $categoryRepository;
    private $categoryService;
    private $TransactionRepository;
    private $transactionDetailRepository;
    private $transactionDetailService;

    public function __construct(
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository,
        CategoryService $categoryService,
        TransactionDetailRepository $transactionDetailRepository,
    ) {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->categoryService = $categoryService;
        $this->transactionDetailRepository = $transactionDetailRepository;
    }

    public function getProducts(): array
    {
        return $this->productRepository->findAll();
    }

    public function getProductById($id)
    {
        return $this->productRepository->findByID($id);
    }

    public function getCategories()
    {
        return $this->categoryRepository->findAll();
    }

    public function getCategoryById($id)
    {
        return $this->categoryRepository->findByID($id);
    }

    public function createProduct(int $barcode, string $productName, string $categoryString, int $price, int $importPrice, int $stock, string $description, string $imgUrl): bool
    {
        $createdDateTime = new \DateTime();
        
        if (is_numeric($categoryString)) {
            $category = $this->categoryRepository->find(intval($categoryString));
        } else{
            $category = $this->categoryRepository->getCategoryByName($categoryString);
        }
        if ($category == null) {
            $category = new Category();
            $category->setName($categoryString);
            $this->categoryRepository->save($category);
        }
        
        try {
            $product = new Product();
            $product->setBarcode($barcode);
            $product->setName($productName);
            $product->setPrice($price);
            $product->setImportPrice($importPrice);
            $product->setStock($stock);
            $product->setDescription($description);
            $product->setCreated($createdDateTime);
            $product->setImageUrl($imgUrl);
            $product->setCategory($category);
            $this->productRepository->save($product);
            return true;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function updateProduct(int $id, int $barcode, string $productName, int $categoryString, int $price, int $importPrice, int $stock, string $description, string $imgUrl): bool
    {
        if (is_numeric($categoryString)) {
            $category = $this->categoryRepository->find(intval($categoryString));
        } else{
            $category = $this->categoryRepository->getCategoryByName($categoryString);
        }
        if ($category == null) {
            $category = new Category();
            $category->setName($categoryString);
            $this->categoryRepository->save($category);
        }
        try {
            $product = $this->productRepository->findByID($id);
            $product->setBarcode($barcode);
            $product->setName($productName);
            $product->setCategory($this->categoryService->getCategoryById($category));
            $product->setPrice($price);
            $product->setImportPrice($importPrice);
            $product->setStock($stock);
            $product->setDescription($description);
            $product->setImageUrl($imgUrl);

            $this->productRepository->save($product);
            return true;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function deleteProduct(int $id): bool
    {
        if ($this->transactionDetailRepository->findByProduct($id) != null) {
            return false;
        }
        try {
            $product = $this->productRepository->findByID($id);
            $this->productRepository->delete($product);
            return true;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}
