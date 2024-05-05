<?php

/** @var SessionUserDTO $sessionUser */
$sessionUser = $_SESSION['user'] ?? null;

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
<link rel="stylesheet" href="../../style/product.css">
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-6">
                    <h4 class="card-title">Thêm sản phẩm</h4>
                </div>
                <div class="col-6 text-end">
                    <a href="/product" class="btn btn-outline-warning"><i class="fa-solid fa-list me-2"></i>Danh sách sản phẩm</a>
                </div>
            </div>
        </div>
        <?php if ($sessionUser->getRole() == UserRole::ADMIN) : ?>
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data" id="addProductForm" onsubmit="return validateForm()">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="image">Hình Ảnh:</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/png, image/jpeg, image/jpg, image/gif" onchange="previewImage(event)" required>
                                <img  id="imagePreview" src="#" alt="" style="display: none; margin-top: 10px; max-width: 100%; height: auto;">
                                <span id="fileImageError" style="color: red;"></span>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="barcode">Mã vạch:</label>
                                <input type="text" class="form-control" id="barcode" name="barcode" required>
                                <span id="barcodeError" style="color: red;"></span>
                            </div>
                            <div class="form-group">
                                <label for="name">Tên sản phẩm:</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                                <span id="nameError" style="color: red;"></span>
                            </div>
                            <div class="form-group">
                                <label>Loại sản phẩm:</label>
                                <div>
                                    <input type="radio" id="category_phone" name="category" value="Điện thoại" required>
                                    <label for="category_phone">Điện thoại</label>
                                </div>
                                <div>
                                    <input type="radio" id="category_accessory" name="category" value="Phụ kiện" required>
                                    <label for="category_accessory">Phụ kiện</label>
                                </div>
                                <div>
                                    <input type="radio" id="category_other" name="category" value="Khác" required>
                                    <label for="category_other">Khác</label>
                                </div>
                                <span id="categoryError" style="color: red;"></span>
                            </div>
                            <div class="form-group">
                                <label for="price">Giá bán:</label>
                                <input type="number" class="form-control" id="price" name="price" required>
                                <span id="priceError" style="color: red;"></span>
                            </div>
                            <div class="form-group">
                                <label for="price">Giá nhập:</label>
                                <input type="number" class="form-control" id="import_price" name="import_price" required>
                                <span id="importPriceError" style="color: red;"></span>
                            </div>
                            <div class="form-group">
                                <label for="stock">Số Lượng:</label>
                                <input type="number" class="form-control" id="stock" name="stock" required>
                                <span id="stockError" style="color: red;"></span>
                            </div>
                            <div class="form-group">
                                <label for="description">Mô Tả:</label>
                                <textarea class="form-control" id="description" name="description" required></textarea>
                                <span id="descriptionError" style="color: red;"></span> 
                            </div>
                            <button type="submit" class="btn btn-primary">Tạo mới</button>
                        </div>
                    </div>
                </form>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    function previewImage(event) {
        var image = document.getElementById('imagePreview');
        image.src = URL.createObjectURL(event.target.files[0]);
        image.style.display = 'block';
    }

    function validateForm() {
        var isValid = true;
        var barcode = document.getElementById('barcode').value;
        var name = document.getElementById('name').value;
        var category = document.querySelector('input[name="category"]:checked');
        var price = document.getElementById('price').value;
        var importPrice = document.getElementById('import_price').value;
        var stock = document.getElementById('stock').value;
        var image = document.getElementById('image').value;

        if (barcode.length === 0 || isNaN(barcode) || barcode < 0) {
            document.getElementById('barcodeError').innerText = 'Mã vạch không được để trống và phải là số';
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

        if (price.length === 0 || isNaN(price) || price < 0) {
            document.getElementById('priceError').innerText = 'Giá bán không được để trống và phải lớn hơn bằng 0';
            isValid = false;
        } else {
            document.getElementById('priceError').innerText = '';
        }

        if (importPrice.length === 0 || isNaN(importPrice) || importPrice < 0) {
            document.getElementById('importPriceError').innerText = 'Giá nhập không được để trống và phải lớn hơn bằng 0';
            isValid = false;
        } else {
            document.getElementById('importPriceError').innerText = '';
        }

        if (stock.length === 0 || isNaN(stock) || stock < 0) {
            document.getElementById('stockError').innerText = 'Số lượng không được để trống và phải lớn hơn bằng 0';
            isValid = false;
        } else {
            document.getElementById('stockError').innerText = '';
        }

        var descriptionInput = document.getElementById('description');
        var description = descriptionInput.value;
        var maxWords = 200;
        var wordCount = description.trim().split(/\s+/).length;

        if (wordCount > maxWords) {
            var words = description.trim().split(/\s+/).slice(0, maxWords);
            descriptionInput.value = words.join(' ');
            document.getElementById('descriptionError').innerText = 'Mô tả không được dài hơn ' + maxWords + ' từ';
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