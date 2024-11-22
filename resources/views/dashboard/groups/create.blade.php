@extends('layout.dashboard')

@section('content-name', 'Guruh qo\'shish')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Guruh qo'shish</h3>
                </div>

                <form method="POST" action="{{ route('admin.groups.store') }}">
                    @csrf
                    <div class="card-body row">
                        <div class="form-group col-md-6">
                            <label for="name">Guruh nomi</label>
                            <input type="text" name="name" id="name" class="form-control" required
                                value="{{ old('name') }}" placeholder="Guruh nomi">
                        </div>

                        <!-- Subjects Selection -->
                        <div class="form-group col-md-6">
                            <label for="subject_id">Fanni tanlang</label>
                            <select name="subject_id" id="subject_id" class="form-control" required>
                                <option disabled selected>-- Tanlang --</option>
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Subjects Selection -->
                        <div class="form-group col-md-6">
                            <label for="teacher_id">O'qituvchini tanlang</label>
                            <select name="teacher_id" id="teacher_id" class="form-control select2 " required>
                                <option disabled selected>-- Tanlang --</option>
                                @foreach ($teachers as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->fio }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="price">Guruh narxi(so'm)</label>
                            <input type="number" name="price" id="price" class="form-control" required
                                value="{{ old('price') }}" placeholder="000000">
                        </div>

                        <div class="col-md-12">
                            <div id="calendar" class="calendar"></div>

                        </div>

                    </div>

                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary">Saqlash</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fullcalendar/main.css') }}">

    <style>
        .select2-container .select2-selection--single {
            height: 38px;
            /* Belgilangan bo'shliqni yaxshilash */
            line-height: 38px;
            /* Vertical align */
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/fullcalendar/main.js') }}"></script>

    <script>
        $('.select2').select2();
    </script>
    <script>
        $(document).ready(function() {
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'agendaWeek'
                },
                events: [
                    // Simulyatsiya qilingan band soatlar
                    {
                        title: 'Booked',
                        start: '2024-11-23T10:30:00',
                        end: '2024-11-23T11:00:00'
                    },
                    {
                        title: 'Booked',
                        start: '2024-11-23T14:00:00',
                        end: '2024-11-23T14:30:00'
                    }
                ],
                selectable: true,
                selectHelper: true,
                select: function(start, end) {
                    // Tanlangan vaqt oralig'ini olish
                    var startTime = moment(start).format('YYYY-MM-DD HH:mm:ss');
                    var endTime = moment(end).format('YYYY-MM-DD HH:mm:ss');

                    // AJAX orqali band bo'lmagan soatlarni tekshirish
                    $.ajax({
                        url: '/check-availability', // Serverda bandlikni tekshirish uchun endpoint
                        method: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            start: startTime,
                            end: endTime
                        },
                        success: function(response) {
                            if (response.available) {
                                // Vaqt bo'sh
                                alert("Time is available.");
                                $('#calendar').fullCalendar('renderEvent', {
                                    title: 'Selected',
                                    start: start,
                                    end: end,
                                    backgroundColor: '#28a745'
                                });
                            } else {
                                // Vaqt band
                                alert("This time is already booked.");
                            }
                        }
                    });
                },
                minTime: '08:00:00', // Soatning minimal vaqti
                maxTime: '18:00:00', // Soatning maksimal vaqti
                slotDuration: '00:30:00', // Har 30 daqiqalik slot
                allDaySlot: false // "Barcha kun" slotini yo'q qilish
            });
        });
    </script>
@endpush
