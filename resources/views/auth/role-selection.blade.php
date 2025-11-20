@extends('auth.auth-layout.main')
@section('title', 'Pilih Role')
@section('form')
    <p class="text-center mb-4">Pilih Role Anda</p>
    @if (session('error'))
        <div class="alert alert-danger" role="alert">
            <strong>{{ session('error') }}</strong>
        </div>
    @endif
    
    <!-- Staff Sekolah -->
    <div class="mb-4">
        <h6 class="text-muted mb-3"><i class="ti ti-building"></i> Staff Sekolah</h6>
        <div class="row g-3">
            <div class="col-12">
                <a href="{{ route('staff.login') }}" class="btn btn-primary w-100 py-3 text-center">
                    <div class="fw-bold"><i class="ti ti-login"></i> Login Staff Sekolah</div>
                    <small class="d-block text-white-50">Admin, Kepala Sekolah, Kesiswaan, BK, Guru</small>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Non-Staff Sekolah -->
    <div class="mb-4">
        <h6 class="text-muted mb-3"><i class="ti ti-users"></i> Siswa & Orang Tua</h6>
        <div class="row g-3">
            <div class="col-6">
                <a href="{{ route('login', ['role' => 'orang_tua']) }}" class="btn btn-outline-success w-100 py-3 text-center">
                    <div class="fw-bold">Orang Tua</div>
                </a>
            </div>
            <div class="col-6">
                <a href="{{ route('login', ['role' => 'siswa']) }}" class="btn btn-outline-success w-100 py-3 text-center">
                    <div class="fw-bold">Siswa</div>
                </a>
            </div>
        </div>
    </div>
@endsection