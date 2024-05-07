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

<?php
    /** @var array $transactions */
    $transactions = array_reverse($transactions);

    $transactionsPerPage = 10;
    /** @var array $transaction */
    $totalPages = ceil(count($transactions) / $transactionsPerPage);
    $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $currentPage = max(1, min($currentPage, $totalPages));
    $start = ($currentPage - 1) * $transactionsPerPage;
    $currentTransactions = array_slice($transactions, $start, $transactionsPerPage);
?>

<div id="transDetailPopup" class="popup">
    <div class="popup-content" style="overflow-x:auto;">
        <button id="closePopup">&#10006;</button>
        <div id="transInfo"></div>
        <table class="table table-bordered table-hover" id="transDetailPopupTable">

        </table>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <a href="/transaction/transaction_create" class="btn btn-outline-warning"><i class="fa-solid fa-inbox"></i> Tạo
            Đơn Hàng</a>
    </div>
    <div class="card-body" style="overflow-x:auto;">
        <div style="display: flex; align-items: center; margin-bottom: 8px">
            <label for="searchTransById" style="margin-right: 8px">Tìm Đơn Hàng:</label>
            <input type="text" id="searchTransById" class="form-control" style="width: 300px; margin-right: 8px" placeholder="Nhập ID Đơn Hàng">
            <button class="btn btn-outline-secondary" id="searchTransByIdBtn"><i class="fas fa-search"></i></button>
            <div class="clearfix" style="display: flex; margin-left: 450px; margin-top: 13px;">
                <ul class="pagination">
                    <li class="page-item <?php echo $currentPage == 1 ? 'disabled' : ''; ?>"><a href="?page=<?php echo $currentPage - 1; ?>" class="page-link">Trước</a></li>
                    <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                        <li class="page-item <?php echo $i == $currentPage ? 'active' : ''; ?>"><a href="?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a></li>
                    <?php endfor; ?>
                    <li class="page-item <?php echo $currentPage == $totalPages ? 'disabled' : ''; ?>"><a href="?page=<?php echo $currentPage + 1; ?>" class="page-link">Sau</a></li>
                </ul>
            </div>
        </div>
        <table class="table table-bordered table-hover table-striped">
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
            /** @var Transaction $transaction */
            foreach ($currentTransactions as $transaction) : ?>
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

        <div class="clearfix">
            <ul class="pagination">
                <li class="page-item <?php echo $currentPage == 1 ? 'disabled' : ''; ?>"><a href="?page=<?php echo $currentPage - 1; ?>" class="page-link">Trước</a></li>
                <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                    <li class="page-item <?php echo $i == $currentPage ? 'active' : ''; ?>"><a href="?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a></li>
                <?php endfor; ?>
                <li class="page-item <?php echo $currentPage == $totalPages ? 'disabled' : ''; ?>"><a href="?page=<?php echo $currentPage + 1; ?>" class="page-link">Sau</a></li>
            </ul>
        </div>
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

        const tableRows = document.querySelectorAll("tbody tr");
        tableRows.forEach(row => {
            row.addEventListener("dblclick", function() {
                const transactionId = row.dataset.id;
                window.location.href = "/transaction_management/view-transaction?id=${transactionId}";
            });
        });
    });
</script>
<?php $this->end('main') ?>

