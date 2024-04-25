<?php $this->layout('base',
    [
        'title' => 'Đổi mật khẩu',
        'header' => 'Đổi mật khẩu',
        'isShowAside' => false
    ]) ?>
<?php $this->start('main') ?>
<div class="col-12 col-lg-6 mx-auto">
    <form method="post" action="/user/change-password">
        <div class="modal-body">
            <label for="oldPassword" class="form-label">Mật khẩu cũ:</label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-unlock"></i></span>
                <input type="password" class="form-control" id="oldPassword" name="oldPassword"
                       placeholder="Nhập mật khẩu cũ">
            </div>
            <label for="newPassword" class="form-label">Mật khẩu mới:</label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-key"></i></span>
                <input type="password" class="form-control" id="newPassword" name="newPassword"
                       placeholder="Nhập mật khẩu mới">
            </div>
            <label for="repeatPassword" class="form-label">Nhập lại mật khẩu:</label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-rotate-right"></i></span>
                <input type="password" class="form-control" id="repeatPassword" name="repeatPassword"
                       placeholder="Nhập lại mật khẩu ">
            </div>
            <input name="currentLocation" type="hidden" value="<?= $_SERVER['REQUEST_URI']; ?>">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            <button type="submit" class="btn btn-primary">Lưu</button>
        </div>
    </form>
</div>
<?php $this->end('main') ?>

