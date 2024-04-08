<?php $this->layout('base',
    [
        'title' => 'Không tìm thấy trang',
        'header' => 'Không tìm thấy trang',
        'isShowAside' => false
    ]) ?>

<?php $this->start('main') ?>
<div class="page-wrap d-flex flex-row align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 text-center">
                <span class="display-1 d-block">404</span>
                <div class="mb-4 lead">Trang bạn tìm kiếm không tồn tại hoặc đã xảy ra lỗi!</div>
                <a href="/" class="btn btn-link">Quay về trang chủ</a>
            </div>
        </div>
    </div>
</div>
<?php $this->end('main') ?>

