<?php

/** @var SessionUserDTO $sessionUser */
$sessionUser = $_SESSION['user'] ?? null;

use app\models\UserRole;

$this->layout(
    'base',
    [
        'title' => 'Thêm Sản Phẩm',
        'header' => 'Thêm Sản Phẩm',
        'title' => 'Thêm Sản Phẩm',
        'header' => 'Thêm Sản Phẩm',
        'isShowAside' => false
    ]
)
?>

<?php $this->start('main') ?>
<link rel="stylesheet" href="../../style/product.css">
<div class="container">
    <div class="card">
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data" id="addProductForm" onsubmit="return validateForm()">
                    <div class="row">
                        <div class="col-6">
                            <label for="name" class="mb-0">Tên sản phẩm:</label>
                            <input type="text" class="form-control mb-3" id="name" name="name" placeholder="Nhập tên sản phẩm" required>
                            <span id="nameError" style="color: red;"></span>
                        </div>
                        <div class="col-6">
                            <label for="barcode" class="mb-0">Mã vạch:</label>
                            <input type="text" class="form-control mb-3" id="barcode" name="barcode" placeholder="Nhập mã vạch">
                            <span id="barcodeError" style="color: red;"></span>
                        </div>
                        <div class="col-12">
                            <label for="category" class="col-12 mb-0">Loại sản phẩm:</label>
                            <div class="row mb-3">
                                <div class="col-4">
                                    <input class="form-check-input" type="radio" id="category_phone" name="category" value="Điện thoại" required>
                                    <label for="category_phone" class="mb-0">Điện thoại</label>
                                </div>
                                <div class="col-4">
                                    <input class="form-check-input" type="radio" id="category_accessory" name="category" value="Phụ kiện" required>
                                    <label for="category_accessory" class="mb-0">Phụ kiện</label>
                                </div>
                                <div class="col-4">
                                    <input class="form-check-input" type="radio" id="category_other" name="category" value="Khác" required>
                                    <label for="category_other" class="mb-0">Khác</label>
                                </div>
                            </div>
                            <span id="categoryError" style="color: red;"></span>
                        </div>
                        <div class="col-6">
                            <label for="price" class="mb-0">Giá bán:</label>
                            <input type="number" class="form-control mb-3" id="price" name="price" placeholder="Nhập giá bán" required>
                            <span id="priceError" style="color: red;"></span>
                        </div>
                        <div class="col-6">
                            <label for="price" class="mb-0">Giá nhập:</label>
                            <input type="number" class="form-control mb-3" id="import_price" name="import_price" placeholder="Nhập giá nhập" required>
                            <span id="importPriceError" style="color: red;"></span>
                        </div>
                        <div class="col-12">
                            <label for="stock" class="mb-0">Số Lượng:</label>
                            <input type="number" class="form-control mb-3" id="stock" name="stock" placeholder="Nhập số lượng" required>
                            <span id="stockError" style="color: red;"></span>
                        </div>
                        <div class="col-12">
                            <label for="description" class="mb-0">Mô Tả:</label>
                            <textarea class="form-control mb-3" id="description" name="description" rows="5" placeholder="Nhập mô tả"></textarea>
                            <span id="descriptionError" style="color: red;"></span>
                        </div>
                        <div class="col-12">
                            <label for="image" class="mb-0">Hình Ảnh:</label>
                            <input type="file" class="form-control mb-3" id="image" name="image" accept="image/png, image/jpeg, image/jpg, image/gif" onchange="previewImage(event)">
                            <span id="fileImageError" style="color: red;"></span>
                            <img class="rounded float-left mb-3" id="imagePreview" src="#" alt="" style="display: none;">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-success">Tạo mới</button>
                            <button type="button" class="btn btn-danger">
                                <a href="/product" style="color: white; text-decoration: none;">Hủy</a>
                            </button>
                        </div>
                    </div>
            </div>
            </form>
    </div>
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

        if (isNaN(barcode) || barcode < 0 || barcode.length > 10) {
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
            document.getElementById('priceError').innerText = 'Số lượng phải lớn hơn bằng 0 và không quá 10 chữ số';
            isValid = false;
        } else {
            document.getElementById('priceError').innerText = '';
        }

        if (importPrice.length > 10 || isNaN(importPrice) || importPrice < 0) {
            document.getElementById('importPriceError').innerText = 'Số lượng phải lớn hơn bằng 0 và không quá 10 chữ số';
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
