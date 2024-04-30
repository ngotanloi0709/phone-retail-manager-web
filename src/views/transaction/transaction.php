<?php $this->layout('base',
    [
        'title' => 'Đơn Hàng',
        'header' => 'Đơn Hàng',
        'isShowAside' => true
    ]) ?>

<?php $this->start('main') ?>
<div class="card">
    <div class="card-header">
        <a href="/transaction/transaction_management" class="btn btn-outline-warning"><i class="fa-solid fa-boxes"></i> Quản Lý Đơn Hàng</a>
        <a href="/transaction/transaction_create" class="btn btn-outline-warning"><i class="fa-solid fa-inbox"></i> Tạo Đơn Hàng</a>
    </div>
    <div class="card-body">
        <h5 class="card-title"></h5>
        <p class="card-text"></p>
        
    </div>
</div>
<?php $this->end('main') ?>

