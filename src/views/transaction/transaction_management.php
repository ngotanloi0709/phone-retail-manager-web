<?php use app\models\Transaction;
use app\utils\DataHelper;

$this->layout('base',
    [
        'title' => 'Quản Lý Đơn Hàng',
        'header' => 'Quản Lý Đơn Hàng',
        'isShowAside' => false
    ]) ?>

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
        <a href="/transaction/transaction_create" class="btn btn-outline-warning"><i class="fa-solid fa-inbox"></i> Tạo
            Đơn Hàng</a>
    </div>
    <div class="card-body">
        <div style="display: flex; align-items: center; margin-bottom: 8px">
            <label for="searchTransById" style="margin-right: 8px">Tìm Đơn Hàng:</label>
            <input type="text" id="searchTransById" class="form-control" style="width: 300px; margin-right: 8px" placeholder="Nhập ID Đơn Hàng">
            <button class="btn btn-outline-secondary" id="searchTransByIdBtn"><i class="fas fa-search"></i></button>
        </div>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Thời Gian Tạo</th>
                <th>Khách Hàng</th>
                <th>Người Tạo</th>
                <th>Trạng Thái</th>
                <th>Thao Tác</th>
            </tr>
            </thead>
            <tbody>
            <?php
            /** @var array $transactions */
            $transactions = array_reverse($transactions);
            /** @var Transaction $transaction */
            foreach ($transactions as $transaction) : ?>
                <?php 
                    if (DataHelper::getDisplayStringData($transaction->getIsCanceled()) === "Chưa có dữ liệu") {
                        $status = "Đã Hoàn Tất";
                    }
                    else {
                        $status = $transaction->getIsCanceled() ? "Đã Huỷ" : "Đã Hoàn Tất";
                    }
                ?>

                <tr>
                    <td><?= $transaction->getId() ?></td>
                    <td><?= $transaction->getCreated()->format('d/m/Y H:i:s') ?></td>
                    <td><?= DataHelper::getDisplayStringData($transaction->getCustomer()->getName()) ?></td>
                    <td><?= $transaction->getUser()->getUsername() ?></td>
                    <td><?= $status ?></td>
                    <td>
                        <button class="btn btn-outline-info getDetailBnt"><i class="fa-solid fa-circle-info"></i> Chi tiết</button>
                        <button class="btn btn-outline-danger cancelBnt"><i class="fa-solid fa-circle-xmark"></i> Huỷ đơn hàng</button>
                    </td>
                </tr>
            <?php endforeach;
            ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).ready(function () {
        //render new tab contains transaction's invoice if this page been call from transaction_checkout
        if (window.location.href.indexOf("paymentMethod=cash") !== -1) {
            let givenMoney = new URLSearchParams(window.location.search).get('givenMoney');
            window.open("/transaction/transaction_invoice?paymentMethod=cash&givenMoney=" + givenMoney, "_blank");
            window.location.href = "/transaction/transaction_management";
        }
        if (window.location.href.indexOf("paymentMethod=card") !== -1) {
            window.open("/transaction/transaction_invoice?paymentMethod=card", "_blank");
            window.location.href = "/transaction/transaction_management";
        }

        function showPopup(transId) {
            <?php
            foreach ($transactions as $transaction) : ?>

            if (transId === '<?= $transaction->getId() ?>') {
                <?php 
                    if (DataHelper::getDisplayStringData($transaction->getIsCanceled()) === "Chưa có dữ liệu") {
                        $status = "Đã Hoàn Tất";
                    }
                    else {
                        $status = $transaction->getIsCanceled() ? "Đã Huỷ" : "Đã Hoàn Tất";
                    }
                ?>
                document.getElementById("transInfo").innerHTML = "<h3>CHI TIẾT ĐƠN HÀNG <?= $transaction->getId() ?></h3><p>Thời Gian Tạo: <?= $transaction->getCreated()->format('d/m/Y H:i:s') ?></p><p>Khách Hàng: <?= /** @var Transaction $transaction */
                    DataHelper::getDisplayStringData($transaction->getCustomer()->getName()) ?></p><p>Số điện thoại khách hàng: <?= $transaction->getCustomer()->getPhone() ?></p><p>Người Tạo: <?= $transaction->getUser()->getUsername() ?></p><p>Trạng Thái: <?= $status ?></p>";
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

        $(".getDetailBnt").click(function () {
            let transId = $(this).closest('tr').find('td').eq(0).text();
            showPopup(transId);
        });

        $(".cancelBnt").click(function () {
            if ($(this).closest('tr').find('td').eq(4).text() === "Đã Huỷ") {
                alert("Đơn hàng đã được huỷ");
                return;
            }
            let transId = $(this).closest('tr').find('td').eq(0).text();
            if (confirm("Bạn có chắc chắn muốn huỷ đơn hàng " + transId + " không?")) {
                $.post("", {transId: transId}, function (data) {
                    if (data === "success") {
                        alert("Huỷ đơn hàng " + transId + " thành công");
                        location.reload();
                    } else {
                        alert("Huỷ đơn hàng " + transId + " thất bại");
                    }
                });
            }
        })

        $('#closePopup').click(function () {
            document.getElementById("transDetailPopup").style.display = "none";
            document.getElementById("transDetailPopupTable").innerHTML = "";
        });

        $('#searchTransByIdBtn').click(function () {
            let transId = $('#searchTransById').val();
            showPopup(transId);
        });

        $('#searchTransById').on("keyup", function (event) {
            if (event.key === "Enter" || event.keyCode === 13) {
                let transId = $('#searchTransById').val();
                showPopup(transId);
            }
        });
    });
</script>
<?php $this->end('main') ?>

