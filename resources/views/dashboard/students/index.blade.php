@extends('layout.dashboard')

@section('content-name', 'Talabalar ro\'yxati')
@section('title', 'Talabalar ro\'yxati')

@section('pages')
    <li class="breadcrumb-item ">Talabalar</li>
    <li class="breadcrumb-item active">Talabalar ro'yxati</li>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-light">
                <div class="card-header">
                    <h3 class="card-title">Talabalar ro‘yxati</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.groups.create') }}" class="btn btn-primary float-right text-white">
                            + Talaba qo'shish
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <form class="form-group">
                        <label for="group-filter">Guruh bo‘yicha filtr</label>
                        <select id="group-filter" class="form-control" onchange="this.form.submit()" name="group_id">
                            <option value="">-- Guruhni tanlang --</option>
                            @foreach ($groups as $group)
                                <option value="{{ $group->id }}" @selected($group_id > 0 && $group_id == $group->id)>
                                    {{ $group->name }}
                                </option>
                            @endforeach
                        </select>
                    </form>

                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>FIO</th>
                                <th>Telefon</th>
                                <th>Manzil</th>
                                <th>Guruhlar</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $student)
                                <tr data-groups="{{ $student->groups->pluck('id')->join(',') }}">
                                    <td>{{ $student->id }}</td>
                                    <td>{{ $student->fio }}</td>
                                    <td>{{ $student->phone }}</td>
                                    <td>{{ $student->address }}</td>
                                    <td>
                                        @foreach ($student->groups as $group)
                                            <span class="badge badge-primary">{{ $group->name }}</span>
                                        @endforeach
                                    </td>
                                    <td>

                                        <a href="{{ route('admin.students.show', $student->id) }}"
                                            class="btn btn-info btn-sm">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.students.edit', $student->id) }}"
                                            class="btn btn-warning btn-sm">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endpush

@push('scripts')
    <!-- DataTables & Plugins -->
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

    <script>
        $(document).ready(function() {
            // DataTablesni ishga tushirish
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", ]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        });
    </script>
@endpush
