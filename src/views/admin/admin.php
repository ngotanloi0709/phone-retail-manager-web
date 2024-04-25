<?php $this->layout('base',
    [
        'title' => 'Admin',
        'header' => 'Trang điều hướng quản trị hệ thống',
        'isShowAside' => true
    ]) ?>

<?php $this->start('main') ?>
<div class="card">
    <div class="card-header">
        Điều hướng
    </div>
    <div class="card-body">
        <h5 class="card-title">Quản trị nhân viên bán hàng</h5>
        <p class="card-text">Quản trị, can thiệp vào các hoạt động ... của tài khoản nhân viên bán hàng.</p>
        <a href="/admin/user_management" class="btn btn-primary">Enter</a>
    </div>
</div>
<?php $this->end('main') ?>

