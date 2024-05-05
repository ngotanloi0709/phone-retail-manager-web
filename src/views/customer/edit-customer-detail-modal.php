<div class="modal fade" id="editCustomerInformationModal" tabindex="-1"
     aria-labelledby="editCustomerInformationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCustomerInformationModalLabel">Chỉnh sửa thông tin khách hàng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editCustomerForm" method="post" action="/customer/edit-customer">
                <input type="hidden" name="id" id="editCustomerInformationId">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <label for="editCustomerInformationEmail" class="form-label">Địa chỉ Email:</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1"><i
                                            class="fa-solid fa-envelope"></i></span>
                                <input id="editCustomerInformationEmail" type="email" class="form-control"
                                       placeholder="Email"
                                       aria-label="Email"
                                       aria-describedby="basic-addon1" name="email" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="editCustomerInformationName" class="form-label">Họ và tên:</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-bars"></i></span>
                                <input id="editCustomerInformationName" type="text" class="form-control"
                                       placeholder="Họ và tên" aria-label="Name"
                                       aria-describedby="basic-addon1" name="name">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label for="editCustomerInformationPhone" class="form-label">Số điện thoại:</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1"><i
                                            class="fa-solid fa-phone"></i></span>
                                <input id="editCustomerInformationPhone" type="text" class="form-control"
                                       placeholder="Số điện thoại"
                                       aria-label="phone" aria-describedby="basic-addon1"
                                       name="phone">
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="editCustomerInformationAddress" class="form-label">Địa chỉ:</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1"><i
                                            class="fa-solid fa-location-dot"></i></span>
                                <input id="editCustomerInformationAddress" type="text" class="form-control"
                                       placeholder="Địa chỉ"
                                       aria-label="address"
                                       aria-describedby="basic-addon1"
                                       name="address">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>