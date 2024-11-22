@extends('layout.dashboard')

@section('content-name', $teacher->fio . " ma'lumotlarini tahrirlash")


@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">O'qituvchini tahrirlash</h3>
                </div>

                <form method="POST" action="{{ route('admin.teachers.update', $teacher->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') <!-- PUT metodini aniqlash uchun -->
                    <div class="card-body row">
                        <div class="form-group col-md-6">
                            <label for="fio">To'liq ism</label>
                            <input type="text" name="fio" id="fio" class="form-control" required value="{{ $teacher->fio }}" placeholder="F.I.Sh">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="passport_number">Pasport nomeri</label>
                            <input type="text" name="passport_number" id="passport_number" class="form-control" required value="{{  $teacher->passport_number }}" placeholder="AAXXXXXXX">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="phone">Telefon raqami</label>
                            <input type="text" name="phone" id="phone" class="form-control" required value="{{  $teacher->phone }}" placeholder="+998XXYYYYYYY">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="salary_percentage">Oylik foiz</label>
                            <input type="number" name="salary_percentage" id="salary_percentage" class="form-control" required min="0" max="100" value="{{ $teacher->salary_percentage }}" placeholder="0">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="password">Parolni o'zgartirish <span class="badge badge-danger">(Agar o'zgartirishni xohlamasangiz bo'sh qoldiring)</span></label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="password">
                        </div>

                        <!-- Subjects Selection -->
                        <div class="form-group col-md-6">
                            <label for="subjects">Darslar</label>
                            <select name="subjects[]" class="select2" multiple="multiple" data-placeholder="Fanlarni tanlash" style="width: 100%;" required>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}" {{ in_array($subject->id, $teacher->subjects->pluck('id')->toArray()) ? 'selected' : '' }}>
                                        {{ $subject->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="image">Rasm yuklash (Drag & Drop)</label>
                            <div id="dropZone" class="drag-drop-zone">
                                <p>Rasmni bu yerga tashlang yoki ustiga bosib yuklang</p>
                                <h1><i class="fa fa-image"></i><i class="fa fa-finger"></i></h1>
                                <input type="file" name="image" id="imageInput" class="form-control d-none" accept="image/*">
                            </div>
                        </div>

                        <!-- Existing Image Preview -->
                        @if($teacher->image)
                            <div class="form-group col-md-3">
                                <label>Joriy rasm:</label>
                                <div>
                                    <img id="imagePreview" src="{{ asset('storage/' . $teacher->image) }}" alt="O'qituvchi rasmi" class="img-thumbnail" style="max-width: 200px;">
                                </div>
                            </div>
                        @else
                            <div class="form-group col-md-3">
                                <label>Tanlangan rasm:</label>
                                <div>
                                    <img id="imagePreview" src="#" alt="Tanlangan rasm" class="img-thumbnail" style="max-width: 200px; display: none;">
                                </div>
                            </div>
                        @endif


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

    <style>
        .drag-drop-zone {
            border: 2px dashed #007bff;
            padding: 20px;
            height: 200px;
            text-align: center;
            color: #555;
            cursor: pointer;
            border-radius: 10px;
            transition: border-color 0.3s ease-in-out, background-color 0.3s ease-in-out;
        }
        .drag-drop-zone:hover {
            border-color: #0056b3;
        }
        .drag-drop-zone.drag-over {
            background-color: #f0f8ff;
            border-color: #007bff;
        }

    </style>
@endpush

@push('scripts')
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $('.select2').select2();
        document.addEventListener('DOMContentLoaded', function () {
            const dropZone = document.getElementById('dropZone');
            const fileInput = document.getElementById('imageInput');
            const imagePreview = document.getElementById('imagePreview');

            // Drag & Drop Events
            dropZone.addEventListener('dragover', (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropZone.classList.add('drag-over');
            });

            dropZone.addEventListener('dragleave', (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropZone.classList.remove('drag-over');
            });

            dropZone.addEventListener('drop', (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropZone.classList.remove('drag-over');

                const files = e.dataTransfer.files;
                if (files.length) {
                    fileInput.files = files;
                    previewImage(files[0]);
                }
            });

            // Click Event to Open File Dialog
            dropZone.addEventListener('click', () => fileInput.click());

            // Change Event for File Input
            fileInput.addEventListener('change', (e) => {
                const file = e.target.files[0];
                if (file) {
                    previewImage(file);
                }
            });

            // Preview the Image
            function previewImage(file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });

    </script>
@endpush
