<div class="modal fade" id="editUserInformationModal" tabindex="-1"
     aria-labelledby="editUserInformationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserInformationModalLabel">Chỉnh sửa thông tin người dùng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editUserForm" method="post" action="/admin/edit-user">
                <input type="hidden" name="id" id="editUserInformationId">
                <div class="modal-body">
                    <div class="col-4 mx-auto mb-5 position-relative">
                        <div class="ratio ratio-1x1 card-img-top">
                            <img id="editUserInformationDisplayAvatar" src="/image/user-default-avatar.png"
                                 class="displayAvatar rounded-circle overflow-hidden"
                                 alt="default-avatar"
                                 style="object-fit: cover !important;"
                                 onerror="this.onerror=null; this.src='/image/user-default-avatar.png';">
                        </div>
                        <label for="inputAvatar" class="position-absolute bottom-0 end-0 mb-2 me-2">
                            <input type="file" id="inputAvatar" name="inputAvatar" class="d-none">
                            <span class="btn btn-sm btn-secondary rounded-circle"><i
                                        class="fa-solid fa-camera"></i></span>
                        </label>
                        <input type="hidden" name="avatar" id="editUserInformationAvatar">
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label for="editUserInformationEmail" class="form-label">Địa chỉ Email:</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1"><i
                                            class="fa-solid fa-envelope"></i></span>
                                <input id="editUserInformationEmail" type="text" class="form-control"
                                       placeholder="Email"
                                       aria-label="Email"
                                       aria-describedby="basic-addon1" disabled readonly>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="editUserInformationUsername" class="form-label">Username:</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-user"></i></span>
                                <input id="editUserInformationUsername" type="text" class="form-control"
                                       placeholder="Username"
                                       aria-label="Username"
                                       aria-describedby="basic-addon1" disabled readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label for="editUserInformationName" class="form-label">Họ và tên:</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-bars"></i></span>
                                <input id="editUserInformationName" type="text" class="form-control"
                                       placeholder="Họ và tên" aria-label="Name"
                                       aria-describedby="basic-addon1" name="name">
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="editUserInformationIdentityNumber" class="form-label">Số chứng minh:</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1"><i
                                            class="fa-solid fa-address-card"></i></span>
                                <input id="editUserInformationIdentityNumber" type="text" class="form-control"
                                       placeholder="Số chứng minh"
                                       aria-label="identityNumber" aria-describedby="basic-addon1"
                                       name="identityNumber">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label for="editUserInformationPhone" class="form-label">Số điện thoại:</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1"><i
                                            class="fa-solid fa-phone"></i></span>
                                <input id="editUserInformationPhone" type="text" class="form-control"
                                       placeholder="Số điện thoại"
                                       aria-label="phone" aria-describedby="basic-addon1"
                                       name="phone">
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="editUserInformationAddress" class="form-label">Địa chỉ:</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1"><i
                                            class="fa-solid fa-location-dot"></i></span>
                                <input id="editUserInformationAddress" type="text" class="form-control"
                                       placeholder="Địa chỉ"
                                       aria-label="address"
                                       aria-describedby="basic-addon1"
                                       name="address">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label for="editUserInformationGender" class="form-label">Giới tính:</label>
                            <div class="input-group mb-3">
                                <div class="form-check ms-3">
                                    <input class="form-check-input" id="editUserInformationGenderMale" type="radio"
                                           name="isFemale" value="0">
                                    <label class="form-check-label" for="editUserInformationGenderMale">
                                        Nam
                                    </label>
                                </div>
                                <div class="form-check ms-3">
                                    <input class="form-check-input" id="editUserInformationGenderFemale" type="radio"
                                           name="isFemale" value="1">
                                    <label class="form-check-label" for="editUserInformationGenderFemale">
                                        Nữ
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="editUserInformationDateOfBirth" class="form-label">Ngày sinh:</label>
                            <div class="input-group mb-3">
                                <input id="editUserInformationDateOfBirth" type="date" class="form-control"
                                       aria-label="dateOfBirth" aria-describedby="basic-addon1"
                                       name="dateOfBirth">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label for="editUserInformationRole" class="form-label">Vai trò</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1"><i
                                            class="fa-solid fa-dice-d6"></i></span>
                                <select class="form-select" name="role" id="editUserInformationRole">
                                    <option selected value="user">Nhân viên bán hàng</option>
                                    <option value="admin">Quản trị viên</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="editUserInformationIsLocked" class="form-label">Trạng thái</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1"><i
                                            class="fa-solid fa-dice-d6"></i></span>
                                <select class="form-select" name="isLocked" id="editUserInformationIsLocked">
                                    <option selected value="0">Đang hoạt động</option>
                                    <option value="1">Khoá</option>
                                </select>
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