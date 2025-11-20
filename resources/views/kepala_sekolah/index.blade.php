@extends('layout.main')
@section('title', 'Dashboard Kepala Sekolah')
@section('content')
    <!-- Welcome Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h4 class="card-title text-white mb-1">Selamat Datang, {{ Auth::user()->name }}</h4>
                    <p class="card-text mb-0">Dashboard Kepala Sekolah - Monitoring Sistem Pelanggaran dan Prestasi</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards Row 1 -->
    <div class="row justify-content-center">
        <!-- Overview Siswa Card -->
        <div class="col-xl-4 col-md-6 col-12 mb-4">
            <div class="card h-100 d-flex flex-column">
                <div class="card-body text-center flex-grow-1">
                    <div class="p-3 bg-primary-subtle rounded-circle d-inline-flex mb-3">
                        <i class="ti ti-users fs-1 text-primary"></i>
                    </div>
                    <h5 class="card-title mb-1">Total Siswa</h5>
                    <h2 class="text-primary mb-0">{{ $totalSiswa }}</h2>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <a href="{{ route('kepala_sekolah.kesiswaan.siswa_overview.index') }}" class="btn btn-primary btn-sm w-100">
                        <i class="ti ti-eye me-1"></i> Lihat Overview
                    </a>
                </div>
            </div>
        </div>

        <!-- Pelanggaran Card -->
        <div class="col-xl-4 col-md-6 col-12 mb-4">
            <div class="card h-100 d-flex flex-column">
                <div class="card-body flex-grow-1">
                    <div class="text-center mb-3">
                        <div class="p-3 bg-danger-subtle rounded-circle d-inline-flex mb-2">
                            <i class="ti ti-alert-triangle fs-1 text-danger"></i>
                        </div>
                        <h5 class="card-title mb-1">Pelanggaran</h5>
                        <h2 class="text-danger mb-0">{{ $totalPelanggaran }}</h2>
                    </div>
                    <div class="row g-2">
                        <div class="col-6">
                            <div class="text-center p-2 bg-light rounded">
                                <span class="badge bg-warning mb-1">{{ $pelanggaranMenunggu }}</span>
                                <div class="text-muted small">Menunggu</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center p-2 bg-light rounded">
                                <span class="badge bg-success mb-1">{{ $pelanggaranDiverifikasi }}</span>
                                <div class="text-muted small">Diverifikasi</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <a href="{{ route('kepala_sekolah.kesiswaan.pelanggaran.index') }}" class="btn btn-danger btn-sm w-100">
                        <i class="ti ti-eye me-1"></i> Lihat Data
                    </a>
                </div>
            </div>
        </div>

        <!-- Prestasi Card -->
        <div class="col-xl-4 col-md-6 col-12 mb-4">
            <div class="card h-100 d-flex flex-column">
                <div class="card-body flex-grow-1">
                    <div class="text-center mb-3">
                        <div class="p-3 bg-success-subtle rounded-circle d-inline-flex mb-2">
                            <i class="ti ti-trophy fs-1 text-success"></i>
                        </div>
                        <h5 class="card-title mb-1">Prestasi</h5>
                        <h2 class="text-success mb-0">{{ $totalPrestasi }}</h2>
                    </div>
                    <div class="row g-2">
                        <div class="col-6">
                            <div class="text-center p-2 bg-light rounded">
                                <span class="badge bg-warning mb-1">{{ $prestasiMenunggu }}</span>
                                <div class="text-muted small">Menunggu</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center p-2 bg-light rounded">
                                <span class="badge bg-success mb-1">{{ $prestasiDiverifikasi }}</span>
                                <div class="text-muted small">Diverifikasi</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <a href="{{ route('kepala_sekolah.kesiswaan.prestasi.index') }}" class="btn btn-success btn-sm w-100">
                        <i class="ti ti-eye me-1"></i> Lihat Data
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards Row 2 -->
    <div class="row justify-content-center">
        <!-- Sanksi Card -->
        <div class="col-xl-4 col-md-6 col-12 mb-4">
            <div class="card h-100 d-flex flex-column">
                <div class="card-body flex-grow-1">
                    <div class="text-center mb-3">
                        <div class="p-3 bg-warning-subtle rounded-circle d-inline-flex mb-2">
                            <i class="ti ti-gavel fs-1 text-warning"></i>
                        </div>
                        <h5 class="card-title mb-1">Sanksi</h5>
                        <h2 class="text-warning mb-0">{{ $totalSanksi }}</h2>
                    </div>
                    <div class="row g-2">
                        <div class="col-6">
                            <div class="text-center p-2 bg-light rounded">
                                <span class="badge bg-warning mb-1">{{ $sanksiAktif }}</span>
                                <div class="text-muted small">Aktif</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center p-2 bg-light rounded">
                                <span class="badge bg-success mb-1">{{ $sanksiSelesai }}</span>
                                <div class="text-muted small">Selesai</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <a href="{{ route('kepala_sekolah.kesiswaan.sanksi.index') }}" class="btn btn-warning btn-sm w-100">
                        <i class="ti ti-eye me-1"></i> Lihat Data
                    </a>
                </div>
            </div>
        </div>

        <!-- Pelaksanaan Sanksi Card -->
        <div class="col-xl-4 col-md-6 col-12 mb-4">
            <div class="card h-100 d-flex flex-column">
                <div class="card-body flex-grow-1">
                    <div class="text-center mb-3">
                        <div class="p-3 bg-info-subtle rounded-circle d-inline-flex mb-2">
                            <i class="ti ti-clipboard-check fs-1 text-info"></i>
                        </div>
                        <h5 class="card-title mb-1">Pelaksanaan Sanksi</h5>
                        <h2 class="text-info mb-0">{{ $totalPelaksanaanSanksi }}</h2>
                    </div>
                    <div class="row g-2">
                        <div class="col-6">
                            <div class="text-center p-2 bg-light rounded">
                                <span class="badge bg-warning mb-1">{{ $pelaksanaanMenunggu }}</span>
                                <div class="text-muted small">Menunggu</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center p-2 bg-light rounded">
                                <span class="badge bg-success mb-1">{{ $pelaksanaanTuntas }}</span>
                                <div class="text-muted small">Tuntas</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <a href="{{ route('kepala_sekolah.kesiswaan.pelaksanaan_sanksi.index') }}" class="btn btn-info btn-sm w-100">
                        <i class="ti ti-eye me-1"></i> Lihat Data
                    </a>
                </div>
            </div>
        </div>

        <!-- Monitoring Pelanggaran Card -->
        <div class="col-xl-4 col-md-6 col-12 mb-4">
            <div class="card h-100 d-flex flex-column">
                <div class="card-body text-center flex-grow-1">
                    <div class="p-3 bg-secondary-subtle rounded-circle d-inline-flex mb-3">
                        <i class="ti ti-eye fs-1 text-secondary"></i>
                    </div>
                    <h5 class="card-title mb-1">Monitoring</h5>
                    <p class="text-muted mb-0">Pelanggaran Siswa</p>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <a href="{{ route('kepala_sekolah.kesiswaan.monitoring_pelanggaran.index') }}" class="btn btn-secondary btn-sm w-100">
                        <i class="ti ti-eye me-1"></i> Lihat Monitoring
                    </a>
                </div>
            </div>
        </div>
    </div>

    @php
        $guru = \App\Models\Guru::where('user_id', Auth::id())->first();
    @endphp
    @if($guru)
        <!-- Additional Row for Guru Functions -->
        <div class="row justify-content-center">
            <!-- Info Kelas Card -->
            <div class="col-xl-4 col-md-6 col-12 mb-4">
                <div class="card h-100 d-flex flex-column">
                    <div class="card-body text-center flex-grow-1">
                        <div class="p-3 bg-primary-subtle rounded-circle d-inline-flex mb-3">
                            <i class="ti ti-message-circle fs-1 text-primary"></i>
                        </div>
                        <h5 class="card-title mb-1">Informasi Kelas</h5>
                        <p class="text-muted mb-0">Kelola Info Kelas</p>
                    </div>
                    <div class="card-footer bg-transparent border-0 pt-0">
                        <a href="{{ route('kepala_sekolah.guru.info_kelas.index') }}" class="btn btn-primary btn-sm w-100">
                            <i class="ti ti-message-circle me-1"></i> Kelola Info
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection