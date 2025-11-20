@extends('layout.main')
@section('title', 'Akses Ditolak')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body text-center p-5">
                <div class="mb-4">
                    <i class="ti ti-shield-x" style="font-size: 4rem; color: #dc3545;"></i>
                </div>
                <h3 class="card-title text-danger mb-3">Akses Ditolak</h3>
                <p class="card-text mb-4">
                    Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.
                </p>
                @auth
                    @php
                        $dashboardRoute = match(auth()->user()->level) {
                            'admin' => 'admin.index',
                            'kepala_sekolah' => 'kepala_sekolah.index',
                            'kesiswaan' => 'kesiswaan.index',
                            'bimbingan_konseling' => 'bimbingan_konseling.index',
                            'guru' => 'guru.index',
                            'orang_tua' => 'orang_tua.index',
                            'siswa' => 'siswa.index',
                            default => 'role.selection'
                        };
                    @endphp
                    <a href="{{ route($dashboardRoute) }}" class="btn btn-primary">
                        <i class="ti ti-home"></i>
                        Kembali ke Dashboard
                    </a>
                @else
                    <a href="{{ route('role.selection') }}" class="btn btn-primary">
                        <i class="ti ti-login"></i>
                        Login
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection