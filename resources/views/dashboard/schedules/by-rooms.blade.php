@extends('layout.dashboard')

@section('content-name', 'Xona: ' . $room->name . ' dars jadvali')

@section('title', 'Xona: ' . $room->name . ' dars jadvali')

@section('pages')
    <li class="breadcrumb-item ">Xonalar</li>
    <li class="breadcrumb-item active">{{ $room->name }} xonasining dars jadvlari</li>
@endsection

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Xona: {{ $room->name }} (Sig‘imi: {{ $room->capacity }})</h3>
        </div>
        <div class="card-body">
            @if ($schedule->isEmpty())
                <p class="text-center text-muted">Bu xonaga dars jadvali belgilanmagan.</p>
            @else
                @foreach ($schedule as $dayName => $schedules)
                    <!-- Kun nomi bo'yicha collapse tugmasi -->
                    <div class="bg-warning text-bold mb-2 px-3 py-2 d-flex justify-content-between align-items-center"
                        style="cursor: pointer;" data-toggle="collapse" data-target="#schedule_{{ Str::slug($dayName) }}"
                        aria-expanded="false" aria-controls="schedule_{{ Str::slug($dayName) }}">
                        <span>{{ $dayName }}</span>
                        <i class="fa fa-angle-down"></i>
                    </div>

                    <!-- Collapse mazmuni -->
                    <div id="schedule_{{ Str::slug($dayName) }}" class="collapse">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Guruh</th>
                                    <th>Fan</th>
                                    <th>O‘qituvchi</th>
                                    <th>Boshlanish Vaqti</th>
                                    <th>Tugash Vaqti</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($schedules as $entry)
                                    <tr>
                                        <td>{{ $entry->group->name }}</td>
                                        <td>{{ $entry->group->subject->name }}</td>
                                        <td>{{ $entry->group->teacher->fio }}</td>
                                        <td>{{ $entry->start_time }}</td>
                                        <td>{{ $entry->end_time }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="card-footer">
            <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary">Orqaga</a>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Optional: Collapse ikonkasini aylantirish */
        .collapse.show+.fa-angle-down {
            transform: rotate(180deg);
        }
    </style>
@endpush
