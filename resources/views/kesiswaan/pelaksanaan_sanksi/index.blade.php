@extends('layout.main')

@section('title', 'Data Pelaksanaan Sanksi')

@section('content')
    <!-- Card Laporan -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-success text-white">
                <div class="card-body text-center py-4">
                    <h4 class="card-title text-white mb-3">Data Pelaksanaan Sanksi</h4>
                    @if(Auth::user()->level === 'kepala_sekolah')
                        <p class="card-text mb-4">Hanya tim kesiswaan yang dapat membuat pelaksanaan sanksi. Anda dapat melihat data sanksi melalui tombol di bawah ini.</p>
                        <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.sanksi.index') }}" class="btn btn-light btn-lg">
                            <i class="ti ti-eye me-2"></i> Lihat Data Sanksi
                        </a>
                    @elseif (in_array(Auth::user()->level, ['admin', 'kesiswaan']))
                        <p class="card-text mb-4">Buka halaman detail sanksi untuk membuat atau mengedit pelaksanaan sanksi</p>
                        <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.sanksi.index') }}" class="btn btn-light btn-lg">
                            <i class="ti ti-gavel me-2"></i> Lihat Data Sanksi
                        </a>
                    @else
                        <p class="card-text mb-4">Data Pelaksanaan Sanksi hanya dapat dibuat oleh tim Kesiswaan. Hubungi tim Kesiswaan jika ada sanksi yang ingin dilaksanakan.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title fw-bold mb-0">Data Pelaksanaan Sanksi</h5>
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
                                        <h6 class="fw-semibold mb-0">Jenis Sanksi</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Tanggal Pelaksanaan</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Status</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Aksi</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pelaksanaan as $index => $item)
                                    <tr>
                                        <td class="border-bottom-0">{{ $pelaksanaan->firstItem() + $index }}</td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">{{ $item->sanksi->pelanggaran->siswa->nama_siswa }}
                                            </h6>
                                            <span class="fw-normal">{{ $item->sanksi->pelanggaran->siswa->nis }}</span>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-1">{{ $item->sanksi->jenis_sanksi }}</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-normal">
                                                {{ \Carbon\Carbon::parse($item->tanggal_pelaksanaan)->format('d/m/Y') }}
                                            </p>
                                        </td>
                                        <td class="border-bottom-0">
                                            @if($item->status === 'terjadwal')
                                                <span class="badge bg-secondary rounded-3 fw-semibold">Terjadwal</span>
                                            @elseif($item->status === 'dikerjakan')
                                                <span class="badge bg-primary rounded-3 fw-semibold">Dikerjakan</span>
                                            @elseif($item->status === 'tuntas')
                                                <span class="badge bg-success rounded-3 fw-semibold">Tuntas</span>
                                            @elseif($item->status === 'terlambat')
                                                <span class="badge bg-danger rounded-3 fw-semibold">Terlambat</span>
                                            @else
                                                <span class="badge bg-warning rounded-3 fw-semibold">Perpanjangan</span>
                                            @endif
                                        </td>
                                        <td class="border-bottom-0">
                                            <div class="d-flex align-items-center gap-2">
                                                <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.pelaksanaan_sanksi.show', $item->pelaksanaan_id) }}"
                                                    class="btn btn-outline-primary btn-sm">
                                                    <i class="ti ti-eye fs-4"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="ti ti-database-off fs-1 text-muted mb-2"></i>
                                                <p class="text-muted mb-0">Tidak ada data pelaksanaan sanksi</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($pelaksanaan->hasPages())
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="text-muted">
                                Menampilkan {{ $pelaksanaan->firstItem() }} sampai {{ $pelaksanaan->lastItem() }} dari
                                {{ $pelaksanaan->total() }} data
                            </div>
                            <nav>
                                {{ $pelaksanaan->appends(request()->query())->links('pagination::bootstrap-4') }}
                            </nav>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection