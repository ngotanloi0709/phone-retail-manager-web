<?php $this->layout('base',
    [
        'title' => 'Đăng nhập',
        'header' => 'Đăng nhập',
        'isShowAside' => false
    ]) ?>

<?php $this->start('main') ?>
    <div class="col-12 col-lg-6 mx-auto">
        <form action="/login" method="post">
            <label for="username">Username:</label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"><i class="fa-regular fa-user"></i></span>
                <input type="text" class="form-control" id="username" name="username"
                       placeholder="Nhập Username của bạn" required>
            </div>
            <label for="password">Mật khẩu:</label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-key"></i></span>
                <input type="password" class="form-control" id="password" name="password"
                       placeholder="Nhập mật khẩu của bạn" required>
            </div>
            <button type="submit" class="btn btn-primary d-flex ms-auto">Đăng nhập</button>
        </form>
    </div>
<?php $this->end('main') ?>