@extends('layout.dashboard')

@section('title', 'Guruh Davomatlari')
@section('content-name', 'Davomat boshqaruvi')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-light">
                    <div class="card-header">
                        <h3 class="card-title">{{ $group->name }} guruhini davomat qilish</h3>
                    </div>
                    <div class="card-body row">
                        <div class="col-md-6">
                            <!-- Yillar select -->
                            <label for="year-select">Yilni tanlang:</label>
                            <select id="year-select" class="form-control">
                                @foreach ($years as $year)
                                    <option value="{{ $year }}" {{ $year == $currentYear ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <!-- Oyning select -->
                            <label for="month-select">Oyni tanlang:</label>
                            <select id="month-select" class="form-control">
                                @foreach ($months as $month)
                                    <option value="{{ $month['number'] }}"
                                        {{ $month['number'] == $currentMonth ? 'selected' : '' }}>
                                        {{ $month['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 d-flex justify-content-end">
                            <div class="mt-4 mb-0 mr-2">
                                <p class="text-success m-0">
                                    <i class="fas fa-check-circle text-success"></i>
                                    Darsga qatnashgan
                                </p>
                                <p class="text-danger m-0">
                                    <i class="fas fa-info-circle text-warning"></i>
                                    Sababli qatnashmagan
                                </p>
                                <p class="text-warning m-0">
                                    <i class="fas fa-times-circle text-danger"></i>
                                    Sababsiz qatnashmagan
                                </p>
                            </div>
                        </div>

                        <form class="col-md-12 table-responsive mt-4" method="POST"
                            action="{{ route('admin.attendance.save', $group) }}" id="davomat-form">
                            @csrf

                            <table class="table table-striped table-hover" style="border-bottom: 1px solid #333;">
                                <thead class="text-sm">
                                    <tr style="border-bottom: 3px solid #333;">
                                        <th>T/r</th>
                                        <th style="width: 240px;">Talaba</th>
                                        @foreach ($daysInMonth as $day)
                                            <th @class([
                                                'bg-warning' => $today == $day,
                                                'text-center',
                                            ])>
                                                {{ sprintf('%02d/%02d', $day, $currentMonth) }}
                                            </th>
                                        @endforeach

                                        @if ($lessonInProgress)
                                            <th style="background: #ff9933aa; width: 150px">Davomat</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $student)
                                        <tr>
                                            <td class="text-bold">{{ $loop->index + 1 }} </td>
                                            <td style="font-size: 16px; font-weight: bold;">
                                                {{ $student->fio }}</td>
                                            @foreach ($daysInMonth as $day)
                                                <td class="text-center">
                                                    @php
                                                        $date = sprintf(
                                                            '%04d-%02d-%02d',
                                                            $currentYear,
                                                            $currentMonth,
                                                            $day,
                                                        );

                                                    @endphp
                                                    @if (isset($attendanceData[$student->id][$date]))
                                                        @switch($attendanceData[$student->id][$date][0]->status)
                                                            @case('present')
                                                                <i class="fas fa-check-circle text-success"></i>
                                                            @break

                                                            @case('absent')
                                                                <i class="fas fa-times-circle text-danger"></i>
                                                            @break

                                                            @case('late')
                                                                <i class="fas fa-info-circle text-warning"></i>
                                                            @break

                                                            @default
                                                                <i class="fas fa-circle "></i>
                                                        @endswitch
                                                    @else
                                                        <i class="far fa-circle"></i>
                                                    @endif
                                                </td>
                                            @endforeach

                                            @if ($lessonInProgress)
                                                <td style="background: #ff9933aa">
                                                    <select name="status[{{ $student->id }}]" class="attendance-select">
                                                        <option value="" selected>-- Darsda --</option>
                                                        <option value="present">Bor</option>
                                                        <option value="absent">Yo'q</option>
                                                        <option value="late">Sababli</option>
                                                    </select>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </form>

                        <div class="col-md-12">
                            @if ($lessonInProgress)
                                <div class="text-right mt-3">
                                    <button type="submit" class="btn btn-primary" form="davomat-form">Davomatni
                                        saqlash</button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('year-select').addEventListener('change', function() {
            const year = this.value;
            const month = document.getElementById('month-select').value;
            window.location.href = `?year=${year}&month=${month}`;
        });

        document.getElementById('month-select').addEventListener('change', function() {
            const month = this.value;
            const year = document.getElementById('year-select').value;
            window.location.href = `?year=${year}&month=${month}`;
        });
    </script>
@endpush
