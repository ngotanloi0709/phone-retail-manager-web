<?php $this->layout('base',
    [
        'title' => 'Tạo Đơn Hàng',
        'header' => 'Tạo Đơn Hàng',
        'isShowAside' => false
    ]) 
?>

<?php $this->start('main') ?>
<div class="row">
    <div class="col-sm-9 col-md-6 col-lg-8">
        <form>
            <label for="productName">Product Name:</label>
            <input type="text" id="productName"/>
            <a id="addToTrans" class="btn btn-primary">Add</a>
            <ul id="productSuggestList"></ul>
        </form>
        <table id="productList" class="table">
            <tr>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>-</th>
            </tr>
        </table>
    </div>

    <div class="col-sm-3 col-md-6 col-lg-4">
        <label for="customerId">Customer:</label>
        <input type="text" id="customerId"/>
        <button id="submitTrans" class="btn btn-primary">Create Transaction</button>
    </div>
</div>

<script>
    $(document).ready(function(){
        $("#productName").on("keyup", function() {
            $str = $("#productName").val();
            if ($str.length == 0) {
                document.getElementById("productSuggestList").innerHTML = "";
                return;
            }
            $.ajax({
                url: '/transaction/get_suggestion',
                type: 'GET',
                data: 'name='+$str,
                success: function(result){
                    document.getElementById("productSuggestList").innerHTML = result;
                }
            });
        });

        function addToTransFunct() {
            var productName = document.getElementById("productName").value;
            <?php foreach ($products as $product): ?>
                if (productName == "<?= $product->getName() ?>") {
                    var price = <?= $product->getPrice() ?>;
                }
            <?php endforeach; ?>
            var productList = document.getElementById("productList");
            for (var i = 0; i < productList.rows.length; i++) {
                if (productList.rows[i].cells[0].innerHTML == productName) {
                    var quantity = parseInt(productList.rows[i].cells[2].children[0].value) + 1;
                    productList.rows[i].cells[2].children[0].value = quantity;
                    var total = quantity * price;
                    productList.rows[i].cells[3].innerHTML = total;
                    document.getElementById("productName").value = null;
                    document.getElementById("productSuggestList").innerHTML = "";
                    return;
                }
            }
            var row = productList.insertRow(-1);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);
            var cell5 = row.insertCell(4);
            cell1.innerHTML = productName;
            cell2.innerHTML = price;
            cell3.innerHTML = "<input type='number' value='1' min='0'/>";
            cell4.innerHTML = price;
            cell5.innerHTML = "<a class='btn btn-danger'>&#10006;</a>";
            document.getElementById("productName").value = null;
            document.getElementById("productSuggestList").innerHTML = "";
        }

        $("#productSuggestList").on("click", "li", function() {
            $("#productName").val($(this).text());
            addToTransFunct();
            document.getElementById("productSuggestList").innerHTML = "";
        });

        $("#addToTrans").on("click", function() {
            addToTransFunct();
        });

        $("#productList").on("click", "a", function() {
            $(this).closest("tr").remove();
        });

        $("#productList").on("change", "input[type='number']", function() {
            var $name = $(this).closest("tr").find("td:nth-child(1)").text();
            var quantity = $(this).val();
            
            var inStock;
            $.ajax({
                url: '/transaction/get_suggestion',
                type: 'GET',
                data: 'nameToGetStock='+$name,
                cache: false,
                success: function(result){
                    inStock = JSON.parse(result);
                }
            });
                       
            if (quantity > inStock) {
                $(this).html(inStock);
                alert("Số lượng sản phẩm " + $name + " trong kho: " + inStock);
            }
            
            if (quantity <= 0) {
                $(this).val(1);
                quantity = 1;
            }
            var price = $(this).closest("tr").find("td:nth-child(2)").text();
            var total = quantity * price;
            $(this).closest("tr").find("td:nth-child(4)").text(total);
        });

        // $("#submitTrans").on("click", function() {

        // });
    });
</script>
<?php $this->end('main') ?>