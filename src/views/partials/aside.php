<?php
    $isAuthenticated = $_SESSION['isAuthenticated'] ?? false;
    $currentUser = $_SESSION['currentUser'] ?? null;
?>
<div class="list-group text-center">
    <?php if (!$isAuthenticated): ?>
        <a class="list-group-item list-group-item-action" href="/login"
           role="tab" aria-controls="list-home">Đăng nhập</a>
    <?php else: ?>
        <p>Welcome, <?= $currentUser->getEmail() ?></p>
    <?php endif; ?>
    <?php if (!$isAuthenticated): ?>
        <a class="list-group-item list-group-item-action" href="/register"
           role="tab" aria-controls="list-home">Đăng ký</a>
    <?php else: ?>
        <p>Welcome, <?= $currentUser->getEmail() ?></p>
    <?php endif; ?>
    <a class="list-group-item list-group-item-action" href="/home"
       role="tab" aria-controls="list-home">Trang chủ</a>
</div>