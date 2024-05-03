<?php $this->layout(
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
        <div class="card-body">
            <form action="" method="post" enctype="multipart/form-data" id="addProductForm" onsubmit="return validateForm()">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="image">Hình Ảnh</label>
                            <input type="file" class="form-control" id="image" name="image" onchange="previewImage(event)" required>
                            <img id="imagePreview" src="#" alt="Preview Image" style="display: none; margin-top: 10px; max-width: 100%; height: auto;">
                            <span id="fileImageError" style="color: red;"></span>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label for="barcode">Mã sản phẩm</label>
                            <input type="text" class="form-control" id="barcode" name="barcode" required>
                            <span id="barcodeError" style="color: red;"></span>
                        </div>
                        <div class="form-group
                    ">
                            <label for="name">Tên sản phẩm</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                            <span id="nameError" style="color: red;"></span>
                        </div>
                        <div class="form-group">
                            <label for="category">Loại sản phẩm</label>
                            <select class="form-select" id="category" name="category" required>
                                <?php foreach ($categories as $category) : ?>
                                    <option value="<?php echo $category->getId(); ?>"><?php echo $category->getName(); ?></option>
                                <?php endforeach; ?>
                                <option value="new">Tạo mới</option>
                            </select>
                            <div id="newCategoryInput" style="display: none;">
                                <label for="newCategoryName">Tên loại sản phẩm mới</label>
                                <input type="text" class="form-control" id="newCategoryName" name="newCategoryName">
                            </div>
                            <span id="categoryError" style="color: red;"></span>
                        </div>
                        <div class="form-group">
                            <label for="price">Giá bán</label>
                            <input type="number" class="form-control" id="price" name="price" required>
                            <span id="priceError" style="color: red;"></span>
                        </div>
                        <div class="form-group">
                            <label for="price">Giá nhập</label>
                            <input type="number" class="form-control" id="import_price" name="import_price" required>
                            <span id="importPriceError" style="color: red;"></span>
                        </div>
                        <div class="form-group">
                            <label for="stock">Số Lượng</label>
                            <input type="number" class="form-control" id="stock" name="stock" required>
                            <span id="stockError" style="color: red;"></span>
                        </div>
                        <div class="form-group">
                            <label for="description">Mô Tả</label>
                            <textarea class="form-control" id="description" name="description" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Tạo mới</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('category').addEventListener('change', function() {
        var categorySelect = document.getElementById('category');
        var newCategoryInput = document.getElementById('newCategoryInput');

        if (categorySelect.value === 'new') {
            newCategoryInput.style.display = 'block';
        } else {
            newCategoryInput.style.display = 'none';
        }       

    });

    function previewImage(event) {
        var image = document.getElementById('imagePreview');
        image.src = URL.createObjectURL(event.target.files[0]);
        image.style.display = 'block';
    }

    $('#addProductForm').on('submit', function() {
        // If the newCategoryName input is visible
        if ($('#newCategoryName').is(':visible')) {
            // Add the required attribute
            $('#newCategoryName').attr('required', true);
        } else {
            // Remove the required attribute
            $('#newCategoryName').removeAttr('required');
        }
    });


    function validateForm() {
    var barcode = document.getElementById('barcode').value;
    var name = document.getElementById('name').value;
    var category = document.getElementById('category').value;
    if (category == 'new') {
        category = document.getElementById('newCategoryName').value;
    }
    var price = document.getElementById('price').value;
    var importPrice = document.getElementById('import_price').value;
    var stock = document.getElementById('stock').value;

    // Reset all error messages to empty string before validating the form again 
    if (isNaN(barcode)) {
        document.getElementById('barcodeError').innerHTML = "Mã phải là dạng số!";
        return false;
    }

    // Validate name
    if (name == "" || typeof name != 'string' || /^\d+$/.test(name)) {
        document.getElementById('nameError').innerHTML = "Tên sản phẩm không được để trống và phải là chuỗi ký tự!";
        return false;
    }

    // Validate category
    if (category == ""  || typeof category != 'string' || /^\d+$/.test(category)) {
        document.getElementById('categoryError').innerHTML = "Tên loại sản phẩm không được để trống và phải là chuỗi ký tự!";
        return false;
    }

    // Validate price
    if (isNaN(price || price <= 0)) {
        document.getElementById('priceError').innerHTML = "Giá bán phải là dạng số và lớn hơn 0!";
        return false;
    }

    // Validate import price
    if (isNaN(importPrice) || importPrice <= 0) {
        document.getElementById('importPriceError').innerHTML = "Giá nhập phải là dạng số và lớn hơn 0!";
        return false;
    }

    // Validate stock
    if (isNaN(stock) || stock < 0) {
        document.getElementById('stockError').innerHTML = "Số lượng phải là dạng số và lớn hơn hoặc bằng 0!";
        return false;
    }

    // Validate image
    $fileExtension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($fileExtension, $allowedExtensions)) {
        document.getElementById('fileImageError').innerHTML = "Vui lòng chọn file hình ảnh có đuôi ('.jpg', '.jpeg', '.png', '.gif')!";
        return false;
    }
    return true;
}
</script>

<?php $this->end('main'); ?>