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
        <button class="btn btn-outline-warning" onclick="history.back()"><i class='fas fa-reply'></i> Về Trang Tạo Đơn Hàng</button>
        <a href="/transaction/transaction_management" class="btn btn-outline-warning"><i class="fa-solid fa-boxes"></i> Quản Lý Đơn Hàng</a>
    </div>
    <div class="card-body" style="min-height:800px;">
        <form action="" method="post" onkeydown="return event.key != 'Enter';">
            <div class="row">
                <div class="col-sm-9 col-md-6 col-lg-8">
                    <table id="productList" class="table table-bordered">
                        <tr>
                            <th>Tên sản phẩm</th>
                            <th>Mã sản phẩm</th>
                            <th>Đơn giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                        </tr>
                        <tr style="font-weight: bold;">
                            <td colspan="3"></td>
                            <td id="totalQuantity"></td>
                            <td id="totalMoney"></td>
                        </tr>
                    </table>
                </div>

                <div class="col-sm-3 col-md-6 col-lg-4">
                    
                    <div class="form-group" id="customerInfo">
                        <div id="createNewCustomerDiv" style="display: none">
                            <label for="createNewCustomer"><i class='fas fa-user-edit'></i> Khách hàng mới:</label>
                            <input type="checkbox" id="createNewCustomerCheckbox" name="createNewCustomer">
                        </div>
                        <label for="customerPhone">Số điện thoại khách hàng:</label>
                        <input type="text" class="form-control" id="customerPhone" name="customerPhone" placeholder="Nhập số điện thoại và nhấn Enter!" required>
                        <label for="customerName">Tên khách hàng:</label>
                        <input type="text" class="form-control" id="customerName" name="customerName" placeholder="Nhập số điện thoại phía trên" readonly>
                        <label for="customerAddress">Địa chỉ khách hàng:</label>
                        <input type="text" class="form-control" id="customerAddress" name="customerAddress" placeholder="Nhập số điện thoại phía trên" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label for="total">Tổng tiền đơn hàng:</label>
                        <input type="text" class="form-control" id="total" required readonly>
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

                    <button id="submitTransButton" class="btn btn-outline-secondary" style="float: right;"><i class='fas fa-shopping-basket'></i> Tạo đơn</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function(){
        <?php
        if (isset($productIdArray) && isset($productQuantityArray)) {
            for ($i = 0; $i < sizeof($productIdArray); $i++) {
                echo "addToTrans(" . $productIdArray[$i] . ", " . $productQuantityArray[$i] . ");";
            }
        }
        echo "getTotal();";
        ?>

        var cusName = document.getElementById("customerName");
        var cusAddress = document.getElementById("customerAddress");

        function addToTrans(id, quantity) {
            <?php /** @var array $products */
            foreach ($products as $product): ?>
                if (id == "<?= $product->getId() ?>") {
                    var price = <?= $product->getPrice() ?>;
                    var productName = "<?= $product->getName() ?>";
                }
            <?php endforeach; ?>
            let productList = document.getElementById("productList");
            let row = productList.insertRow(productList.rows.length - 1);
            let nameCell = row.insertCell(0);
            let idCell = row.insertCell(1);
            let priceCell = row.insertCell(2);
            let quantityCell = row.insertCell(3);
            let totalCell = row.insertCell(4);
            nameCell.innerHTML = productName;
            idCell.innerHTML = "<input type='text' name='productId[]' style='text-align:center; border: none;' value='" + id + "' readonly/>";
            priceCell.innerHTML = price.toLocaleString();
            quantityCell.innerHTML = "<input type='text' name='productQuantity[]' style='text-align:center; border: none;' value='" + quantity + "' readonly/>";
            let total = price * quantity;
            totalCell.innerHTML = total.toLocaleString();
        }

        function getTotal() {
            let total = 0;
            let quantity = 0;
            let productList = document.getElementById("productList");
            for (let i = 1; i < productList.rows.length - 1; i++) {
                quantity += parseInt(productList.rows[i].cells[3].children[0].value);
                total += parseInt(productList.rows[i].cells[4].innerHTML.replace(/[,\.]/g, ''));
            }
            document.getElementById("totalQuantity").innerHTML = quantity;
            document.getElementById("totalMoney").innerHTML = total.toLocaleString();
            document.getElementById("total").value = total.toLocaleString();
        }

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
                            document.getElementById("createNewCustomerCheckbox").setAttribute("checked", "");
                            document.getElementById("createNewCustomerCheckbox").value = "yes";
                            document.getElementById("createNewCustomerDiv").style.display = "block";
                            cusName.value = "";
                            cusName.removeAttribute("readonly");
                            cusName.setAttribute("placeholder", "Nhập tên khách hàng");
                            cusName.setAttribute("required", "");
                            cusAddress.value = "";
                            cusAddress.removeAttribute("readonly");
                            cusAddress.setAttribute("placeholder", "Nhập địa chỉ khách hàng");
                            cusAddress.setAttribute("required", "");
                            return;
                        }
                        let responce = result.split("-");
                        document.getElementById("customerPhone").value = $str;
                        cusName.value = responce[0];
                        cusAddress.value = responce[1];
                        document.getElementById("createNewCustomerCheckbox").removeAttribute("checked");
                        document.getElementById("createNewCustomerCheckbox").value = "no";
                        document.getElementById("createNewCustomerDiv").style.display = "none";
                        cusName.setAttribute("readonly", "");
                        cusAddress.setAttribute("readonly", "");
                    }
                });
            }
        });

        $("#givenMoney").on("keyup", function() {
            if (event.key === "Enter" || event.keyCode === 13) {
                let total = parseInt($("#total").val().replace(/[,\.]/g, ''));

                let givenMoney = parseInt($(this).val());
                $("#givenMoney").val(givenMoney.toLocaleString());
                givenMoney = parseInt($(this).val().replace(/[,\.]/g, ''));

                let change = givenMoney - total;
                $("#change").val(change.toLocaleString());
            }
        });

        $("#paymentMethod").on("change", function() {
            if ($("#paymentMethod").val() == "cash") {
                $("#givenMoney").closest(".form-group").removeAttr("hidden");
                $("#change").closest(".form-group").removeAttr("hidden");
                $("#givenMoney").val(null);
                $("#givenMoney").attr("required", "required");
            } else {
                let total = parseInt($("#total").val().replace(/[,\.]/g, ''));
                $("#givenMoney").val(total);
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
            let paymentMethod = $("#paymentMethod").val();
            let givenMoney = $("#givenMoney").val();
            givenMoney = parseInt(givenMoney.replace(/[,\.]/g, ''));
            $("#givenMoney").val(givenMoney);
        });

        $("#createNewCustomerCheckbox").on("change", function() {
            if (this.checked) {
                this.value = "yes";
                cusName.value = "";
                cusName.removeAttribute("readonly");
                cusName.setAttribute("placeholder", "Nhập tên khách hàng");
                cusName.setAttribute("required", "");
                cusAddress.value = "";
                cusAddress.removeAttribute("readonly");
                cusAddress.setAttribute("placeholder", "Nhập địa chỉ khách hàng");
                cusAddress.setAttribute("required", "");
            } else {
                this.value = "no";
                cusName.value = "";
                cusName.setAttribute("readonly", "");
                cusName.setAttribute("placeholder", "Nhập số điện thoại phía trên");
                cusAddress.value = "";
                cusAddress.setAttribute("readonly", "");
                cusAddress.setAttribute("placeholder", "Nhập số điện thoại phía trên");
            }
        });
    });
</script>
<?php $this->end('main') ?>