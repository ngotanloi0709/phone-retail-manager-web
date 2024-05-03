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
        <div style="display: flex; align-items: center; margin-bottom: 8px">
            <label for="productBarcode" style="width:150px; margin-right: 8px">Barcode sản phẩm:</label>
            <input type="text" id="productBarcodeValue" class="form-control" style="width: 300px; margin-right: 8px" readonly>
            <input type="file" id="productBarcode" accept="image/*"/>
        </div>
        <div style="display: flex; align-items: center; margin-bottom: 8px">
            <label label for="productName" style="width:150px; margin-right: 8px">Tìm sản phẩm:</label>
            <input input type="text" id="productName" class="form-control" style="width: 300px; margin-right: 8px">
            <button id="addToTransButton" class="btn btn-outline-secondary"><i class="fas fa-search"></i></button>
        </div>
        <ul id="productSuggestList" style="margin-left: 150px"></ul>
        <form action="/transaction/transaction_checkout" method="get" onkeydown="return event.key != 'Enter';">
            <table id="productList" class="table table-bordered">
                <tr>
                    <th>Tên sản phẩm</th>
                    <th>Mã sản phẩm</th>
                    <th>Đơn giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                    <th>-</th>
                </tr>
                <tr style="font-weight: bold;">
                    <td colspan="3"></td>
                    <td id="totalQuantity"></td>
                    <td id="totalMoney"></td>
                    <td></td>
                </tr>
            </table>
            <button id="submitTransButton" class="btn btn-outline-secondary" style="width: 180px; float: right; margin:5px;"><i class='fas fa-money-check-alt'></i> </i>Thanh toán</button>
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
            let productList = document.getElementById("productList");
            // Check if product already exists, if so, increase quantity
            for (let i = 0; i < productList.rows.length - 1; i++) {
                if (productList.rows[i].cells[0].innerHTML == productName) {
                    let quantity = parseInt(productList.rows[i].cells[3].children[0].value);
                    productList.rows[i].cells[3].children[0].value = quantity + 1;
                    let total = (quantity+1) * price;
                    productList.rows[i].cells[4].innerHTML = total.toLocaleString();
                    document.getElementById("productName").value = null;
                    document.getElementById("productSuggestList").innerHTML = "";
                    return;
                }
            }
            let row = productList.insertRow(productList.rows.length - 1);
            let nameCell = row.insertCell(0);
            let idCell = row.insertCell(1);
            let priceCell = row.insertCell(2);
            let quantityCell = row.insertCell(3);
            let totalCell = row.insertCell(4);
            let toDoCell = row.insertCell(5);
            nameCell.innerHTML = productName;
            idCell.innerHTML = "<input type='text' name='productId[]' style='text-align:center;' value='" + id + "' readonly/>";
            priceCell.innerHTML = price.toLocaleString();
            quantityCell.innerHTML = "<input type='number' style='text-align:center;' value='1' min='0' name='productQuantity[]'/>";
            totalCell.innerHTML = price.toLocaleString();
            toDoCell.innerHTML = "<button class='btn btn-danger'><i class='fas fa-trash'></i></button>";
            document.getElementById("productName").value = null;
            document.getElementById("productSuggestList").innerHTML = "";
        }

        function getTotal() {
            let quantity = 0;
            let total = 0;
            let productList = document.getElementById("productList");
            for (let i = 1; i < productList.rows.length - 1; i++) {
                if (productList.rows[i].cells[4].innerHTML == "") {
                    continue;
                }
                quantity += parseInt(productList.rows[i].cells[3].children[0].value);
                let tmp = productList.rows[i].cells[4].innerHTML.replace(/[,\.]/gm, '');
                total += parseInt(tmp);
            }
            document.getElementById("totalQuantity").innerHTML = quantity;
            document.getElementById("totalMoney").innerHTML = total.toLocaleString();
            document.getElementById("totalQuantity").innerHTML = quantity;
            document.getElementById("totalMoney").innerHTML = total.toLocaleString();
        }

        $("#productSuggestList").on("click", "li", function() {
            $("#productName").val($(this).text());
            document.getElementById("productSuggestList").innerHTML = "";
            addToTrans();
            getTotal();
        });

        $("#addToTransButton").on("click", function() {
            let productName = document.getElementById("productName").value;
            let isExistProduct = false;
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
            let $name = $(this).closest("tr").find("td:nth-child(1)").text();
            // get value of current input (quantity)
            let quantity = parseInt($(this).val());
            
            let inStock = function () {
                let tmp = null;
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

            let price = $(this).closest("tr").find("td:nth-child(3)").text();
            price = parseInt(price.replace(/[,\.]/g, ''));
            let total = quantity * price;
            $(this).closest("tr").find("td:nth-child(5)").text(total.toLocaleString());

            getTotal();
        });

        $("#submitTransButton").on("click", function(event) {
            if ($("#productList").find("tr").length == 2) {
            if ($("#productList").find("tr").length == 2) {
                alert("Chưa có sản phẩm nào trong đơn hàng!");
                event.preventDefault();
                return;
            }
        });

        $("#productBarcode").on("change", function() {
            let file = document.getElementById("productBarcode").files[0];
            let reader = new FileReader();
            reader.onload = function(e) {
                let img = new Image();
                img.src = e.target.result;
                img.onload = function() {
                    let barcode = new BarcodeDetector();
                    barcode.detect(img).then(barcodes => {
                        if (barcodes.length == 0) {
                            alert("Không tìm thấy barcode!");
                            return;
                        }
                        let barcodeValue = barcodes[0].rawValue;
                        document.getElementById("productBarcodeValue").value = barcodeValue;
                        let productName = "";
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