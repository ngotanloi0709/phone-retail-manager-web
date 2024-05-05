<?php

/** @var SessionUserDTO $sessionUser */
$sessionUser = $_SESSION['user'] ?? null;

use app\models\UserRole;

use app\utils\ImageHelper;

$this->layout(
    'base',
    [
        'title' => 'Sản Phẩm',
        'header' => 'Sản Phẩm',
        'isShowAside' => false
    ]
)
?>

<?php $this->start('main') ?>
<link rel="stylesheet" href="../../style/product_details.css">
<div class="card-wrapper">
    <div class="card">
        <!-- card left -->
        <div class="product-imgs">
            <div class="img-display">
                <div class="img-showcase">
                    <img src="<?php echo ImageHelper::getDisplayStringData($product->getImageUrl())?>" alt="product image">
                </div>
            </div>
        </div>

        <!-- card right -->
        <div class="product-content">

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
                    <li>Mã vạch: <span><?php echo $product->getBarcode(); ?></span></li>
                    <li>Loại: <span><?php echo $product->getCategoryName(); ?></span></li>
                    <li>Số lượng: <span><?php echo $product->getStock(); ?></span></li>
                </ul>
            </div>

            <div class="purchase-info">
                <a href="/product" type="button" class="btn"><i class="fa-solid fa-circle-left icon"></i>Quay lại</a>
            </div>
        </div>


    </div>


</div>

<?php $this->end('main') ?>