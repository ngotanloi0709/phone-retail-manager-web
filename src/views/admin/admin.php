<?php $this->layout('base',
    [
        'title' => 'Admin',
        'header' => 'Trang điều hướng quản trị hệ thống',
        'isShowAside' => true
    ]) ?>

<?php $this->start('main') ?>
<div class="card">
    <div class="card-header">
        <i class="fa-regular fa-compass"></i> Điều hướng
    </div>
    <div class="card-body">
        <h5 class="card-title">Quản trị nhân viên</h5>
        <p class="card-text">Quản trị, can thiệp vào các hoạt động, thông tin của tài khoản nhân viên bán hàng.</p>
        <a href="/admin/user-management" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i> Truy cập</a>
    </div>
</div>
<?php $this->end('main') ?>

