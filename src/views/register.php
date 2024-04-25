<?php $this->layout('base',
    [
        'title' => 'Đăng ký',
        'header' => 'Đăng ký',
        'isShowAside' => false
    ]) ?>

<?php $this->start('main') ?>
    <div class="col-12 col-lg-6 mx-auto">
        <form action="/register" method="post">
            <label for="email">Email</label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"><i class="fa-regular fa-envelope"></i></span>
                <input type="email" class="form-control" id="email" name="email" placeholder="Nhập Email của bạn"
                       required>
            </div>
            <label for="password">Mật khẩu</label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-key"></i></i></span>
                <input type="password" class="form-control" id="password" name="password"
                       placeholder="Nhập mật khẩu của bạn" required>
            </div>
            <label for="repeatPassword">Nhập lại mật khẩu</label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-rotate-right"></i></span>
                <input type="password" class="form-control" id="repeatPassword" name="repeatPassword"
                       placeholder="Nhập lại mật khẩu" required>
            </div>
            <label for="role">Vai trò</label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-dice-d6"></i></span>
                <select class="form-select" name="role" id="role">
                    <option selected value="user">Nhân viên bán hàng</option>
                    <option value="admin">Quản trị viên</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary d-flex ms-auto">Đăng ký</button>
        </form>
    </div>
<?php $this->end('main') ?>