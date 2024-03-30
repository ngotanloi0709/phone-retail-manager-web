<?php
/** @var bool $isAuthenticated */
/** @var User $currentUser */

?>
<?php $this->layout('base',
    [
        'title' => 'Admin',
        'header' => 'Đây là trang admin',
        'isAuthenticated' => $isAuthenticated,
        'currentUser' => $currentUser
    ]) ?>

<?php $this->start('main') ?>
<h1>Đây là trang admin</h1>
<?php $this->end('main') ?>

