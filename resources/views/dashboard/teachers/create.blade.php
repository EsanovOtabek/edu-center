@extends('layout.dashboard')

@section('content-name', 'O\'qituvchi qo\'shish')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">O'qituvchi qo'shish</h3>
                </div>

                <form method="POST" action="{{ route('admin.teachers.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body row">
                        <div class="form-group col-md-6">
                            <label for="fio">To'liq ism</label>
                            <input type="text" name="fio" id="fio" class="form-control" required value="{{ old('fio') }}" placeholder="F.I.Sh">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="passport_number">Pasport nomeri</label>
                            <input type="text" name="passport_number" id="passport_number" class="form-control" required value="{{ old('passport_number') }}" placeholder="AAXXXXXXX">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="phone">Telefon raqami</label>
                            <input type="text" name="phone" id="phone" class="form-control" required value="{{ old('phone') }}" placeholder="+998XXYYYYYYY">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="password">Parol</label>
                            <input type="password" name="password" id="password" class="form-control" required value="{{ old('password') }}" placeholder="password">
                        </div>


                        <div class="form-group col-md-6">
                            <label for="salary_percentage">Oylik foiz</label>
                            <input type="number" name="salary_percentage" id="salary_percentage" class="form-control" required min="0" max="100" value="{{ old('salary_percentage') }}" placeholder="0">
                        </div>

                        <!-- Subjects Selection -->
                        <div class="form-group col-md-6">
                            <label for="subjects">Darslar</label>
                            <select name="subjects[]" class="select2" multiple="multiple" data-placeholder="Fanlarni tanlash" style="width: 100%;" required>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="image">Rasm yuklash</label>
                            <input type="file" name="image" id="image" class="form-control" required  accept="image/*">
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
@endpush

@push('scripts')
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $('.select2').select2()

    </script>
@endpush
