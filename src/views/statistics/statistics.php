<?php 
use app\utils\DataHelper;
$this->layout('base',
    [
        'title' => 'Thống kê doanh thu',
        'header' => 'Thống kê doanh thu',
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
<style>
    form {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
    }
</style>

<div class="card">
    <div class="card-header">
        <h3>Chọn khoảng thời gian</h3>
    </div>
    <div class="card-body">
        <form method="get">

            <label for="timerange">Loại thời gian:</label>
            <select name="timerange" id="timerange" onchange="changeDropDownValue()">
                <option value="blank">(Trống)</option>
                <option value="today">Hôm nay</option>
                <option value="yesterday">Hôm qua</option>
                <option value="7day">Trong 7 ngày trước</option>
                <option value="month">Trong tháng này</option>
            </select>

            <label for="timestart">Ngày bắt đầu:</label>
            <input type="date" id="timestart" name="timestart" onchange="changeTime()">

            <label for="timeend">Ngày kết thúc:</label>
            <input type="date" id="timeend" name="timeend" onchange="changeTime()">

            <input type="submit" value="Tìm kiếm" class="p-2">
        </form>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <h3>Danh sách đơn hàng</h3>
    </div>
    <div class="card-body">
        <div id="infor"></div>
        
    </div>
<script>
    function changeDropDownValue() {
        let timestart = document.getElementById('timestart');
        let timeend = document.getElementById('timeend');

        timestart.disabled = true;
        timeend.disabled = true;
        timestart.value = '';
        timeend.value = '';
        if(document.getElementById('timerange').value == 'blank'){
            timestart.disabled = false;
            timeend.disabled = false;
        }
        compareTime();
    }
    function changeTime() {
        let timerange = document.getElementById('timerange').value ;
        timerange.value = 'blank';
        compareTime();
    }
    function compareTime(){
        let timestartElement = document.getElementById('timestart');
        let timeendElement = document.getElementById('timeend');
        let timestart = new Date(timestartElement.value).getTime() / 1000;
        let timeend = new Date(timeendElement.value).getTime() / 1000;
        if(timestart>=timeend){
            alert("Thời gian không hợp lệ");
            timestartElement.value = '';
            timeendElement.value = '';
        }
    }
    function showPopup(transId) {
            <?php
            foreach ($transactions as $transaction) : ?>

            if (transId === '<?= $transaction->getId() ?>') {
                document.getElementById("transInfo").innerHTML = "<h3>CHI TIẾT ĐƠN HÀNG <?= $transaction->getId() ?></h3><p>Thời Gian Tạo: <?= $transaction->getCreated()->format('d/m/Y H:i:s') ?></p><p>Khách Hàng: <?= /** @var Transaction $transaction */
                    DataHelper::getDisplayStringData($transaction->getCustomer()->getName()) ?></p><p>Người Tạo: <?= $transaction->getUser()->getUsername() ?></p>";
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
    $(document).ready(function(){
        $("form").on("submit", function(event){
            event.preventDefault();
            let formData = $(this).serialize();
            $.ajax({
                url: '/statistics/getdata',
                type: 'GET',
                data: formData, // replace with your data
                success: function(data) {
                    // handle response data
                    $('#infor').html(data);
                }
            });
        });
        $(document).on('click', '.getDetailBnt', function() {
            let transId = $(this).closest('tr').find('td').eq(0).text();
            showPopup(transId);
       });
       
       $(document).on('click', '#closePopup', function() {
           document.getElementById("transDetailPopup").style.display = "none";
           document.getElementById("transDetailPopupTable").innerHTML = "";
       });
    });
    
</script>
<?php $this->end('main') ?>
