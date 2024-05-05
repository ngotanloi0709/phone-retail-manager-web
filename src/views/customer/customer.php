<?php
use app\models\Customer;
use app\utils\DataHelper;
/** @var array $customers */
$this->layout('base',
    [
        'title' => 'Quản Lý Khách Hàng',
        'header' => 'Quản Lý Khách Hàng',
        'isShowAside' => true
    ])?>
<?php $this->start('main') ?>
<?= $this->insert('customer/edit-customer-detail-modal') ?>
<?= $this->insert('customer/delete-customer-modal') ?>
<div class="card">
    <div class="card-header">
        <b>Bảng thông tin khách hàng</b>
    </div>
    <div class="card-body">
        <table class="table table-hover table-striped table-bordered long-table">
            <thead>
            <tr>
                <th scope="col">Họ và tên</th>
                <th scope="col">Email</th>
                <th scope="col">Số điện thoại</th>
                <th scope="col">Địa chỉ</th>
                <th scope="col">Thao tác</th>
            </tr>
            </thead>
            <tbody>
            <?php 
                if(count($customers) == 0) {
                    echo '<tr><td colspan="6">Chưa có khách hàng</td></tr>';
                } else {
                    /** @var Customer $customer */
                    foreach ($customers as $customer){
                        echo '<tr data-customer-name="' . $customer->getName()
                        . '" data-customer-email="' . DataHelper::getDisplayStringData($customer->getEmail())
                        . '" data-customer-phone="' . $customer->getPhone()
                        . '" data-customer-address="' . DataHelper::getDisplayStringData($customer->getAddress())
                        . '" data-customer-id="' . $customer->getId()
                        . '">';
                        echo '<td>' . DataHelper::getDisplayStringData($customer->getName()) . '</td>';
                        echo '<td>' . DataHelper::getDisplayStringData($customer->getEmail()) . '</td>';
                        echo '<td>' . DataHelper::getDisplayStringData($customer->getPhone()) . '</td>';
                        echo '<td>' . DataHelper::getDisplayStringData(substr($customer->getAddress(), 0, 20)) . '...</td>';
                        echo '<td>';
                        echo '<a class="buttonEditCustomerInformation btn btn-warning btn-sm me-1"><span><i class="fa-regular fa-pen-to-square"></i></span> Chi tiết</a>';
                        echo '<a class="buttonDeleteCustomerInformation btn btn-danger btn-sm me-1"><span><i class="fa-solid fa-trash"></i></span> Xóa</a>';
                        echo '<a href="/customer/customer_transhistory?customerid='. $customer->getId().' " class="btn btn-primary btn-sm me-1"><span><i class="fa-solid fa-circle-info"></i></span> Xem lịch sử mua hàng</a>';
                        echo '</td>';
                    echo '</tr>';
                    }
                }
            ?>
            </tbody>
        </table> 
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.buttonEditCustomerInformation').on('click', function () {
        let currentRow = $(this).closest('tr');
        let email = $(currentRow).data('customer-email');
        let name = $(currentRow).data('customer-name');
        let phone = $(currentRow).data('customer-phone');
        let address = $(currentRow).data('customer-address');
        let id = $(currentRow).data('customer-id');

        $('#editCustomerInformationId').val(id);
        if (email === 'Chưa có dữ liệu') {
            $('#editCustomerInformationEmail').val("");
        } else {
            $('#editCustomerInformationEmail').val(email);
        }
        if (name === 'Chưa có dữ liệu') {
            $('#editCustomerInformationName').val("");
        } else {
            $('#editCustomerInformationName').val(name);
        }

        if (phone === 'Chưa có dữ liệu') {
            $('#editCustomerInformationPhone').val("");
        } else {
            $('#editCustomerInformationPhone').val(phone);
        }

        if (address === 'Chưa có dữ liệu') {
            $('#editCustomerInformationAddress').val("");
        } else {
            $('#editCustomerInformationAddress').val(address);
        }

        $('#editCustomerInformationModal').modal('show');
    });
    $('.buttonDeleteCustomerInformation').on('click', function () {
        let currentRow = $(this).closest('tr');
        let id = $(currentRow).data('customer-id');

        $('#idDeleteCustomerConfirmModal').val(id);
        $('#deleteCustomerConfirmModal').modal('show');
    });
    });
    
</script>
<?php $this->end('main') ?>
