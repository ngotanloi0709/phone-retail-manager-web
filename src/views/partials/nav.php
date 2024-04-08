<?php
/** @var bool $isAuthenticated */
/** @var User $currentUser */
?>
<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container">
        <a class="navbar-brand" href="/home">Phone Retail Store</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/home">Trang chủ</a>
                </li>
                <?php if ($isAuthenticated && $currentUser->getRole() == UserRole::ADMIN): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin">Admin</a>
                    </li>
                <?php endif; ?>
            </ul>

            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <?php if (!$isAuthenticated): ?>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/login">Đăng nhập</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/register">Đăng ký</a>
                    </li>
                <?php else: ?>
                    <li class="d-flex align-items-center">
                        <p class="m-0 p-0">Welcome, <?= $currentUser->getEmail() ?></p>
                    </li>
                <?php endif; ?>
                <?php if ($isAuthenticated): ?>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/logout">Đăng xuất</a>
                    </li>
                <?php endif; ?>
            </ul>

            <!--            <form class="d-flex">-->
            <!--                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">-->
            <!--                <button class="btn btn-outline-success" type="submit">Search</button>-->
            <!--            </form>-->
        </div>
    </div>
</nav>