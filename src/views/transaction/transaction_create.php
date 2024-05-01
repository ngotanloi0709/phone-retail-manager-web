<?php $this->layout('base',
    [
        'title' => 'Tạo Đơn Hàng',
        'header' => 'Tạo Đơn Hàng',
        'isShowAside' => false
    ]) 
?>

<?php $this->start('main') ?>
<div class="card">
    <div class="card-header">
        <a href="/transaction/transaction_management" class="btn btn-outline-warning"><i class="fa-solid fa-boxes"></i> Quản Lý Đơn Hàng</a>
    </div>
    <div class="card-body" style="min-height:800px;">
        <form action="" method="post" onkeydown="return event.key != 'Enter';">
            <div class="row">
                <div class="col-sm-9 col-md-6 col-lg-8">
                    <div>
                        <label for="productBarcode" style="width:150px;">Barcode sản phẩm:</label>
                        <input type="text" id="productBarcodeValue" readonly/>
                        <input type="file" id="productBarcode" accept="image/*"/><br><br>
                        <label for="productName" style="width:150px;">Tên sản phẩm:</label>
                        <input type="text" id="productName"/>
                        <a id="addToTransButton" class="btn btn-outline-secondary"><i class='far fa-plus-square'></i> Thêm</a>
                        <ul id="productSuggestList"></ul>
                    </div>
                    <table id="productList" class="table">
                        <tr>
                            <th>Tên sản phẩm</th>
                            <th>Mã sản phẩm</th>
                            <th>Đơn giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                            <th>-</th>
                        </tr>
                    </table>
                </div>

                <div class="col-sm-3 col-md-6 col-lg-4">
                    
                    <div class="form-group" id="customerInfo">
                        <div id="createNewCustomerDiv" style="display: none">
                            <label for="createNewCustomer"><i class='fas fa-user-edit'></i> Khách hàng mới:</label>
                            <input type="checkbox" id="createNewCustomerCheckbox" name="createNewCustomer" value="yes" checked>
                        </div>
                        <label for="customerPhone">Số điện thoại khách hàng:</label>
                        <input type="text" class="form-control" id="customerPhone" name="customerPhone" placeholder="Nhập số điện thoại và nhấn Enter!" required>
                        <label for="customerName">Tên khách hàng:</label>
                        <input type="text" class="form-control" id="customerName" name="customerName" placeholder="Nhập số điện thoại phía trên" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label for="total">Tổng tiền đơn hàng:</label>
                        <input type="text" class="form-control" id="total" name="total" required readonly>
                    </div>

                    <div class="form-group">
                        <label for="paymentMethod">Phương thức thanh toán:</label>
                        <select multiple="multiple" size="2" class="form-control form-select mb-3" id="paymentMethod" name="paymentMethod" required>
                            <option value="cash">Tiền mặt</option>
                            <option value="card">Thẻ</option>
                        </select>
                    </div>

                    <div hidden class="form-group">
                        <label for="givenMoney">Số tiền khách đưa:</label>
                        <input type="text" class="form-control" id="givenMoney" name="givenMoney" required>
                    </div>

                    <div hidden class="form-group">
                        <label for="change">Tiền thừa:</label>
                        <input type="text" class="form-control" id="change" readonly/>
                    </div>

                    <button id="submitTransButton" class="btn btn-outline-secondary"><i class='fas fa-shopping-basket'></i> Tạo đơn</button>
                </div>
            </div>
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
            <?php /** @var array $products */
            foreach ($products as $product): ?>
                if (productName == "<?= $product->getName() ?>") {
                    var id = <?= $product->getId() ?>;
                    var price = <?= $product->getPrice() ?>;
                }
            <?php endforeach; ?>
            var productList = document.getElementById("productList");
            // Check if product already exists, if so, increase quantity
            for (var i = 0; i < productList.rows.length; i++) {
                if (productList.rows[i].cells[0].innerHTML == productName) {
                    var quantity = parseInt(productList.rows[i].cells[3].children[0].value);
                    productList.rows[i].cells[3].children[0].value = quantity + 1;
                    var total = (quantity+1) * price;
                    productList.rows[i].cells[4].innerHTML = total.toLocaleString();
                    document.getElementById("productName").value = null;
                    document.getElementById("productSuggestList").innerHTML = "";
                    return;
                }
            }
            var row = productList.insertRow(-1);
            var nameCell = row.insertCell(0);
            var idCell = row.insertCell(1);
            var priceCell = row.insertCell(2);
            var quantityCell = row.insertCell(3);
            var totalCell = row.insertCell(4);
            var toDoCell = row.insertCell(5);
            nameCell.innerHTML = productName;
            idCell.innerHTML = "<input type='text' name='productId[]' style='text-align:center;' value='" + id + "' readonly/>";
            priceCell.innerHTML = price.toLocaleString();
            quantityCell.innerHTML = "<input type='number' style='text-align:center;' value='1' min='0' name='productQuantity[]'/>";
            totalCell.innerHTML = price.toLocaleString();
            toDoCell.innerHTML = "<a class='btn btn-danger'>&#10006;</a>";
            document.getElementById("productName").value = null;
            document.getElementById("productSuggestList").innerHTML = "";
        }

        function getTotal() {
            var total = 0;
            var productList = document.getElementById("productList");
            for (var i = 1; i < productList.rows.length; i++) {
                if (productList.rows[i].cells[4].innerHTML == "") {
                    continue;
                }
                let tmp = productList.rows[i].cells[4].innerHTML.replace(/[,\.]/gm, '');

                total += parseInt(tmp);
            }
            document.getElementById("total").value = total.toLocaleString();
        }

        $("#productSuggestList").on("click", "li", function() {
            $("#productName").val($(this).text());
            document.getElementById("productSuggestList").innerHTML = "";
            addToTrans();
            getTotal();
        });

        $("#addToTransButton").on("click", function() {
            var productName = document.getElementById("productName").value;
            var isExistProduct = false;
            <?php foreach ($products as $product): ?>
                if (productName == "<?= $product->getName() ?>") {
                    isExistProduct = true;
                }
            <?php endforeach; ?>
            if (!isExistProduct) {
                alert("Sản phẩm không tồn tại!");
                return;
            }
            addToTrans();
            getTotal();
        });

        $("#productList").on("click", "a", function() {
            $(this).closest("tr").remove();
            getTotal();
        });

        // "this" in below code are $("#productList")
        $("#productList").on("change", "input[type='number']", function() {
            // get name of current product (first column of row)
            var $name = $(this).closest("tr").find("td:nth-child(1)").text();
            // get value of current input (quantity)
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

            var price = $(this).closest("tr").find("td:nth-child(3)").text();
            price = parseInt(price.replace(/[,\.]/g, ''));
            var total = quantity * price;
            $(this).closest("tr").find("td:nth-child(5)").text(total.toLocaleString());

            getTotal();
        });

        $("#customerPhone").on("keyup", function(event) {
            if (event.key === "Enter" || event.keyCode === 13) {
                event.preventDefault();
                if (this.value === "") {
                    document.getElementById("customerName").value = "";
                    return;
                }

                $str = $(this).val();
                if ($str.length == 0) {
                    return;
                }
                $.ajax({
                    url: '/transaction/get_data',
                    type: 'GET',
                    data: 'customerPhone='+$str,
                    success: function(result){
                        if (result == "") {
                            alert("Khách hàng chưa có tài khoản!");
                            document.getElementById("createNewCustomerDiv").style.display = "block";
                            document.getElementById("customerName").value = "";
                            document.getElementById("customerName").removeAttribute("readonly");
                            document.getElementById("customerName").setAttribute("placeholder", "Nhập tên khách hàng");
                            document.getElementById("customerName").setAttribute("required", "");
                            return;
                        }
                        document.getElementById("customerPhone").value = $str;
                        document.getElementById("customerName").value = result;
                    }
                });
            }
        });

        $("#givenMoney").on("keyup", function() {
            if (event.key === "Enter" || event.keyCode === 13) {
                var total = parseInt($("#total").val().replace(/[,\.]/g, ''));

                var givenMoney = parseInt($(this).val());
                $("#givenMoney").val(givenMoney.toLocaleString());
                givenMoney = parseInt($(this).val().replace(/[,\.]/g, ''));

                var change = givenMoney - total;
                $("#change").val(change.toLocaleString());
            }
        });

        $("#paymentMethod").on("change", function() {
            if ($("#paymentMethod").val() == "cash") {
                $("#givenMoney").closest(".form-group").removeAttr("hidden");
                $("#change").closest(".form-group").removeAttr("hidden");
                $("#givenMoney").attr("required", "required");
            } else {
                $("#givenMoney").closest(".form-group").attr("hidden", "");
                $("#change").closest(".form-group").attr("hidden", "");
                $("#givenMoney").removeAttr("required");
            }
        });

        $("#submitTransButton").on("click", function(event) {
            if ($("#paymentMethod").val() == "cash" && $("#change").val() < 0) {
                alert("Số tiền nhận không đủ!");
                event.preventDefault();
                return;
            }
            if ($("#productList").find("tr").length == 1) {
                alert("Chưa có sản phẩm nào trong đơn hàng!");
                event.preventDefault();
                return;
            }
            var paymentMethod = $("#paymentMethod").val();
            var givenMoney = $("#givenMoney").val();
            givenMoney = parseInt(givenMoney.replace(/[,\.]/g, ''));
        });

        $("#productBarcode").on("change", function() {
            var file = document.getElementById("productBarcode").files[0];
            var reader = new FileReader();
            reader.onload = function(e) {
                var img = new Image();
                img.src = e.target.result;
                img.onload = function() {
                    var barcode = new BarcodeDetector();
                    barcode.detect(img).then(barcodes => {
                        if (barcodes.length == 0) {
                            alert("Không tìm thấy barcode!");
                            return;
                        }
                        var barcodeValue = barcodes[0].rawValue;
                        document.getElementById("productBarcodeValue").value = barcodeValue;
                        var productName = "";
                        <?php foreach ($products as $product): ?>
                            if (barcodeValue == "<?= $product->getBarcode() ?>") {
                                productName = "<?= $product->getName() ?>";
                            }
                        <?php endforeach; ?>
                        if (productName == "") {
                            alert("Sản phẩm không tồn tại!");
                            return;
                        }
                        document.getElementById("productName").value = productName;
                        addToTrans();
                        getTotal();
                    });
                }
            }
            reader.readAsDataURL(file);
        });

        $("#createNewCustomerCheckbox").on("change", function() {
            if (this.checked) {
                document.getElementById("customerName").value = "";
                document.getElementById("customerName").removeAttribute("readonly");
                document.getElementById("customerName").setAttribute("placeholder", "Nhập tên khách hàng");
                document.getElementById("customerName").setAttribute("required", "");
            } else {
                document.getElementById("customerName").value = "";
                document.getElementById("customerName").setAttribute("readonly", "");
                document.getElementById("customerName").setAttribute("placeholder", "Nhập số điện thoại phía trên");
            }
        });
    });
</script>
<?php $this->end('main') ?>