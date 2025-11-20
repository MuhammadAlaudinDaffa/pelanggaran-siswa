@extends('layout.main')
@section('title', 'Dashboard Orang Tua')
@section('content')
    @if(isset($error))
        <div class="alert alert-danger">{{ $error }}</div>
    @else
        <!-- Welcome Card -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h4 class="card-title text-white mb-2">Selamat Datang, {{ Auth::user()->name }}</h4>
                        <p class="card-text mb-0">Dashboard Orang Tua</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Student Data Card -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-light">
                    <div class="card-header bg-light text-white">
                        <h5 class="card-title mb-0"><i class="ti ti-user me-2"></i>Data Siswa Anda</h5>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-3 text-center">
                                @if($siswa->foto)
                                    <img src="{{ asset('storage/' . $siswa->foto) }}" alt="Foto {{ $siswa->nama_siswa }}" 
                                         class="rounded-circle border border-info" style="width: 120px; height: 120px; object-fit: cover;">
                                @else
                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto" 
                                         style="width: 120px; height: 120px; border: 2px solid #0dcaf0;">
                                        <i class="ti ti-user text-info" style="font-size: 48px;"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-9">
                                <h3 class="text-info mb-3">{{ $siswa->nama_siswa }}</h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-2"><strong>NIS:</strong> {{ $siswa->nis }}</p>
                                        @if($siswa->nisn)
                                            <p class="mb-2"><strong>NISN:</strong> {{ $siswa->nisn }}</p>
                                        @endif
                                        <p class="mb-2"><strong>Kelas:</strong> 
                                            <span class="badge bg-info">{{ $siswa->kelas->nama_kelas ?? '-' }}</span>
                                        </p>
                                        @if($siswa->kelas && $siswa->kelas->jurusan)
                                            <p class="mb-2"><strong>Jurusan:</strong> {{ $siswa->kelas->jurusan->nama_jurusan }}</p>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        @if($siswa->jenis_kelamin)
                                            <p class="mb-2"><strong>Jenis Kelamin:</strong> {{ ucfirst($siswa->jenis_kelamin) }}</p>
                                        @endif
                                        @if($siswa->tempat_lahir && $siswa->tanggal_lahir)
                                            <p class="mb-2"><strong>TTL:</strong> {{ $siswa->tempat_lahir }}, {{ date('d F Y', strtotime($siswa->tanggal_lahir)) }}</p>
                                        @elseif($siswa->tanggal_lahir)
                                            <p class="mb-2"><strong>Tanggal Lahir:</strong> {{ date('d F Y', strtotime($siswa->tanggal_lahir)) }}</p>
                                        @endif
                                        @if($siswa->no_telp)
                                            <p class="mb-2"><strong>No. Telepon:</strong> {{ $siswa->no_telp }}</p>
                                        @endif
                                        @if($siswa->alamat)
                                            <p class="mb-2"><strong>Alamat:</strong> {{ $siswa->alamat }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold mb-4">Aksi Cepat</h5>
                        <div class="row">
                            <div class="col-lg-3 col-md-6 mb-3">
                                <a href="{{ route('orang_tua.kesiswaan.siswa_overview.show', Auth::id()) }}" class="btn btn-outline-info w-100 d-flex align-items-center justify-content-center" style="height: 60px;">
                                    <i class="ti ti-user me-2 fs-5"></i>
                                    <span>Profil Anak</span>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <a href="{{ route('orang_tua.kesiswaan.pelanggaran.index') }}" class="btn btn-outline-danger w-100 d-flex align-items-center justify-content-center" style="height: 60px;">
                                    <i class="ti ti-alert-triangle me-2 fs-5"></i>
                                    <span>Pelanggaran</span>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <a href="{{ route('orang_tua.kesiswaan.prestasi.index') }}" class="btn btn-outline-success w-100 d-flex align-items-center justify-content-center" style="height: 60px;">
                                    <i class="ti ti-trophy me-2 fs-5"></i>
                                    <span>Prestasi</span>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 zoom-in bg-light-danger shadow-none">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="bg-danger rounded-circle p-6 d-flex align-items-center justify-content-center">
                                <i class="ti ti-alert-triangle fs-6 text-white"></i>
                            </div>
                            <div class="ms-3">
                                <span class="text-muted d-block">Total Pelanggaran</span>
                                <h4 class="mb-0 fw-semibold">{{ $pelanggaranStats['total'] }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 zoom-in bg-light-warning shadow-none">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="bg-warning rounded-circle p-6 d-flex align-items-center justify-content-center">
                                <i class="ti ti-minus fs-6 text-white"></i>
                            </div>
                            <div class="ms-3">
                                <span class="text-muted d-block">Poin Pelanggaran</span>
                                <h4 class="mb-0 fw-semibold">{{ $pelanggaranStats['poin'] ?? 0 }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 zoom-in bg-light-success shadow-none">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="bg-success rounded-circle p-6 d-flex align-items-center justify-content-center">
                                <i class="ti ti-trophy fs-6 text-white"></i>
                            </div>
                            <div class="ms-3">
                                <span class="text-muted d-block">Total Prestasi</span>
                                <h4 class="mb-0 fw-semibold">{{ $prestasiStats['total'] }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 zoom-in bg-light-info shadow-none">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="bg-info rounded-circle p-6 d-flex align-items-center justify-content-center">
                                <i class="ti ti-plus fs-6 text-white"></i>
                            </div>
                            <div class="ms-3">
                                <span class="text-muted d-block">Poin Prestasi</span>
                                <h4 class="mb-0 fw-semibold">{{ $prestasiStats['poin'] ?? 0 }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    @endif
@endsection