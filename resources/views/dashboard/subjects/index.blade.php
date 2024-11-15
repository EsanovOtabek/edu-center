@extends('layout.dashboard')

@section('title', "Fanlar ro'yxati")

@section('content-name', "Fanlar ro'yxati")

@section('pages')
    <li class="breadcrumb-item active">Fanlar</li>
@endsection




@section('content')
    <!-- Default box -->
    <div class="card card-solid">

        <div class="card-header text-right">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-add-subject">
                + Fan qo'shish
            </button>
        </div>

        <div class="card-body pb-3 table-responsive">
            <table class="table table-bordered table-striped text-nowrap table-sm" id="subjects-table" >
                <thead>
                <tr>
                    <th style="width: 30px">T/r</th>
                    <th>Nomi</th>
                    <th>Tahrirlash | O'chirish</th>
                </tr>
                </thead>
                <tbody>
                @foreach($subjects as $subject)
                    <tr>
                        <td>{{$loop->index+1}}</td>
                        <td class="text-bold ">{{ $subject->name }}</td>
                        <td style="width: 150px">
                            <button onclick="editSubject({{ $subject->id }})" class="btn btn-warning" data-toggle="modal" data-target="#modal-editSubject-{{ $subject->id }}">
                                <i class="fa fa-edit"></i> Tahrirlash
                            </button>
                            |
                            <!-- O'chirish tugmasi -->
                            <button class="btn btn-danger" data-toggle="modal" data-target="#modal-delete" data-id="{{ $subject->id }}" data-name="{{ $subject->name }}">
                                <i class="fa fa-trash"></i> O'chirish
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
    @if(auth()->user()->role == 'admin')
        @include('dashboard.subjects.add-modal')
    @endif
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endpush


@push('scripts')
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <script>
        $(function () {
            $("#subjects-table").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
                "buttons": ["copy","excel", "pdf"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });


    </script>

    <script>
        // Modalni ochish va formani yangilash
        $('#modal-delete').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // modalni ochishga sabab bo'lgan tugma
            var subjectId = button.data('id'); // Tugmadagi ID
            var subjectName = button.data('name'); // Tugmadagi nomi

            // Modal ichidagi matnni yangilash
            var modal = $(this);
            modal.find('.modal-body #subject-name').text(subjectName);

            // Formani yangilash
            var form = modal.find('#delete-form');
            form.attr('action', '/admin/subjects/' + subjectId); // Formaning action atributini yangilash
        });
    </script>

@endpush

@include('dashboard.subjects.delete-modal')
