<?php $this->layout('base',
    [
        'title' => 'Đăng ký',
        'header' => 'Đăng ký',
        'isShowAside' => false
    ]) ?>

<?php $this->start('main') ?>
    <div class="col-12 col-lg-6 mx-auto">
        <form action="/register" method="post">
            <div class="form-group mb-3">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Nhập Email của bạn" required>
            </div>
            <div class="form-group mb-3">
                <label for="password">Mật khẩu</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu của bạn" required>
            </div>
            <div class="form-group mb-3">
                <label for="repeatPassword">Nhập lại mật khẩu</label>
                <input type="password" class="form-control" id="repeatPassword" name="repeatPassword" placeholder="Nhập lại mật khẩu" required>
            </div>
            <div class="form-group mb-3">
                <label for="role">Vai trò</label>
                <select class="form-select" name="role" id="role">
                    <option selected value="user">Nhân viên bán hàng</option>
                    <option value="admin">Quản trị viên</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Đăng ký</button>
        </form>
    </div>
<?php $this->end('main') ?>