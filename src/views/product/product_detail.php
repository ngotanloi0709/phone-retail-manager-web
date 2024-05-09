<?php

/** @var SessionUserDTO $sessionUser */
$sessionUser = $_SESSION['user'] ?? null;

use app\models\Product;
use app\models\UserRole;

use app\utils\ImageHelper;

/** @var string $header */
$this->layout(
    'base',
    [
        'title' => 'Chi tiết sản phẩm',
        'header' => 'Chi tiết sản phẩm',
        'isShowAside' => false
    ]
)
?>

<?php $this->start('main') ?>
<link rel="stylesheet" href="../../style/product_details.css">
<div class="card-wrapper">
    <div class="card">
        <div class="row">
            <div class="product-imgs col-12 col-lg-6">
                <div class="img-showcase">
                    <img src="<?php /** @var Product $product */
                                echo ImageHelper::getDisplayStringData($product->getImageUrl()) ?>" alt="product image">
                </div>
            </div>

            <div class="product-content col-12 col-lg-6">
                <h2 class="product-title"><?php echo $product->getName(); ?></h2>
                <div class="product-price">
                    <?php if ($sessionUser->getRole() == UserRole::ADMIN) : ?>
                        <p class="import-price">Giá nhập: <span><?php echo number_format($product->getImportPrice(), 0, ',', '.') . ' đ'; ?></span></p>
                    <?php endif; ?>
                    <p class="price">Giá bán: <span><?php echo number_format($product->getPrice(), 0, ',', '.') . ' đ'; ?></span></p>
                </div>
                <div class="product-detail">
                    <h2>Mô tả:</h2>
                    <p><?php echo $product->getDescription(); ?></p>
                    <ul>
                        <li><i class="fa-solid fa-barcode"></i>Mã vạch: <span><?php echo $product->getBarcode(); ?></span></li>
                        <li><i class="fa-solid fa-layer-group"></i>Loại: <span><?php echo $product->getCategoryName(); ?></span></li>
                        <li><i class="fa-solid fa-list-ol"></i>Số lượng: <span><?php echo $product->getStock(); ?></span></li>
                        <li><i class="fa-solid fa-calendar-days"></i>Ngày tạo: <span><?php echo $product->getCreated(); ?></span></li>
                    </ul>
                </div>
                <div class="purchase-info">
                    <a href="/product" type="button" class="btn"><i class="fa-solid fa-circle-left icon"></i>Quay lại</a>
                </div>
            </div>
        </div>
    </div>


</div>

<?php $this->end('main') ?>
