<div class="modal fade" id="deleteUserConfirmModal" tabindex="-1"
     aria-labelledby="deleteUserConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteUserConfirmModalLabel">Lưu ý</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc muốn xoá người dùng <b id="usernameDeleteUserConfirmModal"></b> không</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <form action="/admin/delete-user" method="post">
                    <input type="hidden" id="idDeleteUserConfirmModal" name="id">
                    <button type="submit" class="btn btn-danger">Xoá</button>
                </form>
            </div>
        </div>
    </div>
</div>