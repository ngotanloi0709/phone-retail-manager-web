<?php

namespace app\controllers;

use app\services\AuthenticationService;
use app\services\ProductService;
use League\Plates\Engine;

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
        if ($category == 'new') {
            $category = $_POST['newCategoryName'];
        }

         if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $targetDirectory = "../public/image/";
            $targetFile = $targetDirectory . basename($_FILES['image']['name']);
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                $imgUrl = $targetFile;
            } else {
                throw new \Exception('Error moving uploaded file.');
            }
        } else {
            throw new \Exception('Error uploading file.');
        }

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
        if ($category == 'new') {
            $category = $_POST['new_category'];
        }

        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $targetDirectory = "../public/image/";
            $targetFile = $targetDirectory . basename($_FILES['image']['name']);
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                $imgUrl = $targetFile;
            } else {
                throw new \Exception('Error moving uploaded file.');
            }
        } else {
            $product = $this->productService->getProductById($id);
            $imgUrl = $product->getImageUrl();
        }
        
        
        //var_dump($barcode, $productName, $category, $price, $importPrice, $stock, $description, $imgUrl);
        if ($this->productService->updateProduct($id, $barcode, $productName, $category, $price, $importPrice, $stock, $description, $imgUrl)) {
            $_SESSION['alerts'][] = 'Chỉnh sửa sản phẩm thành công';
            header('Location: /product');
        } else {
            $_SESSION['alerts'][] = 'Chỉnh sửa sản phẩm thất bại';
            header('Location: /product/edit-product?id=' . $id);
        }
    }

    public function deleteProduct(): void
    {
        $id = $_GET['id'];
        if ($this->productService->deleteProduct($id)) {
            $_SESSION['alerts'][] = 'Xóa sản phẩm thành công';
            header('Location: /product');
        } else {
            $_SESSION['alerts'][] = 'Xóa sản phẩm thất bại';
            header('Location: /product');
        }
    } 

    public function getProductDetail(): void
    {
        $id = $_GET['id'];
        $product = $this->productService->getProductById($id);
        $this->render('product/product_detail', ['product' => $product]);
    }

    

}