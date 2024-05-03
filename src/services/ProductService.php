<?php

namespace app\services;

use app\models\Category;
use app\models\Product;
use app\repositories\CategoryRepository;
use app\repositories\ProductRepository;
use app\repositories\TransactionDetailRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Exception;

class ProductService
{
    public function __construct(
        private readonly ProductRepository           $productRepository,
        private readonly CategoryRepository          $categoryRepository,
        private readonly TransactionDetailRepository $transactionDetailRepository,
    )
    {
        //
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
        } else {
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

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function updateProduct(int $id, ?int $barcode, ?string $productName, ?string $categoryString, ?int $price, ?int $importPrice, ?int $stock, ?string $description, ?string $imgUrl): bool
    {
        try {
            $category = $this->categoryRepository->find(intval($categoryString));

            /** @var Product $product */
            $product = $this->productRepository->findByID($id);

            $product->setBarcode($barcode);
            $product->setName($productName);
            $product->setCategory($category);
            $product->setPrice($price);
            $product->setImportPrice($importPrice);
            $product->setStock($stock);
            $product->setDescription($description);
            $product->setImageUrl($imgUrl);

            $this->productRepository->save($product);
            return true;
        } catch (Exception $e) {
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
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}
