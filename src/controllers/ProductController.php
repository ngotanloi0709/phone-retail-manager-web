<?php

namespace app\controllers;

use app\services\AuthenticationService;
use app\services\ProductService;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use League\Plates\Engine;
use app\utils\ImageHelper;

class ProductController extends Controller
{
    private ProductService $productService;

    public function __construct(Engine $engine, AuthenticationService $authenticationService, ProductService $productService)
    {
        parent::__construct($engine, $authenticationService);
        $this->productService = $productService;

    }

    public function getProducts(): void
    {
        $products = $this->productService->getProducts();
        $this->render('product/product_management', ['products' => $products]);
    }

    public function getAddProduct(): void
    {
        $this->render('product/product_create', ['categories' => $this->productService->getCategories()]);
    }

    public function postAddProduct(): void
    {

        $category = $_POST['category'];
        $imgUrl = ImageHelper::uploadImage('image');
        $barcode = isset($_POST['barcode']) ? intval($_POST['barcode']) : null;
        $productName = $_POST['name'];
        $price = isset($_POST['price']) ? intval($_POST['price']) : null;
        $importPrice = isset($_POST['import_price']) ? intval($_POST['import_price']) : null;
        $stock = isset($_POST['stock']) ? intval($_POST['stock']) : null;
        $description = $_POST['description'];

        if ($this->productService->createProduct($barcode, $productName, $category, $price, $importPrice, $stock, $description, $imgUrl)) {
            $_SESSION['alerts'][] = 'Tạo sản phẩm thành công';
            header('Location: /product/');
        } else {
            $_SESSION['alerts'][] = 'Tạo sản phẩm thất bại';
            header('Location: /product/add-product');
        }
    }

    public function getEditProduct(): void
    {
        $id = $_GET['id'];
        $product = $this->productService->getProductById($id);
        $this->render('product/product_edit', ['product' => $product, 'categories' => $this->productService->getCategories()]);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function postEditProduct(): void
    {
        $id = $_GET['id'];
        $barcode = isset($_POST['barcode']) ? intval($_POST['barcode']) : null;
        $productName = $_POST['name'];
        $price = isset($_POST['price']) ? intval($_POST['price']) : null;
        $importPrice = isset($_POST['import_price']) ? intval($_POST['import_price']) : null;
        $stock = isset($_POST['stock']) ? intval($_POST['stock']) : null;
        $description = $_POST['description'];
        $category = $_POST['category'];
        $imgUrl = ImageHelper::uploadImage('image');
        
        if ($this->productService->updateProduct($id, $barcode, $productName, $category, $price, $importPrice, $stock, $description, $imgUrl)) {
            $_SESSION['alerts'][] = 'Chỉnh sửa sản phẩm thành công';
            header('Location: /product');
        } else {
            $_SESSION['alerts'][] = 'Chỉnh sửa sản phẩm thất bại';
            header('Location: /product/edit-product?id=' . $id);
        }
    }

    /**
     * @throws ORMException
     */
    public function deleteProduct(): void
    {
        $id = $_GET['id'];

        if ($this->productService->deleteProduct($id)) {
            $_SESSION['alerts'][] = 'Xóa sản phẩm thành công';
        } else {
            $_SESSION['alerts'][] = 'Xóa sản phẩm thất bại';
        }

        header('Location: /product');
    }

    public function getProductDetail(): void
    {
        $id = $_GET['id'];
        $product = $this->productService->getProductById($id);
        $this->render('product/product_detail', ['product' => $product]);
    }


}