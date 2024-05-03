<?php $this->layout(
    'base',
    [
        'title' => 'Chỉnh Sửa Sản Phẩm',
        'header' => 'Chỉnh Sửa Sản Phẩm',
        'isShowAside' => false
    ]
); ?>

<?php $this->start('main') ?>
<link rel="stylesheet" href="../../style/product_details.css">
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-6">
                    <h4 class="card-title">Chỉnh sửa thông tin sản phẩm</h4>
                </div>
                <div class="col-6 text-end">
                    <a href="/product" class="btn btn-outline-warning"><i class="fa-solid fa-list me-2"></i> Danh sách sản phẩm</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-6">

                        <label for="image">Hình Ảnh</label>
                        <input type="file" class="form-control" id="image" name="image">
                        <?php if (!empty($product->getImageUrl())) : ?>
                            <img id="image_preview" src="<?php echo str_replace('../public/image/', '../../image/', $product->getImageUrl()); ?>" alt="Product Image" width="100">
                            <input type="hidden" id="current_image" name="current_image" value="<?php echo $product->getImageUrl(); ?>">
                        <?php else : ?>
                            <img id="image_preview" src="" alt="Product Image" width="100" style="display: none;">
                            <input type="hidden" id="current_image" name="current_image" value="">
                        <?php endif; ?>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label for="barcode">Mã sản phẩm</label>
                            <input type="text" class="form-control" id="barcode" name="barcode" value="<?php echo $product->getBarcode(); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Tên sản phẩm</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo $product->getName(); ?>" required>
                        </div>
                        <div class="form-group">
                        <label for="category">Loại sản phẩm</label>
    <select class="form-select" id="category" name="category" required onchange="checkNewCategory(this)">
        <option selected>Chọn loại sản phẩm</option>
        <?php /** @var array $categories */
        foreach ($categories as $category) : ?>
            <option value="<?php echo $category->getId(); ?>" <?php if ($category->getId() == $product->getCategoryId()) echo 'selected'; ?>><?php echo $category->getName(); ?></option>
        <?php endforeach; ?>
        <option value="new">Tạo mới</option>
    </select>
    <input type="text" class="form-control" id="new_category" name="new_category" style="display: none;" placeholder="Enter new category name">
                        </div>
                        <div class="form-group">
                            <label for="price">Giá bán</label>
                            <input type="text" class="form-control" id="price" name="price" value="<?php echo $product->getPrice(); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="import_price">Giá nhập</label>
                            <input type="text" class="form-control" id="import_price" name="import_price" value="<?php echo $product->getImportPrice(); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Mô Tả</label>
                            <textarea class="form-control" id="description" name="description" required><?php echo $product->getDescription(); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="stock">Số Lượng</label>
                            <input type="number" class="form-control" id="stock" name="stock" value="<?php echo $product->getStock(); ?>" required>
                        </div>
                        <div class="form-group">
                        </div>
                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('image').addEventListener('change', function() {
        var fileInput = document.getElementById('image');
        var currentImageInput = document.getElementById('current_image');
        var imagePreview = document.getElementById('image_preview');

        if (fileInput.files.length > 0) {
            // Người dùng đã chọn một tệp hình ảnh mới, hãy cập nhật trường ẩn với URL của hình ảnh mới
            currentImageInput.value = URL.createObjectURL(fileInput.files[0]);

            // Hiển thị hình ảnh mới trong trường preview
            imagePreview.src = currentImageInput.value;
        }
    });

    // Lắng nghe sự kiện khi người dùng nhập liệu vào trường giá bán
    document.getElementById('price').addEventListener('input', function() {
        // Lấy giá trị người dùng nhập vào
        var priceInput = this.value;
        // Định dạng lại giá trị thành số có dấu phẩy
        var formattedPrice = formatCurrency(priceInput);
        // Gán giá trị đã định dạng lại vào trường giá bán
        this.value = formattedPrice;
    });

    // Lắng nghe sự kiện khi người dùng nhập liệu vào trường giá nhập
    document.getElementById('import_price').addEventListener('input', function() {
        // Lấy giá trị người dùng nhập vào
        var importPriceInput = this.value;
        // Định dạng lại giá trị thành số có dấu phẩy
        var formattedImportPrice = formatCurrency(importPriceInput);
        // Gán giá trị đã định dạng lại vào trường giá nhập
        this.value = formattedImportPrice;
    });

    // Hàm để định dạng giá thành số có dấu phẩy
    function formatCurrency(value) {
        // Xóa bỏ các dấu phẩy và khoảng trắng có thể tồn tại trong chuỗi giá trị
        var cleanValue = value.replace(/[^0-9]/g, '');
        // Chuyển đổi giá trị thành số
        var number = parseFloat(cleanValue);
        // Định dạng lại giá trị thành chuỗi có dấu phẩy
        var formattedValue = number.toLocaleString('vi-VN');
        // Thêm đơn vị tiền tệ (đ) vào cuối chuỗi giá trị
        formattedValue += ' đ';
        // Trả về giá trị đã định dạng
        return formattedValue;
    }

    function checkNewCategory(select) {
        var newCategoryInput = document.getElementById('new_category');
        if (select.value === 'new') {
            newCategoryInput.style.display = 'block';
            newCategoryInput.setAttribute('required', true);
        } else {
            newCategoryInput.style.display = 'none';
            newCategoryInput.removeAttribute('required');
        }
    }   
</script>


<?php $this->end('main'); ?>