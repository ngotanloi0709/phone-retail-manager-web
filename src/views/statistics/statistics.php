<?php $this->layout('base',
    [
        'title' => 'Thống kê doanh thu',
        'header' => 'Thống kê doanh thu',
        'isShowAside' => false
    ]) ?>
<?php $this->start('main') ?>
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
    });
</script>
<?php $this->end('main') ?>
