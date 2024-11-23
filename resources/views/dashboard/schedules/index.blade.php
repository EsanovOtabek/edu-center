@extends('layout.dashboard')

@section('content-name', 'Dars Jadvali')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Dars Jadvali</h3>
                </div>

                <div class="card-body">
                    @foreach ($groups as $group)
                        <!-- Collapse Button for each group -->
                        <div class="bg-warning mb-3 px-3 py-2 text-bold border d-flex justify-content-between"
                             style="cursor: pointer;"
                             data-toggle="collapse"
                             data-target="#group_{{ $group->id }}"
                             aria-expanded="false"
                             aria-controls="group_{{ $group->id }}">

                            {{ $group->name }} - {{ $group->subject->name }} dars jadvali

                             <div>
                                 <i class="fa fa-angle-down"></i>
                             </div>
                        </div>

                        <!-- Collapse Panel for each group -->
                        <div id="group_{{ $group->id }}" class="collapse">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Kun</th>
                                    <th>Xona</th>
                                    <th>Boshlanish Vaqti</th>
                                    <th>Tugash Vaqti</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($group->schedules as $schedule)
                                    <tr>
                                        <td>{{ $schedule->day->name }}</td>
                                        <td>{{ $schedule->room->name }} ({{ $schedule->room->capacity }} sig'im)</td>
                                        <td>{{ $schedule->start_time }}</td>
                                        <td>{{ $schedule->end_time }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
@endpush

@push('scripts')
@endpush
