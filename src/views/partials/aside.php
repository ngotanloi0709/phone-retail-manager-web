<?php
/** @var bool $isAuthenticated */

/** @var User $currentUser */

use app\models\User;
use app\models\UserRole;

?>
<div class="list-group text-center">
    <?php if (!$isAuthenticated): ?>
        <a class="list-group-item list-group-item-action" href="/login"
           role="tab" aria-controls="list-home">Đăng nhập</a>
    <?php else: ?>
        <p>Welcome, <b><?= $currentUser->getEmail() ?></b></p>
    <?php endif; ?>
    <?php if (!$isAuthenticated): ?>
        <a class="list-group-item list-group-item-action" href="/register"
           role="tab" aria-controls="list-home">Đăng ký</a>
    <?php endif; ?>

    <a class="list-group-item list-group-item-action" href="/home"
       role="tab" aria-controls="list-home">Trang chủ</a>
    <?php if ($isAuthenticated && $currentUser->getRole() == UserRole::ADMIN): ?>
        <a class="list-group-item list-group-item-action" href="/admin"
           role="tab" aria-controls="list-home">Admin</a>
    <?php endif; ?>
    <?php if ($isAuthenticated): ?>
        <a class="list-group-item list-group-item-action" href="/logout"
           role="tab" aria-controls="list-home">Đăng xuất</a>
    <?php endif; ?>
</div>