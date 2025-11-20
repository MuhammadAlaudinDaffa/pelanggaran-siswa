@extends('layout.main')
@section('title', 'Dashboard Siswa')
@section('content')
    @if(isset($error))
        <div class="alert alert-danger">{{ $error }}</div>
    @else
        <!-- Student Profile Card -->
        <div class="row">
            <div class="col-12">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-3 text-center">
                                @if($siswa->foto)
                                    <img src="{{ asset('storage/' . $siswa->foto) }}" alt="Foto {{ $siswa->nama_siswa }}" 
                                         class="rounded-circle border border-white" style="width: 120px; height: 120px; object-fit: cover;">
                                @else
                                    <div class="rounded-circle bg-white d-flex align-items-center justify-content-center mx-auto" 
                                         style="width: 120px; height: 120px;">
                                        <i class="ti ti-user text-primary" style="font-size: 48px;"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-9">
                                <h3 class="text-white mb-2">{{ $siswa->nama_siswa }}</h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-1"><strong>NIS:</strong> {{ $siswa->nis }}</p>
                                        @if($siswa->nisn)
                                            <p class="mb-1"><strong>NISN:</strong> {{ $siswa->nisn }}</p>
                                        @endif
                                        <p class="mb-1"><strong>Kelas:</strong> 
                                            <span class="badge bg-light text-primary">{{ $siswa->kelas->nama_kelas ?? '-' }}</span>
                                        </p>
                                        @if($siswa->kelas && $siswa->kelas->jurusan)
                                            <p class="mb-1"><strong>Jurusan:</strong> {{ $siswa->kelas->jurusan->nama_jurusan }}</p>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        @if($siswa->jenis_kelamin)
                                            <p class="mb-1"><strong>Jenis Kelamin:</strong> {{ ucfirst($siswa->jenis_kelamin) }}</p>
                                        @endif
                                        @if($siswa->tempat_lahir && $siswa->tanggal_lahir)
                                            <p class="mb-1"><strong>TTL:</strong> {{ $siswa->tempat_lahir }}, {{ date('d F Y', strtotime($siswa->tanggal_lahir)) }}</p>
                                        @elseif($siswa->tanggal_lahir)
                                            <p class="mb-1"><strong>Tanggal Lahir:</strong> {{ date('d F Y', strtotime($siswa->tanggal_lahir)) }}</p>
                                        @endif
                                        @if($siswa->no_telp)
                                            <p class="mb-1"><strong>No. Telepon:</strong> {{ $siswa->no_telp }}</p>
                                        @endif
                                        @if($siswa->alamat)
                                            <p class="mb-1"><strong>Alamat:</strong> {{ $siswa->alamat }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <!-- Pelanggaran Card -->
            <div class="col-md-4">
                <div class="card border-danger">
                    <div class="card-body text-center">
                        <i class="ti ti-alert-triangle fs-1 text-danger mb-2"></i>
                        <h5 class="card-title text-danger">Pelanggaran</h5>
                        <h2 class="text-danger">{{ $pelanggaranStats['total'] }}</h2>
                        <p class="card-text">Total Poin: <span class="badge bg-danger">{{ $pelanggaranStats['poin'] }}</span></p>
                    </div>
                </div>
            </div>

            <!-- Prestasi Card -->
            <div class="col-md-4">
                <div class="card border-success">
                    <div class="card-body text-center">
                        <i class="ti ti-trophy fs-1 text-success mb-2"></i>
                        <h5 class="card-title text-success">Prestasi</h5>
                        <h2 class="text-success">{{ $prestasiStats['total'] }}</h2>
                        <p class="card-text">Total Poin: <span class="badge bg-success">{{ $prestasiStats['poin'] }}</span></p>
                    </div>
                </div>
            </div>

            <!-- BK Card -->
            <div class="col-md-4">
                <div class="card border-info">
                    <div class="card-body text-center">
                        <i class="ti ti-messages fs-1 text-info mb-2"></i>
                        <h5 class="card-title text-info">Bimbingan Konseling</h5>
                        <h2 class="text-info">{{ $bkStats['total'] }}</h2>
                        <div class="d-flex justify-content-center gap-1 flex-wrap">
                            @if($bkStats['menunggu'] > 0)
                                <span class="badge bg-warning">{{ $bkStats['menunggu'] }} Menunggu</span>
                            @endif
                            @if($bkStats['berkelanjutan'] > 0)
                                <span class="badge bg-primary">{{ $bkStats['berkelanjutan'] }} Berkelanjutan</span>
                            @endif
                            @if($bkStats['tindak_lanjut'] > 0)
                                <span class="badge bg-info">{{ $bkStats['tindak_lanjut'] }} Tindak Lanjut</span>
                            @endif
                            @if($bkStats['selesai'] > 0)
                                <span class="badge bg-success">{{ $bkStats['selesai'] }} Selesai</span>
                            @endif
                            @if($bkStats['ditolak'] > 0)
                                <span class="badge bg-danger">{{ $bkStats['ditolak'] }} Ditolak</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Aksi Cepat</h5>
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.siswa_overview.show', Auth::id()) }}" class="btn btn-primary">
                                <i class="ti ti-user me-2"></i>Lihat Data Lengkap
                            </a>
                            <a href="{{ route('siswa.bimbingan_konseling.bk.index') }}" class="btn btn-info">
                                <i class="ti ti-messages me-2"></i>Bimbingan Konseling
                            </a>
                            <a href="{{ route('siswa.bimbingan_konseling.bk.create') }}" class="btn btn-success">
                                <i class="ti ti-plus me-2"></i>Buat Keluhan BK
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection