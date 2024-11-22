<!-- Tahrirlash uchun umumiy modal -->
<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="modal-edit-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-edit-label">Xonani Tahrirlash</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="edit-form" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <!-- Fan nomi -->
                    <div class="form-group">
                        <label for="room-name">Xona nomi</label>
                        <input type="text" class="form-control" id="room-name" name="name" required>
                    </div>

                    <!-- Xona sig'imi -->
                    <div class="form-group">
                        <label for="room-capacity">Xona sig'imi</label>
                        <input type="number" class="form-control" id="room-capacity" name="capacity" placeholder="Xona sig'imi" value="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Bekor qilish</button>
                    <button type="submit" class="btn btn-primary">Saqlash</button>
                </div>
            </form>
        </div>
    </div>
</div>
