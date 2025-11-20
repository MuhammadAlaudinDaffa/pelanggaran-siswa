@extends('layout.main')
@section('title', 'Dashboard Orang Tua')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Selamat Datang {{ Auth::user()->name }}</h4>
                    <p class="card-text">Anda login sebagai Orang Tua</p>
                </div>
            </div>
        </div>
    </div>
@endsection