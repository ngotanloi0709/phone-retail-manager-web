<?php use app\models\User;
use app\utils\DataHelper;

/** @var array $users */

$this->layout('base',
    [
        'title' => 'Quản trị người dùng',
        'header' => 'Quản trị người dùng',
        'isShowAside' => true
    ]) ?>

<?php $this->start('main') ?>
<link rel="stylesheet" href="../style/personal-information.css">

<?= $this->insert('modal/create-new-user-modal') ?>
<?= $this->insert('modal/user-detail-modal') ?>
<?= $this->insert('modal/send-login-email-confirm-modal') ?>
<?= $this->insert('modal/delete-user-confirm-modal') ?>
<?= $this->insert('modal/edit-user-information-modal') ?>
<?= $this->insert('modal/change-user-password-modal') ?>
<div class="d-flex">
    <button class="btn btn-success mb-3 ms-auto" data-bs-toggle="modal"
            data-bs-target="#createNewUserModal">Thêm người dùng mới vào hệ thống
    </button>
</div>

<div class="card">
    <div class="card-header">
        <b>Bảng thông tin người dùng hệ thống</b>
    </div>
    <div class="card-body">
        <table class="table table-hover table-striped">
            <thead>
            <tr>
                <th scope="col">Ảnh đại diện</th>
                <th scope="col">Họ và tên</th>
                <th scope="col">Email</th>
                <th scope="col">Số điện thoại</th>
                <th scope="col">Trạng thái</th>
                <th scope="col">Thao tác</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if (count($users) == 0) {
                echo '<tr><td colspan="4">Không có người dùng nào trong hệ thống</td></tr>';
            } else {
                /** @var User $user */
                foreach ($users as $user) {
                    echo '<tr data-user-email="' . $user->getEmail()
                        . '" data-user-username="' . $user->getUsername()
                        . '" data-user-name="' . DataHelper::getDisplayStringData($user->getName())
                        . '" data-user-address="' . DataHelper::getDisplayStringData($user->getAddress())
                        . '" data-user-identity-number="' . DataHelper::getDisplayStringData($user->getIdentityNumber())
                        . '" data-user-is-female="' . ($user->isFemale() ? 'Nữ' : 'Nam')
                        . '" data-user-is-female-bool="' . ($user->isFemale())
                        . '" data-user-date-of-birth="' . $user->getDateOfBirth()->format('d-m-Y')
                        . '" data-user-avatar="' . DataHelper::getDisplayAvatarData($user->getAvatar())
                        . '" data-user-is-locked="' . ($user->isLocked() ? 'Đã khóa' : 'Đang hoạt động')
                        . '" data-user-is-locked-bool="' . ($user->isLocked())
                        . '" data-user-phone="' . DataHelper::getDisplayStringData($user->getPhone())
                        . '" data-user-role="' . $user->getRoleString()
                        . '" data-user-id="' . $user->getId()
                        . '">';
                    echo '<td><img src="' . DataHelper::getDisplayAvatarData($user->getAvatar()) . '" alt="user-avatar" class="avatar profile-pic" style="object-fit: cover !important;"></td>';
                    echo '<td>' . DataHelper::getDisplayStringData($user->getName()) . '</td>';
                    echo '<td>' . DataHelper::getDisplayStringData($user->getEmail()) . '</td>';
                    echo '<td>' . DataHelper::getDisplayStringData($user->getPhone()) . '</td>';
                    echo '<td>' . ($user->isLocked() ? 'Đã khóa' : 'Đang hoạt động') . '</td>';
                    echo '<td>';
                    echo '<a class="buttonShowDetailInformation btn btn-primary btn-sm me-1"><span><i class="fa-solid fa-circle-info"></i></span></a>';
                    echo '<a class="buttonEditUserInformation btn btn-warning btn-sm me-1"><span><i class="fa-regular fa-pen-to-square"></i></span></a>';
                    echo '<a class="buttonDeleteUserInformation btn btn-danger btn-sm me-1"><span><i class="fa-solid fa-trash"></i></span></a>';
                    echo '<a class="buttonShowSendLoginEmailConfirmation btn btn-info btn-sm me-1"><span><i class="fa-solid fa-paper-plane"></i></span></a>';
                    echo '<a class="buttonChangeUserPassword btn btn-secondary btn-sm me-1"><span><i class="fa-solid fa-key"></i></span></a>';
                    echo '<a class="buttonShowSaleInformation btn btn-light btn-sm me-1" href="/admin/sale-information?id=' . $user->getId() . '"><span><i class="fa-solid fa-list"></i></span></a>';
                    echo '</td>';
                    echo '</tr>';
                }
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<script src="../script/user-management.js"></script>
<?php $this->end('main') ?>

