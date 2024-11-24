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
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ $group->name }} guruh ma'lumotlari</h3>
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
                                        <th>Manzil</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($group->students as $student)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $student->fio }}</td>
                                            <td>{{ $student->phone }}</td>
                                            <td>{{ $student->address }}</td>
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
@endsection
