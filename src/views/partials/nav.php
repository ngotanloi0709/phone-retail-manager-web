<?php
/** @var bool $isAuthenticated */

/** @var User $currentUser */

use app\models\UserRole;

?>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/home">Phone Retail Store</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent"
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
                            <p class="m-0 p-0">Xin chào,<b> <?= $currentUser->getEmail() ?> </b></p>
                        </li>
                    <?php endif; ?>
                    <?php if ($isAuthenticated): ?>
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 profile-menu">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                   data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="profile-pic">
                                        <img src="/image/user-default-avatar.png" alt="Profile Picture">
                                    </div>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="/personal-information"><i class="fas fa-sliders-h fa-fw"></i> Thông tin tài khoản</a></li>
                                    <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#changePasswordModal" href="#"><i class="fas fa-sliders-h fa-fw"></i> Đổi mật khẩu</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="/logout"><i class="fas fa-sign-out-alt fa-fw"></i> Đăng xuất</a></li>
                                </ul>
                            </li>
                        </ul>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

<?= $this->insert('modal/change-password-modal') ?>