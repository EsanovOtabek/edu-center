@extends('layout.dashboard')

@section('content-name', 'Talabani tahrirlash')
@section('title', 'Talabani tahrirlash')

@section('pages')
    <li class="breadcrumb-item ">Talabalar</li>
    <li class="breadcrumb-item active">Talabani tahrirlash</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Talabani tahrirlash</h3>
                </div>

                <form method="POST" action="{{ route('admin.students.update', $student->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body row">
                        <div class="form-group col-md-6">
                            <label for="fio">FIO*</label>
                            <input type="text" name="fio" id="fio" class="form-control" required
                                value="{{ $student->fio }}" placeholder="Talabaning FIO">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="address">Manzil*</label>
                            <input type="text" name="address" id="address" class="form-control" required
                                value="{{ $student->address }}" placeholder="Manzili">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="phone">Telefon*</label>
                            <input type="text" name="phone" id="phone" class="form-control" required
                                value="{{ $student->phone }}" placeholder="Telefon raqami">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="telegram_id">Telegram ID*</label>
                            <input type="text" name="telegram_id" id="telegram_id" class="form-control"
                                value="{{ $student->telegram_id }}" placeholder="Telegram ID">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="father_fio">Otasi FIO</label>
                            <input type="text" name="father_fio" id="father_fio" class="form-control"
                                value="{{ $student->father_fio }}" placeholder="Otasi FIO">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="father_phone">Otasi telefon raqami</label>
                            <input type="text" name="father_phone" id="father_phone" class="form-control"
                                value="{{ $student->father_phone }}" placeholder="Otasi telefon raqami">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="mother_fio">Onasi FIO</label>
                            <input type="text" name="mother_fio" id="mother_fio" class="form-control"
                                value="{{ $student->mother_fio }}" placeholder="Onasi FIO">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="mother_phone">Onasi telefon raqami</label>
                            <input type="text" name="mother_phone" id="mother_phone" class="form-control"
                                value="{{ $student->mother_phone }}" placeholder="Onasi telefon raqami">
                        </div>

                        <!-- Guruhlar -->
                        <div class="form-group col-md-12">
                            <label>Guruhlar</label>
                            <div id="groups-container">
                                @foreach ($student->groups as $index => $group)
                                    <div class="row mb-3 group-row">
                                        <div class="col-md-6">
                                            <select name="groups[{{ $index }}][id]" class="form-control group-select"
                                                required>
                                                <option disabled value="">-- Guruhni tanlang --</option>
                                                @foreach ($groups as $grp)
                                                    <option value="{{ $grp->id }}"
                                                        {{ $grp->id == $group->id ? 'selected' : '' }}>
                                                        {{ $grp->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="date" name="groups[{{ $index }}][start_date]"
                                                class="form-control" value="{{ $group->pivot->start_date }}" required>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-danger remove-group">-</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" id="add-group" class="btn btn-success">Yangi guruh qo‘shish</button>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Saqlash</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let groupIndex = {{ count($student->groups) }};
        document.getElementById('add-group').addEventListener('click', function() {
            const container = document.getElementById('groups-container');
            const newGroup = document.querySelector('.group-row').cloneNode(true);
            newGroup.querySelectorAll('select, input').forEach(input => {
                const name = input.name.replace(/\d+/g, groupIndex);
                input.name = name;
                input.value = '';
            });
            container.appendChild(newGroup);
            groupIndex++;
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-group')) {
                const row = e.target.closest('.group-row');
                if (document.querySelectorAll('.group-row').length > 1) {
                    row.remove();
                }
            }
        });
    </script>
@endpush
