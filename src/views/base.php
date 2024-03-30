<?php
/** @var string $title */
/** @var string $header */
/** @var bool $isAuthenticated */
/** @var User $currentUser */

use app\models\User;

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

    <link rel="stylesheet" href="style/base.css">
</head>
<body>
<?= $this->insert('partials/nav') ?>

<div class="container body">
    <div class="row">
        <?= $this->insert('partials/header', ['header' => $header]) ?>
    </div>
    <div class="row">
        <aside class="col-12 col-lg-3">
            <?= $this->insert('partials/aside', [
                'isAuthenticated' => $isAuthenticated,
                'currentUser' => $currentUser
            ]) ?>
        </aside>
        <main class="col-12 col-lg-9">
            <?= $this->section('main') ?>
        </main>
    </div>
</div>
<?= $this->insert('partials/footer') ?>
</body>
</html>