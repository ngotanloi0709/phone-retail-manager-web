<div class="modal fade" id="userTransactionDetailModal" tabindex="-1"
     aria-labelledby="userDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userDetailModalLabel">Thông tin chi tiết hoá đơn</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex mb-3">
                    <h3 class="mx-auto">Chi tiết đơn hàng</h3>
                </div>
                <div>
                    <p><b>Mã hoá đơn: <span id="transactionDetailId"></span></b></p>
                    <p><b>Tên nhân viên bán hàng: <span id="transactionDetailUserName"></span></b></p>
                    <p><b>Tên khách hàng: <span id="transactionDetailCustomerName"></span></b></p>
                    <p><b>Số điện thoại khách hàng: <span id="transactionDetailCustomerPhone"></span></b></p>
                    <p><b>Thời gian: <span id="transactionDetailDateCreated"></span></b></p>
                </div>
                <table class="table table-hover table-striped table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">Tên sản phẩm</th>
                        <th scope="col">Số lượng</th>
                        <th scope="col">Đơn giá</th>
                    </tr>
                    </thead>
                    <tbody class="transactionDetailTableBody">
                    </tbody>
                </table>
                <div class="d-flex">
                    <h3 class="ms-auto">Tổng giá trị hoá đơn: <span id="transactionDetailTotal"></span> vnđ</h3>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>