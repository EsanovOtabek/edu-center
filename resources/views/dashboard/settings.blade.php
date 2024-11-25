@extends('layout.dashboard')

@section('content-name', 'Sozlamalar')
@section('title', 'Foydalanuvchi Sozlamalari')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Sozlamalarni yangilash</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.settings.update') }}" method="POST">
                        @csrf

                        <!-- Login -->
                        <div class="form-group">
                            <label for="login">Login</label>
                            <input type="text" name="login" id="login" class="form-control"
                                value="{{ old('login', auth()->user()->login) }}" required>
                        </div>

                        <!-- Eski Parol -->
                        <div class="form-group">
                            <label for="current_password">Eski Parol</label>
                            <input type="password" name="current_password" id="current_password" class="form-control"
                                required>
                        </div>

                        <!-- Yangi Parol -->
                        <div class="form-group">
                            <label for="new_password">Yangi Parol</label>
                            <input type="password" name="new_password" id="new_password" class="form-control" required>
                        </div>

                        <!-- Yangi Parolni Tasdiqlash -->
                        <div class="form-group">
                            <label for="new_password_confirmation">Yangi Parolni Tasdiqlash</label>
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                                class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Yangilash</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
