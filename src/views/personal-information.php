<?php use app\models\User;
use app\utils\DataHelper;

/** @var User $userInformation */

$this->layout('base',
    [
        'title' => 'Thông tin cá nhân',
        'header' => 'Thông tin cá nhân',
        'isShowAside' => false
    ]) ?>
<?php $this->start('main') ?>
<?= $this->insert('modal/change-personal-information-modal', ['userInformation' => $userInformation]) ?>

    <link rel="stylesheet" href="../style/personal-information.css"">

    <div class="col-8 col-lg-6 mx-auto">
        <div class="col-6 col-lg-4 mx-auto mb-5 position-relative">
            <div class="ratio ratio-1x1 card-img-top">
                <?php
                if (isset($userInformation) && $userInformation->getAvatar() != null && $userInformation->getAvatar() != '') {
                    echo '<img id="displayAvatar" src="' . $userInformation->getAvatar() . '" class="rounded-circle overflow-hidden"
                     alt="user-avatar">';
                } else {
                    echo '<img id="displayAvatar" src="/image/user-default-avatar.png" class="rounded-circle overflow-hidden"
                     alt="default-avatar">';
                }
                ?>
            </div>
            <form id="changeAvatarForm" action="/user/change-avatar" method="post" enctype="multipart/form-data">
                <label for="inputAvatar" class="position-absolute bottom-0 end-0 mb-2 me-2">
                    <input type="file" id="inputAvatar" name="inputAvatar" class="d-none">
                    <span class="btn btn-sm btn-secondary rounded-circle"><i class="fa-solid fa-camera"></i></span>
                </label>
            </form>
        </div>
        <label for="readonlyEmail" class="form-label">Địa chỉ Email:</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-envelope"></i></span>
            <input id="readonlyEmail" type="text" class="form-control" placeholder="Email" aria-label="Email"
                   aria-describedby="basic-addon1" disabled readonly
                   value="<?= DataHelper::getDisplayStringData($userInformation->getEmail()); ?>">
        </div>
        <label for="readonlyUsername" class="form-label">Username:</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-user"></i></span>
            <input id="readonlyUsername" type="text" class="form-control" placeholder="Username" aria-label="Username"
                   aria-describedby="basic-addon1" disabled readonly
                   value="<?= DataHelper::getDisplayStringData($userInformation->getUsername()); ?>">
        </div>
        <label for="readonlyName" class="form-label">Username:</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-bars"></i></span>
            <input id="readonlyName" type="text" class="form-control" placeholder="Họ và tên" aria-label="Name"
                   aria-describedby="basic-addon1" disabled readonly
                   value="<?= DataHelper::getDisplayStringData($userInformation->getName()); ?>">
        </div>
        <label for="readonlyIdentityNumber" class="form-label">Số chứng minh:</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-address-card"></i></span>
            <input id="readonlyIdentityNumber" type="text" class="form-control" placeholder="Số chứng minh"
                   aria-label="identityNumber" aria-describedby="basic-addon1" disabled readonly
                   value="<?= DataHelper::getDisplayStringData($userInformation->getIdentityNumber()); ?>">
        </div>
        <label for="readonlyPhone" class="form-label">Số điện thoại:</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-phone"></i></span>
            <input id="readonlyPhone" type="text" class="form-control" placeholder="Số điện thoại"
                   aria-label="phone" aria-describedby="basic-addon1" disabled readonly
                   value="<?= DataHelper::getDisplayStringData($userInformation->getPhone()); ?>">
        </div>
        <label for="readonlyAddress" class="form-label">Địa chỉ:</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-location-dot"></i></span>
            <input id="readonlyAddress" type="text" class="form-control" placeholder="Địa chỉ" aria-label="address"
                   aria-describedby="basic-addon1" disabled readonly
                   value="<?= DataHelper::getDisplayStringData($userInformation->getAddress()); ?>">
        </div>
        <label for="readonlyGender" class="form-label">Giới tính:</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-venus-mars"></i></i></span>
            <input id="readonlyGender" type="text" class="form-control" placeholder="Giới tính" aria-label="gender"
                   aria-describedby="basic-addon1" disabled readonly
                   value="<?= $userInformation->isFemale() ? 'Nữ' : 'Nam'; ?>">
        </div>
        <label for="readonlyDateOfBirth" class="form-label">Ngày sinh:</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1"><i class="fa-regular fa-calendar-days"></i></i></span>
            <input id="readonlyDateOfBirth" type="text" class="form-control" placeholder="Ngày sinh"
                   aria-label="dateOfBirth"
                   aria-describedby="basic-addon1" disabled readonly
                   value="<?= DataHelper::getDisplayStringData($userInformation->getDateOfBirthString()); ?>">
        </div>
        <button class="btn btn-success d-flex ms-auto" data-bs-toggle="modal"
                data-bs-target="#changePersonalInformationModal">Chỉnh sửa thông tin
        </button>
    </div>

    <script src="../script/personal-information.js"></script>
<?php $this->end('main') ?>