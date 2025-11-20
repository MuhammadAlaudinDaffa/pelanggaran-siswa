@extends('layout.main')
@section('title', 'Dashboard Kepala Sekolah')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Selamat Datang {{ Auth::user()->name }}</h4>
                    <p class="card-text">Anda login sebagai Kepala Sekolah</p>
                </div>
            </div>
        </div>
    </div>
@endsection