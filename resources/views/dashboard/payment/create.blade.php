@extends('layout.dashboard')

@section('title', "To'lov qilish")

@section('content-name', "To'lov qilish")

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.payment.index') }}">To'lovlar</a></li>
    <li class="breadcrumb-item active">To'lov qilish</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Yangi to'lov qo'shish</h4>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form id="payment-form" action="{{ route('admin.payment.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="student_id">Talaba</label>
                            <select name="student_id" id="student_id" class="form-control select2" required>
                                <option value="">Talabani tanlang</option>
                                @foreach ($students as $student)
                                    <option value="{{ $student->id }}">{{ $student->fio }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="group_id">Guruh</label>
                            <select name="group_id" id="group_id" class="form-control" required>
                                <option value="">Guruhni tanlang</option>
                            </select>
                        </div>

                        <input type="hidden" name="teacher_id" id="teacher_id">

                        <div class="form-group">
                            <label for="amount">To'lov summasi</label>
                            <input type="number" name="amount" id="amount" class="form-control" step="0.01"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="currency">Valyuta</label>
                            <select name="currency" id="currency" class="form-control" required>
                                <option value="UZS">UZS</option>
                                <option value="USD">USD</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="payment_method">To'lov turi</label>
                            <select name="payment_method" id="payment_method" class="form-control" required>
                                <option value="cash">Naqd</option>
                                <option value="bank">Hisob raqamga</option>
                                <option value="online">To'lov tizimi</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="payment_period_start">To'lov davri boshlanish sanasi</label>
                            <input type="date" name="payment_period_start" id="payment_period_start" class="form-control"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="payment_period_end">To'lov davri tugash sanasi</label>
                            <input type="date" name="payment_period_end" id="payment_period_end" class="form-control"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="receipt">To'lov cheki (agar bo'lsa)</label>
                            <input type="file" name="receipt" id="receipt" class="form-control">
                        </div>

                        <button type="button" class="btn btn-primary" id="open-modal-btn">
                            Saqlash
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal oynasi -->
    <div class="modal fade" id="confirmationModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">To'lovni tasdiqlash</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>Talaba:</strong> <span id="modal-student"></span></p>
                    <p><strong>Guruh:</strong> <span id="modal-group"></span></p>
                    <p><strong>To'lov summasi:</strong> <span id="modal-amount"></span></p>
                    <p><strong>Valyuta:</strong> <span id="modal-currency"></span></p>
                    <p><strong>To'lov turi:</strong> <span id="modal-payment-method"></span></p>
                    <p><strong>To'lov davri:</strong> <span id="modal-payment-period"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Bekor qilish</button>
                    <button type="submit" form="payment-form" class="btn btn-primary">Tasdiqlash</button>
                </div>
            </div>
        </div>
        <!-- /.modal-dialog -->
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

        $('#student_id').on('change', function() {
            const studentId = $(this).val();

            // Talabaga tegishli guruhlarni olish
            if (studentId) {
                $.ajax({
                    url: "{{ route('admin.payment.getGroupsByStudent') }}",
                    type: "GET",
                    data: {
                        student_id: studentId
                    },
                    success: function(groups) {
                        let groupOptions = '<option value="">Guruhni tanlang</option>';
                        groups.forEach(group => {
                            groupOptions += `<option value="${group.id}" data-teacher-id="${group.teacher_id}">
                                                    ${group.name}
                                                 </option>`;
                        });
                        $('#group_id').html(groupOptions);
                    }
                });
            } else {
                $('#group_id').html('<option value="">Guruhni tanlang</option>');
            }
        });

        $('#group_id').on('change', function() {
            const teacherId = $(this).find(':selected').data('teacher-id');
            $('#teacher_id').val(teacherId);
        });

        $('#open-modal-btn').on('click', function() {
            // Form validation check
            const studentId = $('#student_id').val();
            const groupId = $('#group_id').val();
            const amount = $('#amount').val();
            const currency = $('#currency').val();
            const paymentMethod = $('#payment_method').val();
            const paymentPeriodStart = $('#payment_period_start').val();
            const paymentPeriodEnd = $('#payment_period_end').val();

            if (studentId && groupId && amount && currency && paymentMethod && paymentPeriodStart &&
                paymentPeriodEnd) {
                // If all required fields are filled, show the modal
                $('#modal-student').text($('#student_id option:selected').text());
                $('#modal-group').text($('#group_id option:selected').text());
                $('#modal-amount').text(amount);
                $('#modal-currency').text(currency);
                $('#modal-payment-method').text(paymentMethod);
                $('#modal-payment-period').text(paymentPeriodStart + ' - ' + paymentPeriodEnd);

                $('#confirmationModal').modal('show');
            } else {
                alert('Iltimos, barcha kerakli maydonlarni to\'ldiring.');
            }
        });
    </script>
@endpush
