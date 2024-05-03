<?php 
use app\models\UserRole;

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
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-6">
                    <h4 class="card-title">Chi tiết sản phẩm</h4>
                </div>
                <div class="col-6 text-end">
                    <a href="/product" class="btn btn-outline-warning"><i class="fa-solid fa-list me-2"></i> Danh sách sản phẩm</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <img class="card-img-top" src="<?php echo str_replace('../public/image/', '../../image/', $product->getImageUrl()); ?>" alt="">
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="barcode">Mã sản phẩm</label>
                        <input type="text" class="form-control" id="barcode" name="barcode" value="<?php echo $product->getBarcode(); ?>" readonly>
                    </div>
                    <div class="form-group ">
                        <label for="name">Tên sản phẩm</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $product->getName(); ?>" readonly>
                    </div>
                    <div class="form-group ">
                        <label for="category">Loại sản phẩm</label>
                        <input type="text" class="form-control" id="category" name="category" value="<?php echo $product->getCategoryName(); ?>" readonly>
                    </div>
                    <div class="form-group ">
                        <label for="price">Giá bán</label>
                        <input type="text" class="form-control" id="price" name="price" value="<?php echo number_format($product->getPrice(), 0, ',', '.') . ' đ'; ?>" readonly>
                    </div>
                    <div class="form-group ">   
                        <label for="import_price">Giá nhập</label>
                        <input type="text" class="form-control" id="import_price" name="import_price" value="<?php echo number_format($product->getImportPrice(), 0, ',', '.') . ' đ';  ?>" readonly>
                    </div>
                    <div class="form-group ">
                        <label for="stock">Số Lượng</label>
                        <input type="number" class="form-control" id="stock" name="stock" value="<?php echo $product->getStock(); ?>" readonly>
                    </div>
                    <div class="form-group ">
                        <label for="description">Mô Tả</label>
                        <textarea class="form-control" id="description" name="description" readonly><?php echo $product->getDescription(); ?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->end('main') ?>
