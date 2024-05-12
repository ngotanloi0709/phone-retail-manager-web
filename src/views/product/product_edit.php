<?php

/** @var Product $product */
/** @var SessionUserDTO $sessionUser */
$sessionUser = $_SESSION['user'] ?? null;

use app\dto\SessionUserDTO;
use app\models\Product;
use app\utils\ImageHelper;

use app\models\UserRole;

$this->layout(
    'base',
    [
        'title' => 'Chỉnh Sửa Sản Phẩm',
        'header' => 'Chỉnh Sửa Sản Phẩm',
        'isShowAside' => false
    ]
); ?>

<?php $this->start('main') ?>
<link rel="stylesheet" href="../../style/product.css">
<div class="container">
    <div class="card">
        <?php if ($sessionUser->getRole() == UserRole::ADMIN) : ?>
            <div class="card-body">
                <form action="/product/edit-product?id=<?php echo $product->getId(); ?>" method="POST" enctype="multipart/form-data" id="editForm" onsubmit="return validateForm()">
                    <div class="row">
                        <div class="col-6">
                            <label for="name" class="mb-0">Tên sản phẩm:</label>
                            <input type="text" class="form-control mb-3" id="name" name="name" value="<?php echo $product->getName(); ?>" required>
                            <span id="nameError" style="color: red;"></span>
                        </div>
                        <div class="col-6">
                            <label for="barcode" class="mb-0">Mã vạch:</label>
                            <input type="number" class="form-control mb-3" id="barcode" name="barcode" value="<?php echo $product->getBarcode(); ?>">
                            <span id="barcodeError" style="color: red;"></span>
                        </div>
                        <div class="col-12">
                            <label for="category" class="col-12 mb-0">Loại sản phẩm:</label>
                            <div class="row mb-3">
                                <div class="col-4">
                                    <input class="form-check-input" type="radio" id="category_phone" name="category" value="Điện thoại" <?php echo ($product->getCategoryName() == 'Điện thoại') ? 'checked' : ''; ?> required>
                                    <label for="category_phone" class="mb-0">Điện thoại</label>
                                </div>
                                <div class="col-4">
                                    <input class="form-check-input" type="radio" id="category_accessory" name="category" value="Phụ kiện" <?php echo ($product->getCategoryName() == 'Phụ kiện') ? 'checked' : ''; ?> required>
                                    <label for="category_accessory" class="mb-0">Phụ kiện</label>
                                </div>
                                <div class="col-4">
                                    <input class="form-check-input" type="radio" id="category_other" name="category" value="Khác" <?php echo ($product->getCategoryName() == 'Khác') ? 'checked' : ''; ?> required>
                                    <label for="category_other" class="mb-0">Khác</label>
                                </div>
                            </div>
                            <span id="categoryError" style="color: red;"></span>
                        </div>
                        <div class="col-6">
                            <label for="price" class="mb-0">Giá bán:</label>
                            <input type="number" class="form-control mb-3" id="price" name="price" value="<?php echo $product->getPrice(); ?>">
                            <span id="priceError" style="color: red;"></span>
                        </div>
                        <div class="col-6">
                            <label for="import_price" class="mb-0">Giá nhập:</label>
                            <input type="number" class="form-control mb-3" id="import_price" name="import_price" value="<?php echo $product->getImportPrice(); ?>">
                            <span id="importPriceError" style="color: red;"></span>
                        </div>
                        <div class="col-12">
                            <label for="stock" class="mb-0">Số Lượng:</label>
                            <input type="number" class="form-control mb-3" id="stock" name="stock" value="<?php echo $product->getStock(); ?>" required>
                            <span id="stockError" style="color: red;"></span>
                        </div>
                        <div class="col-12">
                            <label for="description" class="mb-0">Mô Tả:</label>
                            <textarea class="form-control mb-3" id="description" name="description"><?php echo $product->getDescription(); ?></textarea>
                        </div>
                        <div class="col-12">
                            <label for="image" class="mb-0">Hình Ảnh:</label>
                            <input type="file" class="form-control mb-3" id="image" name="image" accept="image/png, image/jpeg, image/jpg, image/gif">
                            <span id="fileImageError" class="mb-2" style="color: red;  display: block;"></span>
                            <?php /** @var Product $product */
                            echo '<img class="rounded float-left mb-3"  id="image_preview" src="' . ImageHelper::getDisplayStringData($product->getImageUrl()) . '" onerror="this.onerror=null; this.src=\'/image/product-default-image.png\';">';
                            ?>
                            <input type="hidden" id="currentImage" name="currentImage" value="<?php echo $product->getImageUrl(); ?>">
                            <input type="hidden" id="isChangeImage" name="isChangeImage" value="0">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-success">Lưu thay đổi</button>
                            <button type="button" class="btn btn-danger">
                                <a href="/product" style="color: white; text-decoration: none;">Hủy</a>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        <?php endif; ?>
    </div>

