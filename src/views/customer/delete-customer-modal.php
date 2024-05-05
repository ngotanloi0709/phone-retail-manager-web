<div class="modal fade" id="deleteCustomerConfirmModal" tabindex="-1"
     aria-labelledby="deleteCustomerConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteCustomerConfirmModalLabel">Lưu ý</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc muốn xoá khách hàng này không</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <form action="/customer/delete-customer" method="post">
                    <input type="hidden" id="idDeleteCustomerConfirmModal" name="id">
                    <button type="submit" class="btn btn-danger">Xoá</button>
                </form>
            </div>
        </div>
    </div>
</div>