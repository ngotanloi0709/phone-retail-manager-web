<div class="modal fade" id="changePersonalInformationModal" tabindex="-1"
     aria-labelledby="changePersonalInformationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePersonalInformationModalLabel">Chỉnh sửa thông tin cá nhân</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/user/change-personal-information">
                <div class="modal-body">
                    <label for="identityNumber" class="form-label">Số chứng minh:</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-address-card"></i></span>
                        <input id="identityNumber" type="text" class="form-control" placeholder="Số chứng minh"
                               aria-label="identityNumber" aria-describedby="basic-addon1">
                    </div>
                    <label for="address" class="form-label">Địa chỉ:</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-location-dot"></i></span>
                        <input id="address" type="text" class="form-control" placeholder="Địa chỉ" aria-label="address"
                               aria-describedby="basic-addon1">
                    </div>
                    <label for="gender" class="form-label">Giới tính:</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i
                                    class="fa-solid fa-venus-mars"></i></i></span>
                        <input id="gender" type="text" class="form-control" placeholder="Giới tính" aria-label="gender"
                               aria-describedby="basic-addon1">
                    </div>
                    <label for="dateOfBirth" class="form-label">Ngày sinh:</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="fa-regular fa-calendar-days"></i></i></span>
                        <input id="dateOfBirth" type="text" class="form-control" placeholder="Ngày sinh"
                               aria-label="dateOfBirth" aria-describedby="basic-addon1">
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