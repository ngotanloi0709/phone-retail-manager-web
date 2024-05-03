<?php
/** @var string $header */
/** @var array $transactions */

/** @var User $saleUser */

use app\models\Transaction;
use app\models\TransactionDetail;
use app\models\User;
use app\utils\DataHelper;

$this->layout('base',
    [
        'title' => 'Lịch sử bán hàng',
        'header' => $header,
        'isShowAside' => true
    ]) ?>

<?php $this->start('main') ?>
<?= $this->insert('modal/user-transaction-detail-modal') ?>

<div class="card">
    <div class="card-header">
        <b>Bảng thông tin bán hàng của người dùng <?= $saleUser->getUsername() ?></b>
    </div>
    <div class="card-body">
        <table class="table table-hover table-striped table-bordered long-table ">
            <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Tên người bán</th>
                <th scope="col">Tên khách hàng</th>
                <th scope="col">Số điện thoại khách hàng</th>
                <th scope="col">Số lượng sản phẩm</th>
                <th scope="col">Tổng giá trị</th>
                <th scope="col">Thao tác</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if (count($transactions) == 0) {
                echo '<tr><td colspan="6"></td></tr>';
            } else {
                /** @var Transaction $transaction */
                foreach ($transactions as $transaction) {
                    echo '<tr data-transaction-details="';
                        $items = $transaction->getItems();
                        $itemDetails = [];
                        /** @var TransactionDetail $item */
                        foreach ($items as $item) {
                            $itemDetails[] = [
                                'productName' => $item->getProduct()->getName(),
                                'quantity' => $item->getQuantity(),
                                'price' => $item->getProduct()->getPrice()
                            ];
                        }
                        echo htmlspecialchars(json_encode($itemDetails), ENT_QUOTES, 'UTF-8');

                        echo '" data-transaction-created="' . $transaction->getCreatedString();
                    echo '">';
                    echo '<td>' . DataHelper::getDisplayStringData($transaction->getId()) . '</td>';
                    echo '<td>' . DataHelper::getDisplayStringData($transaction->getUser()->getName()) . '</td>';
                    echo '<td>' . DataHelper::getDisplayStringData($transaction->getCustomer()->getName()) . '</td>';
                    echo '<td>' . DataHelper::getDisplayStringData($transaction->getCustomer()->getPhone()) . '</td>';
                    echo '<td>';
                        $totalProduct = 0;
                        /** @var TransactionDetail $item */
                        foreach ($transaction->getItems() as $item) {
                            $totalProduct += $item->getQuantity();
                        }
                        echo $totalProduct;
                    echo '</td>';
                    echo '<td>';
                        $totalValue = 0;
                        /** @var TransactionDetail $item */
                        foreach ($transaction->getItems() as $item) {
                            $totalValue += $item->getProduct()->getPrice() * $item->getQuantity();
                        }
                    echo $totalValue;
                    echo '</td>';
                    echo '<td>';
                    echo '<a class="buttonShowTransactionDetail btn btn-primary btn-sm me-1"><span><i class="fa-solid fa-circle-info"></i> Xem chi tiết đơn hàng</span></a>';
                    echo '</td>';
                    echo '</tr>';
                }
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<script src="../script/user-transaction-detail.js"></script>
<?php $this->end('main') ?>

