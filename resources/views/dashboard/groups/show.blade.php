@extends('layout.dashboard')

@section('content-name', 'Guruh ma\'lumotlari')
@section('title', 'Guruhni ko\'rish')

@section('pages')
    <li class="breadcrumb-item ">Guruhlar</li>
    <li class="breadcrumb-item active">{{ $group->name }} </li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-light">
                <div class="card-header">
                    <h3 class="card-title d-flex justify-content-between">
                        {{ $group->name }} guruh ma'lumotlari
                    </h3>
                    <div class="card-tools">
                        <button class="btn btn-primary" id="add-student-btn">Yangi Talaba biriktirish</button>
                    </div>
                </div>

                <div class="card-body">
                    <div class="info">
                        <div>
                            <b>Fan:</b>
                            {{ Str::upper($group->subject->name) }}
                        </div>
                        <div>
                            <b>O'qituvchi:</b>
                            {{ Str::upper($group->teacher->fio) }}
                        </div>
                        <div>
                            <b>Narxi:</b>
                            {{ number_format($group->price) }} so'm
                        </div>
                        <div>
                            <b>Talabalar soni:</b>
                            {{ $group->students->count() }} ta
                        </div>

                    </div>

                    <div class="studets-table-of-group border-top mt-2 pt-2 table-responsive">
                        <h5><strong>Guruh talabalari</strong></h5>
                        @if ($group->students->isEmpty())
                            <p>Ushbu guruhga biriktirilgan talabalar mavjud emas.</p>
                        @else
                            <table class="table table-bordered table-sm">
                                <thead class="bg-warning">
                                    <tr>
                                        <th>#</th>
                                        <th>FIO</th>
                                        <th>Telefon</th>
                                        <th>Qo'shilgan sana</th>
                                        <th>Ajratish</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($group->students as $student)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $student->fio }}</td>
                                            <td>{{ $student->phone }}</td>
                                            <td>{{ $student->pivot->start_date }}</td>
                                            <td>
                                                <button class="btn btn-danger btn-sm remove-student-btn"
                                                    data-student-id="{{ $student->id }}">
                                                    <i class="fa fa-user-minus"></i>
                                                </button>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addStudentModalLabel">Guruhga yangi talaba qo'shish</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Talabani tanlash</label>
                        <select class="form-control" id="available-students">
                            <!-- Talabalar Ajax orqali yuklanadi -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Talabani dars boshlanish sanasini tanlash</label>
                        <input type="date" name="start_date" class="form-control" id="start_date">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
                    <button type="button" class="btn btn-primary" id="confirm-add-student">Qo'shish</button>
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
        const groupId = {!! $group->id !!}; // Guruh ID

        $(document).on('click', '.remove-student-btn', function() {
            const studentId = $(this).data('student-id');
            Swal.fire({
                title: "Ishonchingiz komilmi",
                text: 'Bu talaba guruhdan olib tashlanadi!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Olib tashlash',
                cancelButtonText: 'Bekor qilish'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.removeStudentGroup', $group->id) }}",
                        type: 'POST',
                        data: {
                            student_id: studentId,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire({
                                title: "Muvaffaqiyatli!",
                                text: response.message,
                                icon: "success",
                                confirmButtonText: "OK"
                            }).then(() => {
                                location.reload(); // Sahifani qayta yuklash
                            });
                        },
                        error: function() {
                            Swal.fire({
                                title: "Xatolik yuz berdi",
                                text: "Iltimos, qayta urinib ko'ring",
                                icon: "error",
                                confirmButtonText: "Yopish"
                            });
                        },
                    });
                }
            });
        });
        $('#add-student-btn').on('click', function() {
            $.ajax({
                url: "{{ route('admin.getAvailableStudents', $group->id) }}",
                type: 'GET',
                success: function(students) {
                    const select = $('#available-students').empty();
                    if (students.length === 0) {
                        select.append('<option value="">Bo\'sh talabalar mavjud emas</option>');
                    } else {
                        students.forEach(student => {
                            select.append(
                                `<option value="${student.id}">${student.fio}</option>`);
                        });
                    }
                    $('#addStudentModal').modal('show');
                },
            });
        });

        $('#confirm-add-student').on('click', function() {
            const studentId = $('#available-students').val();
            const start_date = $('#start_date').val();

            if (studentId) {
                $.ajax({
                    url: "{{ route('admin.addStudentGroup', $group->id) }}",
                    type: 'POST',
                    data: {
                        student_id: studentId,
                        start_date: start_date,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire({
                            title: "Muvaffaqiyatli!",
                            text: response.message,
                            icon: "success",
                            confirmButtonText: "OK"
                        }).then(() => {
                            location.reload(); // Sahifani qayta yuklash
                        });
                    },
                    error: function() {
                        Swal.fire({
                            title: "Xatolik yuz berdi",
                            text: "Iltimos, qayta urinib ko'ring",
                            icon: "error",
                            confirmButtonText: "Yopish"
                        });
                    },
                });
            } else {
                Swal.fire({
                    title: "Talaba tanlanmagan",
                    text: "Iltimos, avval talaba tanlang",
                    icon: "warning",
                    confirmButtonText: "Yopish"
                });
            }
        });
    </script>
@endpush
