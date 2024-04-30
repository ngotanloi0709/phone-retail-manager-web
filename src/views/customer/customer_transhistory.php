<?php
$this->layout('base',
    [
        'title' => 'Lịch Sử Mua Hàng',
        'header' => 'Lịch Sử Mua Hàng',
        'isShowAside' => false
    ])?>
<?php $this->start('main') ?>
<div class="card">
    <div class="card-header">
    </div>
    <div class="card-body">
    <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Ngày Mua</th>
                    <th>Tổng Số Tiền</th>
                    <th>Số Tiền Khách Đã Đưa</th>
                    <th>Tiền Thối</th>
                    <th>Số Lượng Sản Phẩm</th>
                    <th>Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table> 
    </div>
</div>
<?php $this->end('main') ?>