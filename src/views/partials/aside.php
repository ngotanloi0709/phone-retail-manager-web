<?php
/** @var bool $isAuthenticated */
/** @var User $currentUser */

use app\models\User;

?>
<div class="list-group text-center">
    <?php if (!$isAuthenticated): ?>
        <a class="list-group-item list-group-item-action" href="/login"
           role="tab" aria-controls="list-home">Đăng nhập</a>
    <?php else: ?>
        <p>Welcome, <?= $currentUser->getEmail() ?></p>
    <?php endif; ?>
    <a class="list-group-item list-group-item-action" href="/home"
       role="tab" aria-controls="list-home">Trang chủ</a>
</div>