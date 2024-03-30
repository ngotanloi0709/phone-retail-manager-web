<?php
/** @var bool $isAuthenticated */
/** @var User $currentUser */

?>
<?php $this->layout('base',
    [
        'title' => 'Đăng nhập',
        'header' => 'Đăng nhập',
        'isAuthenticated' => $isAuthenticated,
        'currentUser' => $currentUser
    ]) ?>

<?php $this->start('main') ?>
    <div class="col-12 col-lg-6 mx-auto">
        <form action="/login" method="post">
            <div class="form-group mb-3">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Nhập Email của bạn">
            </div>
            <div class="form-group mb-3">
                <label for="exampleInputPassword1">Mật khẩu</label>
                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Nhập mật khẩu của bạn">
            </div>
<!--            <div class="form-group form-check">-->
<!--                <input type="checkbox" class="form-check-input" id="remember-me">-->
<!--                <label class="form-check-label" for="remember-me">Nhớ phiên đăng nhập</label>-->
<!--            </div>-->
            <button type="submit" class="btn btn-primary">Đăng nhập</button>
        </form>
    </div>
<?php $this->end('main') ?>