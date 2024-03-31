<?php if (isset($_SESSION['alerts'])): ?>
    <?php foreach ($_SESSION['alerts'] as $alert): ?>
        <div class='toast' style='position: fixed; top: 120px; right: 20px; opacity: 0; transition: opacity 0.5s;'>
            <div class="toast-header">
                <strong class="mr-auto text-danger">Thông báo</strong>
            </div>
            <div class='toast-body'>
                <?= $alert ?>
            </div>
        </div>
    <?php endforeach; ?>
    <script>
        window.onload = function () {
            var toasts = document.getElementsByClassName('toast');
            Array.from(toasts).forEach(function(toast, index) {
                setTimeout(function () {
                    toast.style.opacity = '1';
                    setTimeout(function () {
                        toast.style.opacity = '0';
                    }, 2000);
                }, 2000 * index);
            });
        }
    </script>
    <?php unset($_SESSION['alerts']); endif; ?>