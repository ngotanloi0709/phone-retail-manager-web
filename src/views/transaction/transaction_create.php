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
            <a id="addToTransButton" class="btn btn-primary">Add</a>
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
        
        <form action="" method="post" onkeydown="return event.key != 'Enter';">
            <div class="form-group">
                <label for="customerId">Số điện thoại khách hàng:</label>
                <input type="text" class="form-control" id="customerId" name="customerId" required>
                <label for="customerName">Tên khách hàng:</label>
                <input type="text" class="form-control" id="customerName" placeholder="Nhập số điện thoại phía trên" readonly>
            </div>
            
            <div class="form-group">
                <label for="total">Total:</label>
                <input type="text" class="form-control" id="total" name="total" required readonly>
            </div>

            <div class="form-group">
                <label for="paymentMethod">Payment Method:</label>
                <select multiple="multiple" size="2" class="form-control" id="paymentMethod">
                    <option value="cash">Cash</option>
                    <option value="card">Card</option>
                </select>
            </div>

            <div hidden class="form-group">
                <label for="givenMoney">Given Money:</label>
                <input type="text" class="form-control" id="givenMoney"/>
            </div>

            <div hidden class="form-group">
                <label for="change">Change:</label>
                <input type="text" class="form-control" id="change" readonly/>
            </div>

            <button id="submitTrans" class="btn btn-primary">Submit</button>
        </form>
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
                url: '/transaction/get_data',
                type: 'GET',
                data: 'name='+$str,
                success: function(result){
                    document.getElementById("productSuggestList").innerHTML = result;
                }
            });
        });

        function addToTrans() {
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

        function getTotal() {
            var total = 0;
            var productList = document.getElementById("productList");
            for (var i = 1; i < productList.rows.length; i++) {
                if (productList.rows[i].cells[3].innerHTML == "") {
                    continue;
                }
                total += parseInt(productList.rows[i].cells[3].innerHTML);
            }
            document.getElementById("total").value = total;
        }

        $("#productSuggestList").on("click", "li", function() {
            $("#productName").val($(this).text());
            document.getElementById("productSuggestList").innerHTML = "";
            addToTrans();
            getTotal();
        });

        $("#addToTransButton").on("click", function() {
            addToTrans();
            getTotal();
        });

        $("#productList").on("click", "a", function() {
            $(this).closest("tr").remove();
            getTotal();
        });

        $("#productList").on("change", "input[type='number']", function() {
            var $name = $(this).closest("tr").find("td:nth-child(1)").text();
            var quantity = parseInt($(this).val());
            
            var inStock = function () {
                var tmp = null;
                $.ajax({
                    'async': false,
                    'type': "GET",
                    'global': false,
                    'dataType': 'html',
                    'url': '/transaction/get_data',
                    'data': 'nameToGetStock='+$name,
                    'success': function (data) {
                        tmp = data;
                    }
                });
                return parseInt(tmp);
            }();
                       
            if (quantity > inStock) {
                alert("Số lượng sản phẩm " + $name + " trong kho: " + inStock);
                $(this).val(inStock);
                quantity = inStock;
            }
            
            if (quantity <= 0) {
                $(this).val(1);
                quantity = 1;
            }

            var price = $(this).closest("tr").find("td:nth-child(2)").text();
            var total = quantity * price;
            $(this).closest("tr").find("td:nth-child(4)").text(total);

            getTotal();
        });

        $("#customerId").on("keyup", function(event) {
            if (event.key === "Enter" || event.keyCode === 13) {
                event.preventDefault();
                $str = $(this).val();
                if ($str.length == 0) {
                    return;
                }
                $.ajax({
                    url: '/transaction/get_data',
                    type: 'GET',
                    data: 'customerId='+$str,
                    success: function(result){
                        if (result == "") {
                            alert("Khách hàng chưa có tài khoản!");
                            return;
                        }
                        document.getElementById("customerId").value = $str;
                        document.getElementById("customerName").value = result;
                    }
                });
            }
        });

        $("#givenMoney").on("keyup", function() {
            if (event.key === "Enter" || event.keyCode === 13) {
                var total = parseInt($("#total").val());
                var givenMoney = parseInt($(this).val());
                var change = givenMoney - total;
                $("#change").val(change);
            }
        });

        $("#paymentMethod").on("change", function() {
            if ($("#paymentMethod").val() == "cash") {
                $("#givenMoney").closest(".form-group").removeAttr("hidden");
                $("#change").closest(".form-group").removeAttr("hidden");
            } else {
                $("#givenMoney").closest(".form-group").attr("hidden", "");
                $("#change").closest(".form-group").attr("hidden", "");
            }
        });

        // $("#submitTrans").on("click", function() {

        // });
    });
</script>
<?php $this->end('main') ?>