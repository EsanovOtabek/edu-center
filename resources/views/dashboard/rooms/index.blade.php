@extends('layout.dashboard')

@section('title', "Xonalar ro'yxati")

@section('content-name', "Xonalar ro'yxati")

@section('pages')
    <li class="breadcrumb-item active">Xonalar</li>
@endsection


@section('content')
    <!-- Default box -->
    <div class="card card-solid">

        <div class="card-header text-right">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-add-room">
                + Xonalar qo'shish
            </button>
        </div>

        <div class="card-body pb-0">
            <div class="row">
                @foreach($rooms as $room)
                    <div class="col-12 col-sm-4 d-flex col-md-3 ">
                        <div class="card small-box bg-light d-flex flex-fill">
                            <div class="card-body pt-2 inner">
                                <h3>{{ $room->name }}</h3>
                                <p class="text-muted"><b>Xona sig'imi: </b>{{ $room->capacity }} </p>

                                <div class="icon">
                                    <i class="fas fa-building"></i>
                                </div>
                            </div>
                            <div class="card-footer ">
                                <div class="justify-content-end d-flex">
                                    <a href="#" class="btn btn-info ml-2">
                                        <i class="fas fa-calendar-alt"></i>
                                    </a>

                                    <!-- Tahrirlash tugmasi -->
                                    <button
                                        class="btn btn-warning ml-2"
                                        data-toggle="modal"
                                        data-target="#modal-edit"
                                        data-id="{{ $room->id }}"
                                        data-name="{{ $room->name }}"
                                        data-capacity="{{ $room->capacity }}">
                                    <i class="fa fa-edit"></i>
                                    </button>

                                    <!-- O'chirish tugmasi -->
                                    <button class="btn btn-danger ml-2"
                                            data-toggle="modal"
                                            data-target="#modal-delete"
                                            data-id="{{ $room->id }}"
                                            data-name="{{ $room->name }}">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>


    </div>
    <!-- /.card -->
    @include('dashboard.rooms.delete-modal')
    @include('dashboard.rooms.edit-modal')
    @include('dashboard.rooms.add-modal')

@endsection



@push('scripts')
    <script>
        // Modalni ochish va formani yangilash
        $('#modal-delete').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // modalni ochishga sabab bo'lgan tugma
            var roomId = button.data('id'); // Tugmadagi ID
            var roomName = button.data('name'); // Tugmadagi nomi

            // Modal ichidagi matnni yangilash
            var modal = $(this);
            modal.find('.modal-body #room-name').text(roomName);

            // Formani yangilash
            var form = modal.find('#delete-form');
            form.attr('action', '/admin/rooms/' + roomId); // Formaning action atributini yangilash
        });

        $('#modal-edit').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Modalni ochgan tugma
            var roomId = button.data('id'); // Tugmadagi room ID
            var roomName = button.data('name'); // Tugmadagi room nomi
            var roomCapacity = button.data('capacity'); // Tugmadagi room nomi

            // Modal ichidagi formani yangilash
            var modal = $(this);
            modal.find('#room-name').val(roomName); // Input maydoniga nomni joylashtirish
            modal.find('#room-capacity').val(roomCapacity); // Input maydoniga xona sig'imini joylashtirish
            modal.find('#edit-form').attr('action', '/admin/rooms/' + roomId); // Form action'ni yangilash
        });
    </script>
@endpush


