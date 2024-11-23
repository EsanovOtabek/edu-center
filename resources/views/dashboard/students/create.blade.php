@extends('layout.dashboard')

@section('content-name', 'O‘quvchini qo‘shish')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Yangi o‘quvchini qo‘shish</h3>
                </div>

                <form method="POST" action="{{ route('admin.students.store') }}">
                    @csrf
                    <div class="card-body row">
                        <div class="form-group col-md-6">
                            <label for="fio">FIO</label>
                            <input type="text" name="fio" id="fio" class="form-control" required
                                placeholder="O‘quvchining FIO">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="phone">Telefon</label>
                            <input type="text" name="phone" id="phone" class="form-control" required
                                placeholder="Telefon raqami">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="address">Manzil</label>
                            <input type="text" name="address" id="address" class="form-control" placeholder="Manzili">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="father_fio">Otasi FIO</label>
                            <input type="text" name="father_fio" id="father_fio" class="form-control"
                                placeholder="Otasi FIO">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="mother_fio col-md-6">Onasi FIO</label>
                            <input type="text" name="mother_fio" id="mother_fio" class="form-control"
                                placeholder="Onasi FIO">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="father_phone">Otasi telefon raqami</label>
                            <input type="text" name="father_phone" id="father_phone" class="form-control"
                                placeholder="Otasi telefon raqami">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="mother_phone">Onasi telefon raqami</label>
                            <input type="text" name="mother_phone" id="mother_phone" class="form-control"
                                placeholder="Onasi telefon raqami">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="telegram_id">Telegram ID</label>
                            <input type="text" name="telegram_id" id="telegram_id" class="form-control"
                                placeholder="Telegram ID">
                        </div>

                        <div class="form-group col-md-12">
                            <label>Guruhlar</label>
                            <div id="groups-container">
                                <div class="row mb-3 group-row">
                                    <div class="col-md-6">
                                        <select name="groups[0][id]" class="form-control group-select" required>
                                            <option selected disabled value="">-- Guruhni tanlang --</option>
                                            @foreach ($groups as $group)
                                                <option value="{{ $group->id }}">{{ $group->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="date" name="groups[0][start_date]" class="form-control" required>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger remove-group">-</button>
                                    </div>
                                </div>
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
        let groupIndex = 1;
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
