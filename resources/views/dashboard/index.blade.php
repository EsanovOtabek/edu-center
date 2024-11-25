@extends('layout.dashboard')

@section('title', 'Bosh sahifa')

@section('content-name', 'Bosh sahifa')

@section('content')
    <div class="row">
        <!-- O'qituvchilar -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $teacher_cnt }}</h3>
                    <p>O'qituvchilar soni</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person"></i>
                </div>
                <a href="#" class="small-box-footer">Batafsil <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- Talabalar -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $student_cnt }}</h3>
                    <p>Talabalar soni</p>
                </div>
                <div class="icon">
                    <i class="ion ion-android-people"></i>
                </div>
                <a href="#" class="small-box-footer">Batafsil <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- Fanlar -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $subject_cnt }}</h3>
                    <p>Fanlar soni</p>
                </div>
                <div class="icon">
                    <i class="ion ion-ios-book"></i>
                </div>
                <a href="#" class="small-box-footer">Batafsil <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- Guruhlar -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $group_cnt }}</h3>
                    <p>Guruhlar soni</p>
                </div>
                <div class="icon">
                    <i class="ion ion-ios-people"></i>
                </div>
                <a href="#" class="small-box-footer">Batafsil <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- Xonalar -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $room_cnt }}</h3>
                    <p>Xonalar soni</p>
                </div>
                <div class="icon">
                    <i class="ion ion-home"></i>
                </div>
                <a href="#" class="small-box-footer">Batafsil <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
@endsection


@push('styles')
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
@endpush
