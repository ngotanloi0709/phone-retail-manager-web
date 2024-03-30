<?php
/** @var bool $isAuthenticated */
/** @var User $currentUser */

?>
<?php $this->layout('base',
    [
        'title' => 'Đăng ký',
        'header' => 'Đăng ký',
    ]) ?>

<?php $this->start('main') ?>
    <div class="col-12 col-lg-6 mx-auto">
        <form action="/register" method="post">
            <div class="form-group mb-3">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Nhập Email của bạn" required>
            </div>
            <div class="form-group mb-3">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Nhập tên của bạn" required>
            </div>
            <div class="form-group mb-3">
                <label for="password">Mật khẩu</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu của bạn" required>
            </div>

            <button type="submit" class="btn btn-primary">Đăng ký</button>
        </form>
    </div>
<?php $this->end('main') ?>