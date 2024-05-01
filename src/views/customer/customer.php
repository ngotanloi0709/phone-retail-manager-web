<?php
$this->layout('base',
    [
        'title' => 'Quản Lý Khách Hàng',
        'header' => 'Quản Lý Khách Hàng',
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
                    <th>Mã Khách Hàng</th>
                    <th>Họ Tên</th>
                    <th>Email</th>
                    <th>Số Điện Thoại</th>
                    <th>Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach ($customers as $customer) : ?>
                    <tr>
                        <td><?= $customer->getId() ?></td>
                        <td><?= $customer->getName() ?></td>
                        <td><?= $customer->getEmail() ?></td>
                        <td><?= $customer->getPhone() ?></td>
                        <td>
                            <a href="/customer/customer_transhistory?customerid=<?= $customer->getId() ?>" class="btn btn-primary">Xem lịch sử mua hàng</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table> 
    </div>
</div>
<?php $this->end('main') ?>
