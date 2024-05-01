<?php use app\models\Transaction;
use app\utils\DataHelper;
$this->layout('base',
    [
        'title' => 'Hoá Đơn Bán Hàng',
        'header' => '',
        'isShowAside' => false
    ]) ?>

<?php $this->start('main') ?>
<body>
<link rel="stylesheet" href="../../style/popup.css">
<div id="transDetailPopup" class="popup" style="display: block;">
    <div class="popup-content" id="invoiceContent">
        <div class="row">
            <div class="col-md-4 col-sm-4 col-xs-12">
                <h5>PHP POINT OF SALE</h5>
                <p>Địa chỉ: 19 Đ.Nguyễn Hữu Thọ, Tân Hưng, Quận 7, Tp.Hồ Chí Minh</p>
                <p>Điện thoại: 028 3775 5052</p>
                <p>Mã số thuế: 123456789</p>
                <p>pointofsale.com.vn</p>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12" style="text-align: center;">
                <h3><b>Hoá Đơn Bán Hàng</b></h3>
                <?php if (!empty($transactions)) : ?>
                    <?php $latestTransaction = end($transactions); ?>
                    <p>ID: <?= $latestTransaction->getId() ?></p>
                    <p><?= $latestTransaction->getCreated()->format('d/m/Y H:i:s') ?></p>
                    <p>Khách Hàng: <?= DataHelper::getDisplayStringData($latestTransaction->getCustomer()->getName()) ?></p>
                    <p>Nhân Viên: <?= $latestTransaction->getUser()->getUsername() ?></p>
                <?php else : ?>
                    <p>No transactions found.</p>
                <?php endif; ?>
            </div>
        </div>
        <hr>
        <table class="table table-bordered" class="transDetailPopupTable">
            <tr>
                <th>Tên sản phẩm</th>
                <th>Mã sản phẩm</th>
                <th>Đơn giá</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
            </tr>
            <?php if (!empty($transactions)) : ?>
                <?php $latestTransaction = end($transactions); ?>
                <?php $total = 0; ?>
                <?php foreach ($latestTransaction->getItems() as $item) : ?>
                    <?php $total += $item->getProduct()->getPrice() * $item->getQuantity(); ?>
                    <tr>
                        <td><?= $item->getProduct()->getName() ?></td>
                        <td><?= $item->getProduct()->getId() ?></td>
                        <td><?= number_format($item->getProduct()->getPrice()) ?></td>
                        <td><?= $item->getQuantity() ?></td>
                        <td><?= number_format($item->getProduct()->getPrice() * $item->getQuantity()) ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="4"></td>
                    <td><?= number_format($total) ?></td>
                </tr>
            <?php else : ?>
                <tr>
                    <td colspan="5">No items found.</td>
                </tr>
            <?php endif; ?>
        </table>
        <hr>
        <div class="row" style="text-align: right;">
            <div class="col-md-10 col-sm-10 col-xs-12">Phương thức thanh toán:</div>
            <div class="col-md-2 col-sm-2 col-xs-12" id="paymentMethod"></div>
        </div>
        <div hidden class="row" style="text-align: right;">
            <div class="col-md-10 col-sm-10 col-xs-12">Số tiền khách đưa:</div>
            <div class="col-md-2 col-sm-2 col-xs-12" id="givenMoney"></div>
        </div>
        <div hidden class="row" style="text-align: right;">
            <div class="col-md-10 col-sm-10 col-xs-12">Số tiền trả lại khách:</div>
            <div class="col-md-2 col-sm-2 col-xs-12" id="backMoney"></div>
        </div>
    </div>
    <button id="printBnt" class="btn btn-warning">In hoá đơn</button>
</div>
</body>

<script>
    $(document).ready(function () {
        <?php 
            $paymentMethod = $_GET['paymentMethod'];
            $givenMoney = $_GET['givenMoney'];
            if ($paymentMethod == 'cash') {
                $backMoney = $givenMoney - $total;
                $givenMoney = number_format($givenMoney);
                $backMoney = number_format($backMoney);
                echo "document.getElementById('paymentMethod').innerHTML = 'Tiền mặt';";
                echo "document.getElementById('givenMoney').innerHTML = '$givenMoney'; document.getElementById('givenMoney').parentElement.hidden = false;";
                echo "document.getElementById('backMoney').innerHTML = '$backMoney'; document.getElementById('backMoney').parentElement.hidden = false;";
            }
            else {
                echo "document.getElementById('paymentMethod').innerHTML = 'Thẻ';";
            }
        ?>
        $('#printBnt').click(function () {
            var printContents = document.getElementById("invoiceContent").innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        });
    });
</script>

<?php $this->end('main') ?>