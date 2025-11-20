@extends('layout.main')

@section('title', 'Dashboard Kesiswaan')

@section('content')
<div class="row">
    <!-- Pelanggaran Card -->
    <div class="col-lg-6 col-md-12 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="p-2 bg-danger-subtle rounded-circle me-3">
                        <i class="ti ti-alert-triangle fs-4 text-danger"></i>
                    </div>
                    <div>
                        <h5 class="card-title mb-0">Pelanggaran</h5>
                        <h2 class="text-danger mb-0">{{ $totalPelanggaran }}</h2>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-6">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Menunggu:</span>
                            <span class="badge bg-warning">{{ $pelanggaranMenunggu }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Diverifikasi:</span>
                            <span class="badge bg-success">{{ $pelanggaranDiverifikasi }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Revisi:</span>
                            <span class="badge bg-info">{{ $pelanggaranRevisi }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Ditolak:</span>
                            <span class="badge bg-danger">{{ $pelanggaranDitolak }}</span>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('kesiswaan.kesiswaan.pelanggaran.index') }}" class="btn btn-danger btn-sm w-100">
                        <i class="ti ti-eye me-1"></i> Kelola Pelanggaran
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Prestasi Card -->
    <div class="col-lg-6 col-md-12 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="p-2 bg-success-subtle rounded-circle me-3">
                        <i class="ti ti-trophy fs-4 text-success"></i>
                    </div>
                    <div>
                        <h5 class="card-title mb-0">Prestasi</h5>
                        <h2 class="text-success mb-0">{{ $totalPrestasi }}</h2>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-6">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Menunggu:</span>
                            <span class="badge bg-warning">{{ $prestasiMenunggu }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Diverifikasi:</span>
                            <span class="badge bg-success">{{ $prestasiDiverifikasi }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Revisi:</span>
                            <span class="badge bg-info">{{ $prestasiRevisi }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Ditolak:</span>
                            <span class="badge bg-danger">{{ $prestasiDitolak }}</span>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('kesiswaan.kesiswaan.prestasi.index') }}" class="btn btn-success btn-sm w-100">
                        <i class="ti ti-eye me-1"></i> Kelola Prestasi
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection