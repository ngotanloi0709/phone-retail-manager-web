<?php $this->layout('base',
    [
        'title' => 'Quản Lý Đơn Hàng',
        'header' => 'Quản Lý Đơn Hàng',
        'isShowAside' => false
    ]) ?>

<?php $this->start('main') ?>
<div class="card">
    <div class="card-header">
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ngày Tạo</th>
                    <th>Khách Hàng</th>
                    <th>Người Tạo</th>
                    <th>Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach ($transactions as $transaction) : ?>
                    <tr>
                        <td><?= $transaction->getId() ?></td>
                        <td><?= $transaction->getCreated()->format('d/m/Y H:i:s') ?></td>
                        <td><?= $transaction->getCustomer()->getName() ?></td>
                        <td><?= $transaction->getUser()->getUsername() ?></td>
                        <td>
                            <a href="<?= $baseUrl . '/transaction/detail/' . $transaction->getId() ?>" class="btn btn-primary">Chi Tiết</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php $this->end('main') ?>

