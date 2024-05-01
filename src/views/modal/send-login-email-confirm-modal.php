<div class="modal fade" id="sendLoginEmailConfirmModal" tabindex="-1"
     aria-labelledby="sendLoginEmailConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sendLoginEmailConfirmModalLabel">Lưu ý</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc muốn gửi Email đăng nhập cho người dùng <b id="usernameSendLoginEmailConfirmModal"></b> không</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <form action="/admin/send-login-email" method="post">
                    <input type="hidden" id="inputEmailSendLoginEmailConfirmModal" name="email">
                    <button type="submit" class="btn btn-primary">Gửi</button>
                </form>
            </div>
        </div>
    </div>
</div>