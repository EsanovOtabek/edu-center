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
                            <select name="teacher_id" id="teacher_id" class="form-control select2" required>
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
                            <h5><strong>Dars bo'ladigan vaqtlarni tanlang:</strong></h5>
                        </div>

                        <div class="col-md-12 table-responsive">
                            <table class="table  table-bordered table-tripped">
                                <tr class="bg-success">
                                    <th style="width: 200px">Kunlar</th>
                                    <th style="min-width: 200px">Xonalar</th>
                                    <th style="width: 130px">Boshlash vaqti</th>
                                    <th style="width: 130px">Tugash vaqti</th>
                                </tr>
                                @foreach ($days as $day)
                                    <tr>
                                        <td class="icheck-primary align-middle">
                                            <input type="checkbox" id="day_{{ $day->id }}"
                                                name="schedule[{{ $day->id }}][day_id]" value="{{ $day->id }}"
                                                class="day-checkbox">
                                            <label for="day_{{ $day->id }}"
                                                style="font-size: 18px">{{ $day->name }}</label>
                                        </td>
                                        <td class="form-group">
                                            <select name="schedule[{{ $day->id }}][room_id]"
                                                id="room_{{ $day->id }}" class="form-control room-select" disabled
                                                required>
                                                <option disabled selected value="">-- Xonani tanlang --</option>
                                                @foreach ($rooms as $room)
                                                    <option value="{{ $room->id }}">{{ $room->name }}
                                                        ({{ $room->capacity }} sig'imli)</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="schedule[{{ $day->id }}][start_time]"
                                                class="form-select start-time-select" id="start_time_{{ $day->id }}"
                                                disabled>
                                                <option selected disabled value="">Boshlash</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="schedule[{{ $day->id }}][end_time]"
                                                class="form-select end-time-select" id="end_time_{{ $day->id }}"
                                                disabled>
                                                <option selected disabled value="">Tugash</option>
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach


                            </table>

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
    <link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">

    <style>
        .select2-container .select2-selection--single {
            height: 38px;
            line-height: 38px;
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>

    <script>
        $('.select2').select2();


        $(document).ready(function() {
            // Find all checkboxes
            $('.day-checkbox').each(function() {
                $(this).on('change', function() {
                    const dayId = $(this).attr('id').split('_')[
                    1]; // Extract day ID from checkbox ID
                    const roomSelect = $(`#room_${dayId}`);
                    var startTimeSelect = $(`#start_time_${dayId}`);
                    var endTimeSelect = $(`#end_time_${dayId}`);

                    if ($(this).prop('checked')) {
                        // Enable related fields
                        roomSelect.prop('disabled', false);
                        startTimeSelect.prop('disabled', false);
                        endTimeSelect.prop('disabled', false);

                        roomSelect.on('change', function() {
                            const roomId = roomSelect.val();

                            checkIfTimeForStart(dayId, roomId);
                        })
                        // Add event listeners for time selection
                        startTimeSelect.on('change', function() {
                            const startTime = startTimeSelect.val();
                            const roomId = roomSelect.val();
                            // Disable end times before the selected start time
                            disableEndTimesBeforeStartTime(dayId, startTime);
                        });

                    } else {
                        // Disable and reset related fields
                        roomSelect.prop('disabled', true);
                        startTimeSelect.prop('disabled', true);
                        endTimeSelect.prop('disabled', true);

                        roomSelect.val('');
                        startTimeSelect.val('');
                        endTimeSelect.val('');
                    }
                });
            });

            function checkIfTimeForStart(dayId, roomId) {
                var startTimeSelect = $(`#start_time_${dayId}`);
                var endTimeSelect = $(`#end_time_${dayId}`);

                $.ajax({
                    url: "{{ route('admin.check.schedule.start') }}",
                    type: 'GET',
                    data: {
                        day_id: dayId,
                        room_id: roomId
                    },
                    success: function(data) {
                        startTimeSelect.html(data)
                        endTimeSelect.html(data)
                    },
                    error: function(error) {
                        console.error('Error checking schedule:', error);
                    }
                });

            }

            function disableEndTimesBeforeStartTime(dayId, startTime) {
                var endTimeSelect = $(`#end_time_${dayId}`);
                var options = endTimeSelect.find('option');
                options.each(function() {
                    var endTime = $(this).val();
                    // Compare start time and end time (in HH:mm format)
                    if (moment(endTime, 'HH:mm').isBefore(moment(startTime, 'HH:mm'))) {
                        $(this).prop('disabled', true);
                    }
                });
            }



        });
    </script>
@endpush
