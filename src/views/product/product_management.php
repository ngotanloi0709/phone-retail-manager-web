<?php
/** @var SessionUserDTO $sessionUser */
$sessionUser = $_SESSION['user'] ?? null;

use app\dto\SessionUserDTO;
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
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Mã</th>
                    <th>Hình ảnh</th>
                    <th>Tên</th>
                    <th>Loại</th>
                    <th>Giá bán</th>
                    <th>Số lượng</th>
                    <?php if ($sessionUser->getRole() == UserRole::ADMIN): ?>
                        <th>Thao tác</th>
                    <?php endif; ?>
                </tr>
                </thead>

                <tbody>
                <?php foreach ($currentProducts as $product) : ?>
                    <tr data-id="<?php echo $product->getId(); ?>">
                        <td> <?php echo $product->getBarcode(); ?></td>
                        <td><img class="card-img-top"
                                 src="<?php echo str_replace('../public/product_images/', '../../product_images/', $product->getImageUrl()); ?>"
                                 alt=""></td>
                        <td><?php echo $product->getName(); ?></td>
                        <td><?php echo $product->getCategoryName(); ?></td>
                        <td><?php echo number_format($product->getPrice(), 0, ',', '.') . ' đ'; ?></td>
                        <td><?php echo $product->getStock(); ?></td>

                        <td>
                            <?php if ($sessionUser->getRole() == UserRole::ADMIN): ?>
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

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const editButtons = document.querySelectorAll('.editProduct');

            editButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const productId = button.dataset.id;

                    window.location.href = `/product/edit-product?id=${productId}`;
                });
            });

            const deleteButtons = document.querySelectorAll('.deleteProduct');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
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
                row.addEventListener('dblclick', function () {
                    const productId = row.dataset.id;

                    window.location.href = `/product/view-product?id=${productId}`;
                });
            });
        });
    </script>
<?php $this->end('main'); ?>