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
<link rel="stylesheet" href="../../style/transation-style.css">

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
        <b>Danh sách đơn hàng</b>
    </div>
    <div class="card-body">
    <div style="overflow-x:auto;">
    <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ngày Mua</th>
                    <th>Tổng Số Tiền</th>
                    <th>Số Tiền Khách Đã Đưa</th>
                    <th>Tiền Thối</th>
                    <th>Số Lượng Sản Phẩm</th>
                    <th>Trạng Thái</th>
                    <th>Thao Tác</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($transactions as $transaction) : ?>
                    <tr data-trans-iscanceled="<?=$transaction->getIsCanceled()?>"
                        data-trans-id="<?=$transaction->getId()?>">
                        <td><?=$transaction->getId()?></td>
                        <td><?=$transaction->getCreated()->format('d/m/Y H:i:s')?></td>
                        
                        <?php
                            $total = 0;
                            foreach ($transaction->getItems() as $item) : 
                                $total += $item->getProduct()->getPrice() * $item->getQuantity() ;
                            endforeach;
                        ?>
                        <td><?php echo number_format($total,0,',','.')?></td>
                        <td><?=number_format($transaction->getGivenMoney(),0,',','.')?></td>
                        <?php
                            $change = $transaction->getGivenMoney() - $total;
                            if ($change < 0) {
                                $change=0;
                            }
                        ?>
                        <td><?php echo number_format($change,0,',','.')?></td>
                        <?php
                            $totalquantity = 0;
                            foreach ($transaction->getItems() as $item) : 
                                $totalquantity += $item->getQuantity() ;
                            endforeach;
                        ?>
                        <td ><?php echo $totalquantity?></td>
                        <td>
                            <?php 
                                if (DataHelper::getDisplayStringData($transaction->getIsCanceled()) === "Chưa có dữ liệu") {
                                    echo "Đã Hoàn Tất";
                                }
                                else {
                                    echo $transaction->getIsCanceled() ? "Đã Huỷ" : "Đã Hoàn Tất";
                                }
                            ?>
                        </td>
                        <td>
                            <button class="btn btn-danger cancelBnt"><i class="fa-solid fa-circle-xmark"></i> Huỷ đơn hàng</button>
                            <button type="button" class="btn btn-primary getDetailBnt"><span><i class="fa-solid fa-circle-info"></i></span> Chi tiết</button>   
                            
                        </td> 
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div> 
    </div>
</div><script>
    $(document).ready(function () {
        function showPopup(transId) {
            <?php
            foreach ($transactions as $transaction) : ?>

            if (transId === '<?= $transaction->getId() ?>') {
                
                <?php $status = "";
                if($transaction->getIsCanceled()){
                        $status= "Đã huỷ";
                    }
                    else{
                        $status= "Đã hoàn tất";
                }
                ?>
                document.getElementById("transInfo").innerHTML = "<h3>CHI TIẾT ĐƠN HÀNG <?= $transaction->getId() ?></h3><p>Thời Gian Tạo: <?= $transaction->getCreated()->format('d/m/Y H:i:s') ?></p><p>Khách Hàng: <?= /** @var Transaction $transaction */
                    DataHelper::getDisplayStringData($transaction->getCustomer()->getName()) ?></p><p>Số điện thoại khách hàng: <?= $transaction->getCustomer()->getPhone() ?></p><p>Người Tạo: <?= $transaction->getUser()->getUsername() ?></p><p>Trạng thái đơn hàng: <?=$status?> </p>";
                let transDetailPopupTable = document.getElementById("transDetailPopupTable");
                transDetailPopupTable.innerHTML = "<tr><th>Tên sản phẩm</th><th>Mã sản phẩm</th><th>Đơn giá</th><th>Số Lượng</th><th>Thành tiền</th></tr>"
                let $quantity = 0;
                let $total = 0;
                <?php
                foreach ($transaction->getItems() as $item) : ?>
                $quantity += <?= $item->getQuantity() ?>;
                $total += <?= $item->getProduct()->getPrice() * $item->getQuantity() ?>;
                var $price = <?= $item->getProduct()->getPrice() ?>;
                var $temptotal = <?= $item->getProduct()->getPrice() * $item->getQuantity() ?>;
                transDetailPopupTable.innerHTML += "<tr><td><?= $item->getProduct()->getName() ?></td><td><?= $item->getProduct()->getId() ?></td><td>" + $price.toLocaleString() + "</td><td><?= $item->getQuantity() ?></td><td>" + $temptotal.toLocaleString() + "</td></tr>";
                <?php endforeach;
                ?>
                let row = transDetailPopupTable.insertRow(-1);
                row.style.fontWeight = "bold";
                row.innerHTML = "<td colspan='3'></td><td>" + $quantity + "</td><td>" + $total.toLocaleString() + "</td>";

                document.getElementById("transDetailPopup").style.display = "block";
                return;
            }
            <?php endforeach;
            ?>
            alert("Không tìm thấy đơn hàng " + transId);
        }

        $('.getDetailBnt').click(function () {
            let transId = $(this).closest('tr').find('td').eq(0).text();
            showPopup(transId);
        });
        $('#closePopup').click(function () {
            document.getElementById("transDetailPopup").style.display = "none";
            document.getElementById("transDetailPopupTable").innerHTML = "";
        });
        $('.cancelBnt').click(function () {
            let currentRow = $(this).closest('tr');
            let isCanceled = $(currentRow).data('trans-iscanceled');
            let transId = $(currentRow).data('trans-id');
            if (isCanceled == true) {
                alert("Đơn hàng đã được huỷ");
                return;
            }
            if (confirm("Bạn có chắc chắn muốn huỷ đơn hàng này không?")) {
                $.post("", {transId: transId}, function (data) {
                    if (data === "success") {
                        alert("Huỷ đơn hàng thành công");
                        location.reload();
                    } else {
                        alert("Huỷ đơn hàng thất bại");
                    }
                });
            }
        });
    });
</script>
<?php $this->end('main') ?>