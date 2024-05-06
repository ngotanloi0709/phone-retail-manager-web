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
<?php
$productsPerPage = 5;
/** @var array $products */
$totalPages = ceil(count($products) / $productsPerPage);
$currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
$currentPage = max(1, min($currentPage, $totalPages));
$start = ($currentPage - 1) * $productsPerPage;
$end = $start + $productsPerPage - 1;
$currentProducts = array_slice($products, $start, $productsPerPage);
?>

<link rel="stylesheet" href="../../style/product.css">
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-6">
                    <h4 class="card-title">Danh sách sản phẩm</h4>
                </div>

                <div class="col-6 text-end">
                    <a href="/product/add-product" class="btn btn-outline-warning"><i class="fa-solid fa-plus me-2"></i>Thêm
                        sản phẩm</a>
                </div>


            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Hình ảnh</th>
                            <th>Mã vạch</th>
                            <th>Tên</th>
                            <th>Loại</th>
                            <th>Giá bán</th>
                            <th>Số lượng</th>
                            <?php if ($sessionUser->getRole() == UserRole::ADMIN) : ?>
                                <th>Thao tác</th>
                            <?php endif; ?>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($currentProducts as $product) : ?>
                            <tr data-id="<?php echo $product->getId(); ?>">
                                <td><img class="card-img-top" src="<?php echo ImageHelper::getDisplayStringData($product->getImageUrl()) ?>" alt="" onerror="this.onerror=null; this.src='/image/product-default-image.png';"></td>
                                <td> <?php echo $product->getBarcode(); ?></td>
                                <td><?php echo $product->getName(); ?></td>
                                <td><?php echo $product->getCategoryName(); ?></td>
                                <td><?php echo $product->getPriceFormatted() ?></td>
                                <td><?php echo $product->getStock(); ?></td>

                                <td>
                                    <?php if ($sessionUser->getRole() == UserRole::ADMIN) : ?>
                                        <a class="editProduct" data-id="<?php echo $product->getId(); ?>" data-toggle="modal">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <a class="deleteProduct" data-id="<?php echo $product->getId(); ?>" data-toggle="modal">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="clearfix">
                    <ul class="pagination">
                        <li class="page-item <?php echo $currentPage == 1 ? 'disabled' : ''; ?>"><a href="?page=<?php echo $currentPage - 1; ?>" class="page-link">Trước</a></li>
                        <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                            <li class="page-item <?php echo $i == $currentPage ? 'active' : ''; ?>"><a href="?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a></li>
                        <?php endfor; ?>
                        <li class="page-item <?php echo $currentPage == $totalPages ? 'disabled' : ''; ?>"><a href="?page=<?php echo $currentPage + 1; ?>" class="page-link">Sau</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editButtons = document.querySelectorAll('.editProduct');

            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const productId = button.dataset.id;

                    window.location.href = `/product/edit-product?id=${productId}`;
                });
            });

            const deleteButtons = document.querySelectorAll('.deleteProduct');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const productId = button.dataset.id;
                    const isConfirmed = confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');

                    if (!isConfirmed) {
                        return;
                    } else {
                        window.location.href = `/product/delete-product?id=${productId}`;
                    }
                });
            });

            const tableRows = document.querySelectorAll('tbody tr');
            tableRows.forEach(row => {
                row.addEventListener('dblclick', function() {
                    const productId = row.dataset.id;

                    window.location.href = `/product/view-product?id=${productId}`;
                });
            });
        });
    </script>
    <?php $this->end('main'); ?>