<?php
/** @var bool $isAuthenticated */

/** @var SessionUserDTO $sessionUser */

use app\dto\SessionUserDTO;
use app\models\UserRole;

?>
<div class="list-group text-center">
    <?php if (!$isAuthenticated): ?>
        <a class="list-group-item list-group-item-action mb-2 shadow-sm rounded" href="/login"
           role="tab" aria-controls="list-home">Đăng nhập</a>
    <?php else: ?>
        <p>Welcome, <b><?= $sessionUser->getEmail() ?></b></p>
    <?php endif; ?>
</div>
<div class="list-group text-center shadow-sm rounded">
    <a class="list-group-item list-group-item-action" href="/home"
       role="tab" aria-controls="list-home">Trang chủ</a>
    <?php if ($isAuthenticated && $sessionUser->getRole() == UserRole::ADMIN): ?>
        <a class="list-group-item list-group-item-action" href="/admin"
           role="tab" aria-controls="list-home">Quản trị hệ thống</a>
    <?php endif; ?>
    <?php if ($isAuthenticated): ?>
        <a class="list-group-item list-group-item-action" href="/transaction"
           role="tab" aria-controls="list-home">Bán hàng</a>
        <a class="list-group-item list-group-item-action text-danger fw-bold" href="/logout"
           role="tab" aria-controls="list-home">Đăng xuất</a>
    <?php endif; ?>
</div>