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
<link rel="stylesheet" href="../../style/popup.css">

<div id="transDetailPopup" class="popup">
    <div class="popup-content">
        <button id="closePopup">&#10006;</button>
        <div id="transInfo"></div>
        <table class="table table-bordered" id="transDetailPopupTable">

        </table>
    </div>
</div>
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
            <?php
                foreach ($transactions as $transaction) : ?>
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
                            <button class="getDetailBnt">Chi tiết</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table> 
    </div>
</div>
<script> 
    $(document).ready(function () {
        $('.getDetailBnt').click(function () {
            <?php
            foreach ($transactions as $transaction) : ?>

            if ($(this).closest('tr').find('td').eq(0).text() === '<?= $transaction->getId() ?>') {
                document.getElementById("transInfo").innerHTML = "<h3>CHI TIẾT ĐƠN HÀNG <?= $transaction->getId() ?></h3><p>Thời Gian Tạo: <?= $transaction->getCreated()->format('d/m/Y H:i:s') ?></p><p>Khách Hàng: <?= /** @var Transaction $transaction */
                    DataHelper::getDisplayStringData($transaction->getCustomer()->getName()) ?></p><p>Người Tạo: <?= $transaction->getUser()->getUsername() ?></p>";
                let transDetailPopupTable = document.getElementById("transDetailPopupTable");
                transDetailPopupTable.innerHTML = "<tr><th>Tên sản phẩm</th><th>Mã sản phẩm</th><th>Đơn giá</th><th>Số Lượng</th><th>Thành tiền</th></tr>"
                let $total = 0;
                <?php
                foreach ($transaction->getItems() as $item) : ?>

                $total += <?= $item->getProduct()->getPrice() * $item->getQuantity() ?>;

                let $price = <?= $item->getProduct()->getPrice() ?>;
                $price = $price.toLocaleString();

                let $temptotal = <?= $item->getProduct()->getPrice() * $item->getQuantity() ?>;
                $temptotal = $temptotal.toLocaleString();
                transDetailPopupTable.innerHTML += "<tr><td><?= $item->getProduct()->getName() ?></td><td><?= $item->getProduct()->getId() ?></td><td>" + $price + "</td><td><?= $item->getQuantity() ?></td><td>" + $temptotal + "</td></tr>";
                <?php endforeach;
                ?>
                let row = transDetailPopupTable.insertRow(-1);
                row.innerHTML = "<td colspan='4'></td><td>" + $total.toLocaleString() + "</td>";
                document.getElementById("transDetailPopup").style.display = "block";
            }
            <?php endforeach;
            ?>
        });

        $('#closePopup').click(function () {
            document.getElementById("transDetailPopup").style.display = "none";
            document.getElementById("transDetailPopupTable").innerHTML = "";
        });
    });
</script>
<?php $this->end('main') ?>