<div class="modal fade" id="userDetailModal" tabindex="-1"
     aria-labelledby="userDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userDetailModalLabel">Thông tin chi tiết người dùng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col-4 mx-auto mb-5 position-relative">
                    <div class="ratio ratio-1x1 card-img-top">
                        <img id="detailInformationAvatar" src="/image/user-default-avatar.png"
                             class="rounded-circle overflow-hidden"
                             alt="default-avatar" onerror="this.onerror=null; this.src='/image/user-default-avatar.png';">
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label for="detailInformationEmail" class="form-label">Địa chỉ Email:</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-envelope"></i></span>
                            <input id="detailInformationEmail" type="text" class="form-control" placeholder="Email"
                                   aria-label="Email"
                                   aria-describedby="basic-addon1" disabled readonly>
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="detailInformationUsername" class="form-label">Username:</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-user"></i></span>
                            <input id="detailInformationUsername" type="text" class="form-control" placeholder="Username"
                                   aria-label="Username"
                                   aria-describedby="basic-addon1" disabled readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label for="detailInformationName" class="form-label">Họ và tên:</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-bars"></i></span>
                            <input id="detailInformationName" type="text" class="form-control" placeholder="Họ và tên" aria-label="Name"
                                   aria-describedby="basic-addon1" disabled readonly>
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="detailInformationIdentityNumber" class="form-label">Số chứng minh:</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-address-card"></i></span>
                            <input id="detailInformationIdentityNumber" type="text" class="form-control" placeholder="Số chứng minh"
                                   aria-label="identityNumber" aria-describedby="basic-addon1" disabled readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label for="detailInformationPhone" class="form-label">Số điện thoại:</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-phone"></i></span>
                            <input id="detailInformationPhone" type="text" class="form-control" placeholder="Số điện thoại"
                                   aria-label="phone" aria-describedby="basic-addon1" disabled readonly>
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="detailInformationAddress" class="form-label">Địa chỉ:</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-location-dot"></i></span>
                            <input id="detailInformationAddress" type="text" class="form-control" placeholder="Địa chỉ"
                                   aria-label="address"
                                   aria-describedby="basic-addon1" disabled readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label for="detailInformationGender" class="form-label">Giới tính:</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-venus-mars"></i></i></span>
                            <input id="detailInformationGender" type="text" class="form-control" placeholder="Giới tính"
                                   aria-label="gender"
                                   aria-describedby="basic-addon1" disabled readonly>
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="detailInformationDateOfBirth" class="form-label">Ngày sinh:</label>
                        <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1"><i
                                class="fa-regular fa-calendar-days"></i></i></span>
                            <input id="detailInformationDateOfBirth" type="text" class="form-control" placeholder="Ngày sinh"
                                   aria-label="dateOfBirth"
                                   aria-describedby="basic-addon1" disabled readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>