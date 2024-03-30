<?php
/** @var string $name */
/** @var bool $isAuthenticated */
/** @var User $currentUser */

use app\models\User;

?>
<?php $this->layout('base',
    [
        'title' => 'Trang chủ',
        'header' => 'Đây là trang chủ, ...',
        'isAuthenticated' => $isAuthenticated,
        'currentUser' => $currentUser
    ]) ?>

<?php $this->start('main') ?>
<h1>Hello, <?= $this->e($name) ?></h1>
<?php $this->end('main') ?>

