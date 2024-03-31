<?php
/** @var string $name */
?>

<?php $this->layout('base',
    [
        'title' => 'Trang chủ',
        'header' => 'Đây là trang chủ, ...',
    ]) ?>

<?php $this->start('main') ?>
<h1>Hello, <?= $this->e($name) ?></h1>
<?php $this->end('main') ?>

