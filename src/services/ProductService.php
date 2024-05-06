<?php

namespace app\services;

use app\models\Category;
use app\models\Product;
use app\repositories\CategoryRepository;
use app\repositories\ProductRepository;
use app\repositories\TransactionDetailRepository;
use DateTime;
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


    /**
     * @throws ORMException
     */
    public function createProduct(int $barcode, string $productName, string $categoryString, int $price, int $importPrice, int $stock, string $description, string $imgUrl): bool
    {
        try {
            /** @var DateTime $createdDateTime */
            /** @var Category $category */

            $createdDateTime = new DateTime();
            $category = $this->categoryRepository->getCategoryByName($categoryString);

            if ($category == null) {
                $category = new Category();
                $category->setName($categoryString);
                $this->categoryRepository->save($category);
            }

            if ($this->IsBarcodeExist($barcode)) {
                $_SESSION['alerts'][] = 'Mã vạch đã tồn tại';
                return false;
            }

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
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return false;
        }

        return true;
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function updateProduct(int $id, ?int $barcode, ?string $productName, ?string $categoryString, ?int $price, ?int $importPrice, ?int $stock, ?string $description, ?string $imgUrl): bool
    {
        try {
            /** @var Category $category */
            $category = $this->categoryRepository->getCategoryByName($categoryString);

            if ($category == null) {
                $category = new Category();
                $category->setName($categoryString);
                $this->categoryRepository->save($category);
            }

            /** @var Product $product */
            $product = $this->productRepository->findByID($id);

            if ($product == null) {
                $_SESSION['alerts'][] = 'Sản phẩm không tồn tại';
                return false;
            }

            if ($barcode != null && $barcode != $product->getBarcode() && $this->IsBarcodeExist($barcode)) {
                $_SESSION['alerts'][] = 'Mã vạch đã tồn tại';
                return false;
            } else {
                $product->setBarcode($barcode);
            }

            $product->setName($productName);
            $product->setCategory($category);
            $product->setPrice($price);
            $product->setImportPrice($importPrice);
            $product->setStock($stock);
            $product->setDescription($description);
            if ($imgUrl != null) {
                $product->setImageUrl($imgUrl);
            }

            $this->productRepository->save($product);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @throws ORMException
     */
    public function deleteProduct(int $id): bool
    {
        try {
            /** @var Product $product */
            $product = $this->productRepository->findByID($id);

            if ($product == null) {
                $_SESSION['alerts'][] = 'Sản phẩm không tồn tại';
                return false;
            }

            $this->productRepository->delete($product);
        } catch (Exception $e) {
            $_SESSION['alerts'][] = 'Thông tin sản phẩm đang nằm trong đơn hàng, không thể xóa';
            return false;
        }

        return true;
    }

    private function IsBarcodeExist(int $barcode): bool
    {
        return $this->productRepository->findByBarcode($barcode) != null;
    }
}
