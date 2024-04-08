<?php $this->layout('base',
    [
        'title' => 'Tạo Đơn Hàng',
        'header' => 'Tạo Đơn Hàng',
        'isShowAside' => false
    ]) 
?>

<?php $this->start('main') ?>
<div>
    <label for="productName">Product Name:</label>
    <!-- <input type="text" id="productName"/> -->
    <input type="text" id="productName"/>
    <ul id="productSuggestList"></ul>
    <a id="addToTrans" class="btn btn-primary">Add</a>
</div>
<table id="productList" class="table">
    <tr>
        <th>Product Name</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Total</th>
    </tr>
</table>
<script>
    $(document).ready(function(){
        $("#productName").on("keyup", function() {
            str = document.getElementById("productName").value;
            if (str.length == 0) {
                document.getElementById("productSuggestList").innerHTML = "";
                return;
            }
            $str = $("#productName").val();
            $.ajax({
                url: '/transaction/get_suggestion',
                type: 'GET',
                data: 'q='+$str,
                success: function(result){
                    document.getElementById("productSuggestList").innerHTML = result;
                }
            });
        });

        $("#addToTrans").on("click", function() {
            var productName = document.getElementById("productName").value;
            <?php foreach ($products as $product): ?>
                if (productName == "<?= $product->getName() ?>") {
                    var price = <?= $product->getPrice() ?>;
                }
            <?php endforeach; ?>
            var productList = document.getElementById("productList");
            var row = productList.insertRow(-1);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);
            cell1.innerHTML = productName;
            cell2.innerHTML = price;
            cell3.innerHTML = "<input type='number' value='1' min='0'/>";
            cell4.innerHTML = price;
            document.getElementById("productName").value = null;
        });
    });
</script>
<?php $this->end('main') ?>