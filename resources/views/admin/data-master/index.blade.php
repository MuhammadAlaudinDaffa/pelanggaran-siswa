@extends('layout.main')

@section('title', 'Data Master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Data Master</h5>
                    <div class="row">
                        <!-- Guru -->
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        <i class="ti ti-school fs-1 text-primary"></i>
                                    </div>
                                    <h6 class="card-title">Guru</h6>
                                    <h3 class="text-primary">{{ $guruCount }}</h3>
                                    <a href="{{ route('admin.data-master.guru-management.index') }}" class="btn btn-primary btn-sm">Kelola</a>
                                </div>
                            </div>
                        </div>

                        <!-- Siswa -->
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        <i class="ti ti-users fs-1 text-success"></i>
                                    </div>
                                    <h6 class="card-title">Siswa</h6>
                                    <h3 class="text-success">{{ $siswaCount }}</h3>
                                    <a href="{{ route('admin.data-master.siswa.index') }}" class="btn btn-success btn-sm">Kelola</a>
                                </div>
                            </div>
                        </div>

                        <!-- Kelas -->
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        <i class="ti ti-chalkboard fs-1 text-warning"></i>
                                    </div>
                                    <h6 class="card-title">Kelas</h6>
                                    <h3 class="text-warning">{{ $kelasCount }}</h3>
                                    <a href="{{ route('admin.data-master.kelas.index') }}" class="btn btn-warning btn-sm">Kelola</a>
                                </div>
                            </div>
                        </div>

                        <!-- Tahun Ajaran -->
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        <i class="ti ti-calendar fs-1 text-secondary"></i>
                                    </div>
                                    <h6 class="card-title">Tahun Ajaran</h6>
                                    <h3 class="text-secondary">{{ $tahunAjaranCount }}</h3>
                                    <a href="{{ route('admin.data-master.tahun-ajaran.index') }}" class="btn btn-secondary btn-sm">Kelola</a>
                                </div>
                            </div>
                        </div>

                        <!-- Jenis Pelanggaran -->
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        <i class="ti ti-alert-circle fs-1 text-warning"></i>
                                    </div>
                                    <h6 class="card-title">Jenis Pelanggaran</h6>
                                    <h3 class="text-warning">{{ $jenisPelanggaranCount }}</h3>
                                    <a href="{{ route('admin.data-master.jenis-pelanggaran.index') }}" class="btn btn-warning btn-sm">Kelola</a>
                                </div>
                            </div>
                        </div>

                        <!-- Jenis Prestasi -->
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        <i class="ti ti-award fs-1 text-primary"></i>
                                    </div>
                                    <h6 class="card-title">Jenis Prestasi</h6>
                                    <h3 class="text-primary">{{ $jenisPrestasiCount }}</h3>
                                    <a href="{{ route('admin.data-master.jenis-prestasi.index') }}" class="btn btn-primary btn-sm">Kelola</a>
                                </div>
                            </div>
                        </div>

                        <!-- User -->
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        <i class="ti ti-user fs-1 text-dark"></i>
                                    </div>
                                    <h6 class="card-title">User</h6>
                                    <h3 class="text-dark">{{ $userCount }}</h3>
                                    <a href="{{ route('admin.data-master.user.index') }}" class="btn btn-dark btn-sm">Kelola</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection