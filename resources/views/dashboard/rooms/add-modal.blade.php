<!-- Qo'shish uchun modal -->
<div class="modal fade" id="modal-add-room" tabindex="-1" role="dialog" aria-labelledby="modal-add-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-add-label">Yangi Xona qo'shish</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="add-room-form" action="{{ route('admin.rooms.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <!-- Xona nomi -->
                    <div class="form-group">
                        <label for="room-name">Xona nomi</label>
                        <input type="text" class="form-control" id="room-name" name="name" placeholder="Xona nomini kiriting" required>
                    </div>
                    <!-- Xona sig'imi -->
                    <div class="form-group">
                        <label for="room-capacity">Xona sig'imi</label>
                        <input type="number" class="form-control" id="room-capacity" name="capacity" placeholder="Xona sig'imi" value="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Bekor qilish</button>
                    <button type="submit" class="btn btn-primary">Qo'shish</button>
                </div>
            </form>
        </div>
    </div>
</div>
