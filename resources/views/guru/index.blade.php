@extends('layout.main')
@section('title', 'Dashboard Guru')
@section('content')
    @if(isset($noGuruData) && $noGuruData)
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="ti ti-user-exclamation fs-1 text-warning mb-3"></i>
                        <h5 class="text-warning mb-3">Data Guru Tidak Ditemukan</h5>
                        <p class="text-muted">Anda tidak termasuk dari data guru, komunikasikan dengan admin aplikasi untuk bantuan lebih lanjut</p>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Selamat Datang {{ Auth::user()->name }}</h4>
                        <p class="card-text">Anda login sebagai Guru
                            @if($isWaliKelas)
                                - Wali Kelas {{ $kelas->nama_kelas }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        @if($isWaliKelas)
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="ti ti-users fs-1 text-primary"></i>
                                </div>
                                <div>
                                    <h3 class="mb-0">{{ $classStats['total_siswa'] }}</h3>
                                    <p class="text-muted mb-0">Total Siswa</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="ti ti-alert-triangle fs-1 text-warning"></i>
                                </div>
                                <div>
                                    <h3 class="mb-0">{{ $classStats['siswa_melanggar'] }}</h3>
                                    <p class="text-muted mb-0">Siswa Melanggar</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="ti ti-x fs-1 text-danger"></i>
                                </div>
                                <div>
                                    <h3 class="mb-0">{{ $classStats['total_pelanggaran'] }}</h3>
                                    <p class="text-muted mb-0">Total Pelanggaran</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="ti ti-trophy fs-1 text-success"></i>
                                </div>
                                <div>
                                    <h3 class="mb-0">{{ $classStats['total_prestasi'] }}</h3>
                                    <p class="text-muted mb-0">Total Prestasi</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif
@endsection