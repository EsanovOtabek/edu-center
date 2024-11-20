@extends('layout.dashboard')

@section('content-name', 'O\'qituvchi qo\'shish')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">O'qituvchi qo'shish</h3>
                </div>

                <form method="POST" action="{{ route('admin.teachers.store') }}">
                    @csrf
                    <div class="card-body row">
                        <div class="form-group col-sm-6">
                            <label for="fio">To'liq ism</label>
                            <input type="text" name="fio" id="fio" class="form-control" required value="{{ old('fio') }}">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="phone">Telefon raqami</label>
                            <input type="text" name="phone" id="phone" class="form-control" required value="{{ old('phone') }}">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="passport_number">Pasport nomeri</label>
                            <input type="text" name="passport_number" id="passport_number" class="form-control" required value="{{ old('passport_number') }}">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="salary_percentage">Oylik foiz</label>
                            <input type="number" name="salary_percentage" id="salary_percentage" class="form-control" required min="0" max="100" value="{{ old('salary_percentage') }}">
                        </div>

                        <!-- Subjects Selection -->
                        <div class="form-group col-sm-12">
                            <label for="subjects">Darslar</label>
                            <select name="subjects[]" id="subjects" class="form-control select2" multiple required>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
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
