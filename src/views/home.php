<?php
/** @var bool $isAuthenticated */
/** @var SessionUserDTO $sessionUser */

$isAuthenticated = isset($_SESSION['user']);
$sessionUser = $_SESSION['user'];

use app\dto\SessionUserDTO;
use app\models\UserRole;

?>

<?php $this->layout('base',
    [
        'title' => 'Trang chủ',
        'header' => 'Trang chủ',
        'isShowAside' => true
    ]) ?>
<?php $this->start('main') ?>
<?php if ($isAuthenticated): ?>
    <?php if ($sessionUser->getRole() == UserRole::ADMIN): ?>
        <div class="card mb-3">
            <div class="card-header">
                <i class="fa-regular fa-compass"></i> Điều hướng
            </div>
            <div class="card-body">
                <h5 class="card-title">Quản trị nhân viên</h5>
                <p class="card-text">Quản trị, can thiệp vào các hoạt động, thông tin của tài khoản nhân viên bán
                    hàng.</p>
                <a href="/admin/user-management" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i> Truy cập</a>
            </div>
        </div>
    <?php endif; ?>
    <div class="card mb-3">
        <div class="card-header">
            <i class="fa-regular fa-compass"></i> Điều hướng
        </div>
        <div class="card-body">
            <h5 class="card-title">Quản trị bán hàng</h5>
            <p class="card-text">Thêm đơn hàng mới và quản trị thông tin các đơn hàng đã tạo.</p>
            <a href="/transaction" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i> Truy cập</a>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            <i class="fa-regular fa-compass"></i> Điều hướng
        </div>
        <div class="card-body">
            <h5 class="card-title">Quản trị sản phẩm</h5>
            <p class="card-text">Quản trị thông tin của các sản phẩm trong cửa hàng.</p>
            <a href="/product" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i> Truy cập</a>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            <i class="fa-regular fa-compass"></i> Điều hướng
        </div>
        <div class="card-body">
            <h5 class="card-title">Quản trị khách hàng</h5>
            <p class="card-text">Quản trị thông tin của khách hàng bao gồm thông tin cá nhân và lịch sử giao
                dịch.</p>
            <a href="/customer" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i> Truy cập</a>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            <i class="fa-regular fa-compass"></i> Điều hướng
        </div>
        <div class="card-body">
            <h5 class="card-title">Xem thống kê</h5>
            <p class="card-text">Thống kê các số liệu phát sinh trong quá trình sinh ra giao dịch với khách hàng.</p>
            <a href="/statistics" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i> Truy cập</a>
        </div>
    </div>
<?php else: ?>
    <h3><b>Xin hãy đăng nhập để sử dụng hệ thống.</b></h3>
    <h5><i>Liên hệ với quản trị viên nếu bạn muốn tạo tài khoản mới hoặc gặp vấn đề với tài khoản!</i></h5>
<?php endif; ?>
<?php $this->end('main') ?>

