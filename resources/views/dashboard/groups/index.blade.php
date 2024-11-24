@extends('layout.dashboard')

@section('content-name', 'Guruhlar ro\'yxati')

@section('title', 'Guruhlar ro\'yxati')

@section('pages')
    <li class="breadcrumb-item ">Guruhlar</li>
    <li class="breadcrumb-item active">Guruhlar ro'yxati</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-white">
                <div class="card-header">
                    <h3 class="card-title">Guruhlar ro'yxati</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.groups.create') }}" class="btn btn-primary float-right text-white">
                            + Guruh qo'shish
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if ($groups->isEmpty())
                        <p class="text-center">Hozirda guruhlar mavjud emas.</p>
                    @else
                        <div class="row">
                            @foreach ($groups as $group)
                                <div class="col-md-4">
                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                                {{ $group->name }}
                                                @if ($group->status == 'active')
                                                    <span class="badge badge-success">Faol</span>
                                                @else
                                                    <span class="badge badge-danger">Tugatilgan</span>
                                                @endif
                                            </h3>

                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                            <!-- /.card-tools -->
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body pt-3 pb-1" style="height: 200px">
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
                                            <ul class="list-unstyled border-top border-bottom my-2"
                                                style="font-size: 14px;">
                                                @foreach ($group->schedules as $schedule)
                                                    <li>
                                                        {{ $schedule->day->name }}:
                                                        {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} -
                                                        {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                                                        (Xona:
                                                        {{ $schedule->room->name }})
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer d-flex justify-content-end">
                                            <div class="ml-1">
                                                <a href="{{ route('admin.groups.show', $group->id) }}"
                                                    class="btn btn-info btn-sm">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            </div>

                                            <div class="ml-1">
                                                <a href="{{ route('admin.groups.edit', $group->id) }}"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            </div>

                                            <div class="ml-1">
                                                <button class="btn btn-danger btn-sm"
                                                    onclick='confirmDelete({{ $group->id }},"{{ $group->name }}")'>
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                                <form action="{{ route('admin.groups.destroy', $group->id) }}"
                                                    method="POST" id="delete-form-{{ $group->id }}"
                                                    style="display:none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card -->

                                </div>
                            @endforeach

                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection


@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
@endpush


@push('scripts')
    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        function confirmDelete(group_id, group) {
            Swal.fire({
                title: group + " guruhini o'chirishni tasdiqlaysizmi?",
                text: 'Bu amal qaytarib bo\'lmaydi!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ha, o\'chirish',
                cancelButtonText: 'Yopish'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + group_id).submit();
                }
            });
        }
    </script>
@endpush
