<?php $this->layout('base',
    [
        'title' => 'Sản Phẩm',
        'header' => 'Quản lí sản phẩm',
        'isShowAside' => true
    ]) 
?>


<?php $this->start('main') ?>
<div class="card">
    <div class="card-header">
        <a href="/product/product-management" class="btn btn-outline-warning"><i class="fa-solid fa-list"></i>Sản phẩm</a>
        <a href="/product/add-product" class="btn btn-outline-warning"><i class="fa-solid fa-plus"></i>Thêm sản phẩm</a>
    </div>
    <div class="card-body">
       
        
    </div>
</div>
<?php $this->end('main') ?>