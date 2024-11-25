@extends('layout.dashboard')

@section('title', "To'lovlar")

@section('content-name', "To'lovlar")

@section('breadcrumb')
    <li class="breadcrumb-item active">To'lovlar</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header row">
                    <h4 class="card-title col-md-6">To'lovlar ro'yxati</h4>
                    <form class="col-md-6 d-flex justify-content-around">
                        <strong>To'lov turi filter:</strong>
                        <select name="payment_method" id="payment_method" class="form-control" onchange="this.form.submit()">
                            @foreach ($paymentMethods as $method)
                                <option value="{{ $method }}"
                                    {{ request('payment_method') == $method ? 'selected' : '' }}>
                                    {{ ucfirst($method) }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
                <div class="card-body table-responsive table-sm">
                    <table class="table table-bordered" id="example1">
                        <thead class="bg-warning">
                            <tr>
                                <th>T/r</th>
                                <th>O'quvchi</th>
                                <th>Guruh</th>
                                <th>To'lov qilingan sana</th>
                                <th>To'lov davri</th>
                                <th>To'lov summasi</th>
                                <th>To'lov turi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $payment)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $payment->student->fio }}</td>
                                    <td>{{ $payment->group->name }}</td>
                                    <td>{{ $payment->created_at->format('d-m-Y') }}</td>
                                    <td>
                                        <span class="badge badge-info"
                                            style="font-size: 16px">{{ $payment->payment_period_start }}</span>
                                        -
                                        <span class="badge badge-info"
                                            style="font-size: 16px">{{ $payment->payment_period_end }}</span>
                                    </td>
                                    <td>{{ $payment->amount }} {{ $payment->currency }}</td>
                                    <td>{{ ucfirst($payment->payment_method) }}</td>
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
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
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
