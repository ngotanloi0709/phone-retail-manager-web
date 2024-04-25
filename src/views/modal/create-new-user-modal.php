<div class="modal fade" id="createNewUserModal" tabindex="-1"
     aria-labelledby="createNewUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createNewUserModalLabel">Thêm người dùng mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/admin/create-new-user">
                <div class="modal-body">
                    <label for="email">Email</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="fa-regular fa-envelope"></i></span>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Nhập Email người dùng"
                               required>
                    </div>
                    <label for="name">Họ và tên:</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="fa-regular fa-envelope"></i></span>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nhập tên người dùng"
                               required>
                    </div>
                    <label for="role">Vai trò</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-dice-d6"></i></span>
                        <select class="form-select" name="role" id="role">
                            <option selected value="user">Nhân viên bán hàng</option>
                            <option value="admin">Quản trị viên</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Tạo mới</button>
                </div>
            </form>
        </div>
    </div>
</div>