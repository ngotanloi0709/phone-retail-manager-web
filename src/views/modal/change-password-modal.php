<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">Đổi mật khẩu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/user/change-password">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="oldPassword" class="form-label">Mật khẩu cũ</label>
                        <input type="password" class="form-control" id="oldPassword" name="oldPassword">
                    </div>
                    <div class="mb-3">
                        <label for="newPassword" class="form-label">Mật khẩu mới</label>
                        <input type="password" class="form-control" id="newPassword" name="newPassword">
                    </div>
                    <div class="mb-3">
                        <label for="repeatPassword" class="form-label">Nhập lại mật khẩu</label>
                        <input type="password" class="form-control" id="repeatPassword" name="repeatPassword">
                    </div>
                    <input name="currentLocation" type="hidden" value="<?= $_SERVER['REQUEST_URI']; ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>