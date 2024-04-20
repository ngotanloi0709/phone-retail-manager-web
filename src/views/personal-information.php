<?php $this->layout('base',
    [
        'title' => 'Thông tin cá nhân',
        'header' => 'Thông tin cá nhân',
        'isShowAside' => false
    ]) ?>

<?php $this->start('main') ?>
<?= $this->insert('modal/change-personal-information-modal') ?>

<link rel="stylesheet" href="../style/personal-information.css">

<div class="col-12 col-lg-6 mx-auto">
    <label for="readonlyEmail" class="form-label">Địa chỉ Email:</label>
    <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1"><i class="fa-regular fa-envelope"></i></span>
        <input id="readonlyEmail" type="text" class="form-control" placeholder="Email" aria-label="Email"
               aria-describedby="basic-addon1"
               disabled readonly>
    </div>
    <label for="readonlyUsername" class="form-label">Username:</label>
    <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-user"></i></span>
        <input id="readonlyUsername" type="text" class="form-control" placeholder="Username" aria-label="Username"
               aria-describedby="basic-addon1" disabled readonly>
    </div>
    <label for="readonlyIdentityNumber" class="form-label">Số chứng minh:</label>
    <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-address-card"></i></span>
        <input id="readonlyIdentityNumber" type="text" class="form-control" placeholder="Số chứng minh"
               aria-label="identityNumber"
               aria-describedby="basic-addon1" disabled readonly>
    </div>
    <label for="readonlyAddress" class="form-label">Địa chỉ:</label>
    <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-location-dot"></i></span>
        <input id="readonlyAddress" type="text" class="form-control" placeholder="Địa chỉ" aria-label="address"
               aria-describedby="basic-addon1" disabled readonly>
    </div>
    <label for="readonlyGender" class="form-label">Giới tính:</label>
    <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-venus-mars"></i></i></span>
        <input id="readonlyGender" type="text" class="form-control" placeholder="Giới tính" aria-label="gender"
               aria-describedby="basic-addon1" disabled readonly>
    </div>
    <label for="readonlyDateOfBirth" class="form-label">Ngày sinh:</label>
    <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1"><i class="fa-regular fa-calendar-days"></i></i></span>
        <input id="readonlyDateOfBirth" type="text" class="form-control" placeholder="Ngày sinh" aria-label="dateOfBirth"
               aria-describedby="basic-addon1" disabled readonly>
    </div>
    <button class="btn btn-success d-flex ms-auto" data-bs-toggle="modal" data-bs-target="#changePersonalInformationModal">Chỉnh sửa thông tin</button>
</div>
<?php $this->end('main') ?>