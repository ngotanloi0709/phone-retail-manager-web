<?php
use app\models\Transaction;
use app\utils\DataHelper;
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
            <?php foreach ($transactions as $transaction) : ?>
                    <tr>
                        <td><?=$transaction->getCreated()->format('d/m/Y H:i:s')?></td>
                        
                        <?php
                            $total = 0;
                            foreach ($transaction->getItems() as $item) : 
                                $total += $item->getProduct()->getPrice() * $item->getQuantity() ;
                            endforeach;
                        ?>
                        <td><?php echo $total?></td>
                        <td><?=$transaction->getGivenMoney()?></td>
                        <?php
                            $change = $transaction->getGivenMoney() - $total;
                        ?>
                        <td><?php echo $change?></td>
                        <?php
                            $totalquantity = 0;
                            foreach ($transaction->getItems() as $item) : 
                                $totalquantity += $item->getQuantity() ;
                            endforeach;
                        ?>
                        <td ><?php echo $totalquantity?></td>
                        <td>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">Chi tiết</button>   
                            <div id="myModal"  class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <h3>CHI TIẾT ĐƠN HÀNG <?= $transaction->getId() ?></h3>
                                        <p>Thời Gian Tạo: <?= $transaction->getCreated()->format('d/m/Y H:i:s') ?></p>
                                        <p>Khách Hàng: <?=DataHelper::getDisplayStringData($transaction->getCustomer()->getName()) ?></p>
                                        <p>Người Tạo: <?= $transaction->getUser()->getUsername() ?></p>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Tên sản phẩm</th>
                                                    <th>Mã sản phẩm</th>
                                                    <th>Đơn giá</th>
                                                    <th>Số Lượng</th>
                                                    <th>Thành tiền</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($transaction->getItems() as $item) : ?>
                                                    <tr>
                                                        <td><?= $item->getProduct()->getName() ?></td>
                                                        <td><?= $item->getProduct()->getId() ?></td>
                                                        <td><?= $item->getProduct()->getPrice() ?></td>
                                                        <td><?= $item->getQuantity() ?></td>
                                                        <td><?= $item->getProduct()->getPrice() * $item->getQuantity() ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->
                        </td> 
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table> 
    </div>
</div>
<?php $this->end('main') ?>