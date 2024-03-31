<?php
/** @var string $title */
/** @var string $header */
/** @var bool $isShowAside */
require_once __DIR__ . '/../utils/Logger.php';
use app\utils\Logger;

$isAuthenticated = isset($_SESSION['user']);
$currentUser = $_SESSION['user'] ?? null;
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= $this->e($title) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>

    <link rel="stylesheet" href="../style/base.css">
</head>
<body>
<?= $this->insert('partials/nav', [
        'isAuthenticated' => $isAuthenticated,
        'currentUser' => $currentUser,
    ]) ?>

<div class="container body">
    <div class="row">
        <?= $this->insert('partials/header', ['header' => $header]) ?>
    </div>
    <div class="row">
        <?php if ($isShowAside): ?>
            <aside class="col-12 col-lg-3">
                <?= $this->insert('partials/aside', [
                    'isAuthenticated' => $isAuthenticated,
                    'currentUser' => $currentUser,
                ]) ?>
            </aside>
            <main class="col-12 col-lg-9">
                <?= $this->section('main') ?>
            </main>
        <?php else: ?>
            <main class="col-12">
                <?= $this->section('main') ?>
            </main>
        <?php endif; ?>
    </div>
</div>
<?= $this->insert('partials/footer') ?>
<?= $this->insert('partials/toast') ?>
<?php
if (isset($_SESSION['logger'])) {
    try {
        Logger::debug_to_console($_SESSION['logger']);
        unset($_SESSION['logger']);
    } finally {
        unset($_SESSION['logger']);
    }
}
?>
</body>
</html>