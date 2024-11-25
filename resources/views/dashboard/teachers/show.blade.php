@extends('layout.dashboard')

@section('title', "O'qituvchi Ma'lumotlari")

@section('content-name', "O'qituvchi Ma'lumotlari")

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.teachers.index') }}">O'qituvchilar</a></li>
    <li class="breadcrumb-item active">O'qituvchi: {{ $teacher->fio }}</li>
@endsection

@section('content')
    <div class="row">
        <!-- O'qituvchi ma'lumotlari -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        <strong>{{ $teacher->fio }}</strong> haqida ma'lumot
                    </h4>
                </div>
                <div class="card-body row">
                    <div class="col-md-8 d-flex justify-content-start">
                        <div>
                            <img src="{{ asset('storage/' . $teacher->image) }}" class="img-thumbnail"
                                style="max-width: 200px;">
                        </div>
                        <div class="ml-3">
                            <p class="m-0"><strong>Telefon:</strong> {{ $teacher->phone }}</p>
                            <p class="m-0"><strong>Passport raqami:</strong> {{ $teacher->passport_number }}</p>
                            <p class="m-0"><strong>Guruhlar soni:</strong> {{ $groupCount }} ta</p>
                            <p class="m-0"><strong>Talabalar soni:</strong> {{ $studentCount }} ta</p>
                            <hr>
                            <p class="h4"><strong>Balans:</strong> {{ $teacher->balance }} so'm</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        {{-- <form action="{{ route('admin.teachers.giveSalary', $teacher->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success">Oylik berish</button>
                        </form> --}}
                        <form action="{{ route('admin.teachers.giveAdvance', $teacher->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="amount">Pul berish</label>
                                <input type="number" name="amount" id="amount" class="form-control" step="0.01"
                                    required placeholder="000 000">
                            </div>
                            <button type="submit" class="btn btn-warning">Pul berish</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <!-- Guruhlar va Talabalar -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Guruhlar</h4>
                </div>
                <div class="card-body">
                    @foreach ($teacher->groups as $group)
                        <div class="accordion" id="accordion{{ $group->id }}">
                            <div class="card">
                                <div class="card-header bg-warning" id="heading{{ $group->id }}">
                                    <h5 class="mb-0">
                                        <div class="bg-warning" type="button" data-toggle="collapse"
                                            data-target="#collapse{{ $group->id }}" aria-expanded="true"
                                            aria-controls="collapse{{ $group->id }}">
                                            {{ $loop->index + 1 }}.
                                            {{ $group->name }}
                                            ({{ $group->subject->name }})
                                        </div>
                                    </h5>
                                </div>

                                <div id="collapse{{ $group->id }}" class="collapse"
                                    aria-labelledby="heading{{ $group->id }}"
                                    data-parent="#accordion{{ $group->id }}">
                                    <div class="card-body table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th>FIO</th>
                                                    <th>Telefon</th>
                                                    <th>To'lov boshlangan sana</th>
                                                    <th>To'lov tugash sanasi</th>
                                                    <th>To'lov qilingan sana</th>
                                                    <th>Holati</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($group->students as $index => $student)
                                                    @php
                                                        // Talabaning oxirgi to'lov ma'lumotini olish
                                                        $lastPayment = $student->payments->last();
                                                    @endphp
                                                    <tr class="@if ($lastPayment && $lastPayment->payment_period_end < now()) table-danger @endif">
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $student->fio }}</td>
                                                        <td>{{ $student->phone }}</td>
                                                        <td>
                                                            {{ $lastPayment ? $lastPayment->payment_period_start : 'Mavjud emas' }}
                                                        </td>
                                                        <td>
                                                            {{ $lastPayment ? $lastPayment->payment_period_end : 'Mavjud emas' }}
                                                        </td>
                                                        <td>
                                                            {{ $lastPayment ? $lastPayment->created_at : 'Mavjud emas' }}
                                                        </td>
                                                        @if (is_null($lastPayment))
                                                            <td class="bg-danger">To'lov muddati tugagan</td>
                                                        @elseif($lastPayment->payment_period_end < now())
                                                            <td class="bg-danger">To'lov muddati tugagan</td>
                                                        @else
                                                            <td class="bg-success">To'lov davom etmoqda</td>
                                                        @endif
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
@endpush
