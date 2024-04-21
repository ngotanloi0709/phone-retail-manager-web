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
                    <b class="mb-3">Bạn chỉ có thể chỉnh sửa các thông tin bên dưới, vui lòng quan hệ quản trị viên để chỉnh sửa các
                        thông tin khác.</b>
                    <label for="identityNumber" class="form-label">Số chứng minh:</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-address-card"></i></span>
                        <input id="identityNumber" type="text" class="form-control" placeholder="Số chứng minh"
                               aria-label="identityNumber" aria-describedby="basic-addon1"
                               value="<?php
                               if (isset($userInformation) && $userInformation->getIdentityNumber() != null) {
                                   echo $userInformation->getIdentityNumber();
                               } else {
                                   echo '';
                               }
                               ?>">
                    </div>
                    <label for="address" class="form-label">Địa chỉ:</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-location-dot"></i></span>
                        <input id="address" type="text" class="form-control" placeholder="Địa chỉ" aria-label="address"
                               aria-describedby="basic-addon1"
                               name="address"
                               value="<?php
                               if (isset($userInformation) && $userInformation->getAddress() != null) {
                                   echo $userInformation->getAddress();
                               } else {
                                   echo '';
                               }
                               ?>">
                    </div>
                    <label for="gender" class="form-label">Giới tính:</label>
                    <div class="input-group mb-3">
                        <div class="form-check ms-3">
                            <input class="form-check-input" id="flexRadioDefault1" type="radio" name="gender" value="M" <?= !$userInformation->isFemale() ? 'checked' : '' ?>>
                            <label class="form-check-label" for="flexRadioDefault1">
                                Nam
                            </label>
                        </div>
                        <div class="form-check ms-3">
                            <input class="form-check-input" id="flexRadioDefault2" type="radio" name="gender" value="F" <?= $userInformation->isFemale() ? 'checked' : '' ?>>
                            <label class="form-check-label" for="flexRadioDefault2">
                                Nữ
                            </label>
                        </div>
                    </div>
                    <label for="dateOfBirth" class="form-label">Ngày sinh:</label>
                    <div class="input-group mb-3">
                        <input id="dateOfBirth" type="date" class="form-control"
                               aria-label="dateOfBirth" aria-describedby="basic-addon1"
                               name="dateOfBirth"
                               value="<?php
                                 if (isset($userInformation) && $userInformation->getDateOfBirth() != null) {
                                      echo $userInformation->getDateOfBirth()->format('Y-m-d');
                                 } else {
                                      echo '';
                                 }
                               ?>">
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