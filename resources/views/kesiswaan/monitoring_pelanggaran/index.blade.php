@extends('layout.main')

@section('title', 'Monitoring Pelanggaran')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-warning text-white">
                <div class="card-body text-center py-4">
                    <h4 class="card-title text-white mb-3">Monitoring Pelanggaran Siswa</h4>
                    <p class="card-text mb-4">Pantau dan tindak lanjuti pelanggaran siswa yang telah diverifikasi</p>
                    <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.monitoring_pelanggaran.create') }}"
                        class="btn btn-light btn-lg">
                        <i class="ti ti-plus me-2"></i> Buat Monitoring
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title fw-semibold mb-0">Data Monitoring Pelanggaran</h5>
                    </div>

                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">No</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Siswa</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Jenis Pelanggaran</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Status Monitoring</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Tanggal Monitoring</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Kepala Sekolah</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Aksi</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($monitoring as $index => $item)
                                    <tr>
                                        <td class="border-bottom-0">{{ $monitoring->firstItem() + $index }}</td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">{{ $item->pelanggaran->siswa->nama_siswa }}</h6>
                                            <span class="fw-normal">{{ $item->pelanggaran->siswa->nis }}</span>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-1">{{ $item->pelanggaran->jenisPelanggaran->nama_pelanggaran }}</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            @if($item->status_monitoring === 'dipantau')
                                                <span class="badge bg-info rounded-3 fw-semibold">Dipantau</span>
                                            @elseif($item->status_monitoring === 'tindak_lanjut')
                                                <span class="badge bg-warning rounded-3 fw-semibold">Tindak Lanjut</span>
                                            @elseif($item->status_monitoring === 'progres_baik')
                                                <span class="badge bg-primary rounded-3 fw-semibold">Progres Baik</span>
                                            @elseif($item->status_monitoring === 'selesai')
                                                <span class="badge bg-success rounded-3 fw-semibold">Selesai</span>
                                            @else
                                                <span class="badge bg-danger rounded-3 fw-semibold">Eskalasi</span>
                                            @endif
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-normal">
                                                {{ \Carbon\Carbon::parse($item->tanggal_monitoring)->format('d/m/Y') }}
                                            </p>
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-normal">{{ $item->guruKepsek->nama_guru }}</p>
                                        </td>
                                        <td class="border-bottom-0">
                                            <div class="d-flex align-items-center gap-2">
                                                <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.monitoring_pelanggaran.show', $item->monitoring_id) }}"
                                                    class="btn btn-outline-primary btn-sm">
                                                    <i class="ti ti-eye fs-4"></i>
                                                </a>
                                                @if(in_array(Auth::user()->level, ['admin', 'kesiswaan', 'kepala_sekolah']))
                                                    <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.monitoring_pelanggaran.edit', $item->monitoring_id) }}"
                                                        class="btn btn-outline-warning btn-sm">
                                                        <i class="ti ti-pencil fs-4"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="ti ti-database-off fs-1 text-muted mb-2"></i>
                                                <p class="text-muted mb-0">Tidak ada data monitoring pelanggaran</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($monitoring->hasPages())
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="text-muted">
                                Menampilkan {{ $monitoring->firstItem() }} sampai {{ $monitoring->lastItem() }} dari
                                {{ $monitoring->total() }} data
                            </div>
                            <nav>
                                {{ $monitoring->appends(request()->query())->links('pagination::bootstrap-4') }}
                            </nav>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection