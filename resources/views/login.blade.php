@extends('layout.auth')

@section('title',"Tizimga kirish")

@section('content')
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="{{route('index')}}" class="h1"><b>Edu</b>Center</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Tizimga kirish</p>

                <form action="{{ route('login') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" name="login" class="form-control" placeholder="Login" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </div>
                    </div>
                    <hr>

                </form>

                <p class="mb-1">
                    <a href="tel:+998(93)2360433">Admin bilan bog'lanish</a>
                </p>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
@endsection
