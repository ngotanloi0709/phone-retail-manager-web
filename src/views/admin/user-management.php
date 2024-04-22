<?php $this->layout('base',
    [
        'title' => 'Quản trị nhân viên',
        'header' => 'Quản trị nhân viên',
        'isShowAside' => true
    ]) ?>

<?php $this->start('main') ?>
<?= $this->insert('modal/create-new-user-modal') ?>

<button class="btn btn-lg btn-success" data-bs-toggle="modal"
        data-bs-target="#createNewUserModal">Thêm người dùng mới vào hệ thống</button>
<?php $this->end('main') ?>

