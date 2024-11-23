@extends('layout.dashboard')

@section('content-name', 'O‘qituvchilar')

@section('pages')
    <li class="breadcrumb-item active">O‘qituvchilar</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary float-right">+ O‘qituvchi
                        Qo‘shish</a>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>To‘liq Ismi</th>
                                <th>Telefon</th>
                                <th>Foiz</th>
                                <th>Fanlari</th>
                                <th>Balans</th>
                                <th>View</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($teachers as $teacher)
                                <tr>
                                    <td>{{ $teacher->id }}</td>
                                    <td>{{ $teacher->fio }}</td>
                                    <td>{{ $teacher->phone }}</td>
                                    <td>{{ $teacher->salary_percentage }}</td>
                                    <td>
                                        @foreach ($teacher->subjects->pluck('name') as $tsb)
                                            <span class="p-1 bg-primary rounded">{{ $tsb }}</span>
                                        @endforeach
                                    </td>
                                    <td>{{ $teacher->balance }}</td>
                                    <td>
                                        <a href="{{ route('admin.teachers.show', $teacher->id) }}" class="btn btn-info"><i
                                                class="fa fa-eye"></i></a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.teachers.edit', $teacher->id) }}"
                                            class="btn btn-warning"><i class="fa fa-edit"></i></a>
                                    </td>
                                    <td>
                                        <button class="btn btn-danger"
                                            onclick='confirmDelete({{ $teacher->id }},"{{ $teacher->fio }}")'>
                                            <i class="fa fa-trash"></i>
                                        </button>
                                        <form action="{{ route('admin.teachers.destroy', $teacher->id) }}" method="POST"
                                            id="delete-form-{{ $teacher->id }}" style="display:none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
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
    <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
@endpush


@push('scripts')
    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        function confirmDelete(teacher_id, teacher) {
            Swal.fire({
                title: teacher + " o'qituvchini o'chirishni tasdiqlaysizmi?",
                text: 'Bu amal qaytarib bo\'lmaydi!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ha, o\'chirish',
                cancelButtonText: 'Yopish'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + teacher_id).submit();
                }
            });
        }
    </script>
@endpush
