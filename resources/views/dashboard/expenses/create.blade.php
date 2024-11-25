@extends('layout.dashboard')

@section('title', "Xarajat qo'shish")

@section('content-name', "Xarajat qo'shish")

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.expenses.index') }}">Xarajatlar</a></li>
    <li class="breadcrumb-item active">Xarajat qo'shish</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Yangi xarajat qo'shish</h4>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form id="expense-form" action="{{ route('admin.expenses.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="expense_category">Xarajat sababi</label>
                            <input type="text" name="category" class="form-control" id="expense_category"
                                placeholder="Xarajat turi" required>
                        </div>

                        <div class="form-group">
                            <label for="amount">Xarajat summasi</label>
                            <input type="number" name="amount" id="amount" class="form-control" step="0.01"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="payment_method">To'lov turi</label>
                            <select name="payment_method" id="payment_method" class="form-control" required>
                                <option value="cash">Naqd</option>
                                <option value="bank">Hisob raqamga</option>
                                <option value="transfer">O'tkazma</option>
                            </select>
                        </div>

                        {{-- <div class="form-group">
                            <label for="description">Izoh</label>
                            <textarea name="description" id="description" class="form-control" rows="3"></textarea>
                        </div> --}}

                        <div class="form-group">
                            <label for="receipt">Xarajat cheki (agar bo'lsa)</label>
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
                    <h5 class="modal-title" id="confirmationModalLabel">Xarajatni tasdiqlash</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>Kategoriya:</strong> <span id="modal-category"></span></p>
                    <p><strong>Xarajat summasi:</strong> <span id="modal-amount"></span></p>
                    <p><strong>To'lov turi:</strong> <span id="modal-payment-method"></span></p>
                    <p><strong>Izoh:</strong> <span id="modal-description"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Bekor qilish</button>
                    <button type="submit" form="expense-form" class="btn btn-primary">Tasdiqlash</button>
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

        $('#open-modal-btn').on('click', function() {
            // Form validation check
            const expenseCategory = $('#expense_category').val();
            const amount = $('#amount').val();
            const paymentMethod = $('#payment_method').val();
            const description = $('#description').val();

            if (expenseCategory && amount && paymentMethod) {
                // If all required fields are filled, show the modal
                $('#modal-category').text($('#expense_category option:selected').text());
                $('#modal-amount').text(amount);
                $('#modal-payment-method').text(paymentMethod);
                $('#modal-description').text(description);

                $('#confirmationModal').modal('show');
            } else {
                alert('Iltimos, barcha kerakli maydonlarni to\'ldiring.');
            }
        });
    </script>
@endpush
