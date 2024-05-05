<?php
/** @var bool $isAuthenticated */

/** @var SessionUserDTO $sessionUser */

use app\dto\SessionUserDTO;
use app\models\UserRole;
use app\utils\DataHelper;

?>
<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container">
        <a class="navbar-brand" href="/home"><i class="fa-solid fa-phone"></i></i> Phone Retail Store</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/home"><i class="fa-solid fa-house"></i>
                        Trang chủ</a>
                </li>
                <?php if ($isAuthenticated && $sessionUser->getRole() == UserRole::ADMIN): ?>
                    <li class="nav-item">
                        <a class="nav-link active" href="/admin"><i class="fa-solid fa-user-tie"></i> Admin</a>
                    </li>
                <?php endif; ?>
                    
                    <?php if ($isAuthenticated): ?>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/product"><i
                                        class="fa-solid fa-mobile"></i> Sản Phẩm</a>
                        </li>
                    <?php endif; ?>
                    <?php if ($isAuthenticated): ?>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/transaction"><i
                                        class="fa-solid fa-box"></i> Đơn Hàng</a>
                        </li>
                    <?php endif; ?>
                    <?php if ($isAuthenticated): ?>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/customer"><i class="fa-solid fa-book"></i> Quản Lí Khách Hàng</a>
                        </li>
                    <?php endif; ?>
                    <?php if ($isAuthenticated): ?>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/statistics"><i class="fas fa-pen-alt"></i> Thống kê doanh thu</a>
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
                        <p class="m-0 p-0">Xin chào,<b> <?= $sessionUser->getEmail() ?> </b></p>
                    </li>
                <?php endif; ?>
                <?php if ($isAuthenticated): ?>
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 profile-menu">
                        <li class="nav-item dropdown d-none d-lg-block">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                               data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="profile-pic">
                                    <?php
                                    if (isset($sessionUser)) {
                                        echo '<img src="' . DataHelper::getDisplayAvatarData($sessionUser->getAvatar()) . '" alt="user-avatar">';
                                    }
                                    ?>
                                </div>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="/user/personal-information"><i
                                                class="fa-solid fa-sliders"></i> Thông tin tài khoản</a></li>
                                <?php
                                if (isset($_SESSION['isNeededChangePassword']) && $_SESSION['isNeededChangePassword']) {
                                    echo '<li><a class="dropdown-item" href="/user/change-password-first-time"><i class="fa-solid fa-key"></i></i> Đổi mật khẩu</a></li>';
                                } else {
                                    echo '<li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#changePasswordModal" href="#"><i class="fa-solid fa-key"></i></i> Đổi mật khẩu</a></li>';
                                }
                                ?>
                                <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="/logout"><i
                                        class="fa-solid fa-right-from-bracket"></i> Đăng xuất</a></li>
                    </ul>
                    <div class="d-lg-none d-flex justify-content-between">
                        <ul>
                            <li class="nav-item">
                                <a class="nav-link" href="/user/personal-information"><i
                                            class="fa-solid fa-sliders"></i>
                                    Thông tin tài khoản</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="modal" data-bs-target="#changePasswordModal"
                                   href="#"><i class="fa-solid fa-key"></i></i> Đổi mật khẩu</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/logout"><i class="fa-solid fa-right-from-bracket"></i>Đăng
                                    xuất</a>
                            </li>
                        </ul>
                    </div>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<?php
if ($isAuthenticated) {
    echo $this->insert('modal/change-password-modal');
}
?>
