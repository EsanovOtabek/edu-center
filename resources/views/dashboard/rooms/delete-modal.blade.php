<!-- O'chirish modalini umumiy holatda yaratish -->
<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="modal-delete-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-delete-label">Xonani o'chirishni tasdiqlang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Siz <strong id="room-name"></strong> Xonani o'chirmoqchimisiz?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Yopish</button>
                <!-- O'chirishni tasdiqlash formasi -->
                <form id="delete-form" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">O'chirish</button>
                </form>
            </div>
        </div>
    </div>
</div>
