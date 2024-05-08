<?php $this->layout('base',
    [
        'title' => 'Quản trị đơn hàng',
        'header' => 'Điều hướng quản trị đơn hàng',
        'isShowAside' => true
    ]) ?>

<?php $this->start('main') ?>
<div class="card mb-3">
    <div class="card-header">
        <i class="fa-regular fa-compass"></i> Điều hướng
    </div>
    <div class="card-body">
        <h5 class="card-title">Quản lý đơn hàng</h5>
        <p class="card-text">Quản lý, truy cập thông tin và trạng thái của các đơn hàng đã phát sinh với khách hàng.</p>
        <a href="/transaction/transaction_management" class="btn btn-outline-warning"><i class="fa-solid fa-boxes"></i>
            Truy cập</a>
    </div>

</div>
<div class="card mb-3">
    <div class="card-header">
        <i class="fa-regular fa-compass"></i> Điều hướng
    </div>
    <div class="card-body">
        <h5 class="card-title">Thêm đơn hàng</h5>
        <p class="card-text">Tạo đơn hàng mới cho khách hàng đến mua sản phẩm tại cửa hàng.</p>
        <a href="/transaction/transaction_create" class="btn btn-outline-warning"><i class="fa-solid fa-inbox"></i> Truy
            cập</a>
    </div>
</div>
<?php $this->end('main') ?>