</div>

<script>
    var fileInput = document.getElementById('image');
    fileInput.addEventListener('change', function() {
        $('#isChangeImage').val(1);
        var file = this.files[0];
        if (file) {
            var fileName = file.name;
            var fileExtension = fileName.split('.').pop().toLowerCase();
            var allowedExtensions = ['png', 'jpeg', 'jpg', 'gif'];

            if (!allowedExtensions.includes(fileExtension)) {
                document.getElementById('fileImageError').innerText = 'Tệp tải lên phải là một ảnh (PNG, JPEG, JPG, hoặc GIF).';
                isValid = false;
            } else {
                document.getElementById('fileImageError').innerText = '';

                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('image_preview').src = e.target.result;
                };

                reader.readAsDataURL(file);
            }
        }
    });
    

    function validateForm() {
        var isValid = true;
        var barcode = document.getElementById('barcode').value;
        var name = document.getElementById('name').value;
        var category = document.querySelector('input[name="category"]:checked');
        var price = document.getElementById('price').value;
        var importPrice = document.getElementById('import_price').value;
        var stock = document.getElementById('stock').value;
        var image = document.getElementById('image').value;

        if (barcode.length > 10 || isNaN(barcode) || barcode < 0) {
            document.getElementById('barcodeError').innerText = 'Mã vạch phải là số và không quá 10 chữ số';
            isValid = false;
        } else {
            document.getElementById('barcodeError').innerText = '';
        }

        if (name.length === 0 || name === null) {
            document.getElementById('nameError').innerText = 'Tên sản phẩm không được để trống';
            isValid = false;
        } else {
            document.getElementById('nameError').innerText = '';
        }

        if (category === null) {
            document.getElementById('categoryError').innerText = 'Loại sản phẩm không được để trống';
            isValid = false;
        } else {
            document.getElementById('categoryError').innerText = '';
        }

        if (price.length > 10 || isNaN(price) || price < 0) {
            document.getElementById('priceError').innerText = 'Giá bán phải lớn hơn bằng 0 và không quá 10 chữ số';
            isValid = false;
        } else {
            document.getElementById('priceError').innerText = '';
        }

        if (importPrice.length > 10 || isNaN(importPrice) || importPrice < 0) {
            document.getElementById('importPriceError').innerText = 'Giá nhập phải lớn hơn bằng 0 và không quá 10 chữ số';
            isValid = false;
        } else {
            document.getElementById('importPriceError').innerText = '';
        }

        if (stock.length > 10 || isNaN(stock) || stock < 0) {
            document.getElementById('stockError').innerText = 'Số lượng phải lớn hơn bằng 0 và không quá 10 chữ số';
            isValid = false;
        } else {
            document.getElementById('stockError').innerText = '';
        }


        var descriptionInput = document.getElementById('description');
        var description = descriptionInput.value;
        var maxChars = 255;

        if (description.length > maxChars) {
            descriptionInput.value = description.slice(0, maxChars);
            document.getElementById('descriptionError').innerText = 'Mô tả không được dài hơn ' + maxChars + ' ký tự';
            isValid = false;
        } else {
            document.getElementById('descriptionError').innerText = '';
        }

        var fileInput = document.getElementById('image');
        var file = fileInput.files[0];

        if (file) {
            var fileName = file.name;
            var fileExtension = fileName.split('.').pop().toLowerCase();
            var allowedExtensions = ['png', 'jpeg', 'jpg', 'gif'];
            var fileSize = file.size / 1024 / 1024;

            if (fileSize > 2) {
                document.getElementById('fileImageError').innerText = 'Kích thước file không được lớn hơn 2MB';
                isValid = false;
            } else {
                document.getElementById('fileImageError').innerText = '';
            }

            if (!allowedExtensions.includes(fileExtension)) {
                document.getElementById('fileImageError').innerText = 'Định dạng file không hợp lệ. Chỉ chấp nhận các định dạng: PNG, JPEG, JPG, GIF';
                isValid = false;
            } else {
                document.getElementById('fileImageError').innerText = '';
            }
        }

        return isValid;
    }
</script>


<?php $this->end('main'); ?>
