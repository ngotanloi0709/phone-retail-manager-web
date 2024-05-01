<?php use app\dto\SessionUserDTO;

$this->layout('base',
    [
        'title' => 'Đổi mật khẩu',
        'header' => 'Đổi mật khẩu',
        'isShowAside' => false
    ]) ?>
<?php $this->start('main') ?>
<div class="col-12 col-lg-6 mx-auto">
    <form method="post" action="/user/change-password-first-time">
        <label for="newFirstTimePassword" class="form-label">Mật khẩu mới:</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-key"></i></span>
            <input type="password" class="form-control" id="newFirstTimePassword" name="newPassword"
                   placeholder="Nhập mật khẩu mới">
        </div>
        <label for="repeatFirstTimePassword" class="form-label">Nhập lại mật khẩu:</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-rotate-right"></i></span>
            <input type="password" class="form-control" id="repeatFirstTimePassword" name="repeatPassword"
                   placeholder="Nhập lại mật khẩu ">
        </div>
        <button type="submit" class="btn btn-primary ms-auto d-flex">Đổi mật khẩu</button>
    </form>
</div>
<?php $this->end('main') ?>

