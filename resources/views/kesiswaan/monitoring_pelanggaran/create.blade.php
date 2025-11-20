@extends('layout.main')

@section('title', 'Buat Monitoring Pelanggaran')

@section('content')
    <div class="row">
        <div class="col-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-semibold mb-4">Pilih Pelanggaran untuk Monitoring</h5>
                    
                    <!-- Search Filter -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <form method="GET" class="d-flex gap-2">
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Cari siswa, NIS, atau jenis pelanggaran..." 
                                       value="{{ request('search') }}">
                                <button type="submit" class="btn btn-outline-primary">Cari</button>
                                @if(request('search'))
                                    <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.monitoring_pelanggaran.create') }}" 
                                       class="btn btn-outline-secondary">Reset</a>
                                @endif
                            </form>
                        </div>
                    </div>
                    
                    @if($availablePelanggaran->count() > 0)
                        <div class="table-responsive">
                            <table class="table text-nowrap mb-0 align-middle">
                                <thead class="text-dark fs-4">
                                    <tr>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Siswa</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Kelas</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Jenis Pelanggaran</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Tanggal</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Aksi</h6>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($availablePelanggaran as $item)
                                        <tr>
                                            <td class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">{{ $item->siswa->nama_siswa }}</h6>
                                                <span class="fw-normal">{{ $item->siswa->nis }}</span>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="mb-0 fw-normal">{{ $item->siswa->kelas->nama_kelas }}</p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <h6 class="fw-semibold mb-1">{{ $item->jenisPelanggaran->nama_pelanggaran }}</h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="mb-0 fw-normal">
                                                    {{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}
                                                </p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <button type="button" class="btn btn-outline-primary btn-sm" 
                                                        onclick="showPelanggaranDetail({{ $item->pelanggaran_id }})">
                                                    <i class="ti ti-eye"></i> Lihat Detail
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <div class="d-flex flex-column align-items-center">
                                <i class="ti ti-database-off fs-1 text-muted mb-2"></i>
                                <p class="text-muted mb-0">Tidak ada pelanggaran yang dapat dimonitor</p>
                                <small class="text-muted">Pelanggaran harus berstatus 'diverifikasi' dan belum dimonitor</small>
                            </div>
                        </div>
                    @endif
                    
                    <div class="mt-4">
                        <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.monitoring_pelanggaran.index') }}" class="btn btn-secondary">
                            <i class="ti ti-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Pelanggaran -->
    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Pelanggaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="modalContent">
                    <div class="text-center py-4">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <form id="monitoringForm" action="{{ \App\Helpers\RouteHelper::route('kesiswaan.monitoring_pelanggaran.store') }}" method="POST" style="display: inline;">
                        @csrf
                        <input type="hidden" name="pelanggaran_id" id="selectedPelanggaranId">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-eye-check"></i> Pilih untuk Monitoring
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showPelanggaranDetail(id) {
            document.getElementById('selectedPelanggaranId').value = id;
            
            // Find pelanggaran data from the table
            const availablePelanggaran = @json($availablePelanggaran);
            const pelanggaran = availablePelanggaran.find(p => p.pelanggaran_id == id);
            
            if (pelanggaran) {
                const content = `
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="fw-semibold">Data Siswa</h6>
                            <p><strong>Nama:</strong> ${pelanggaran.siswa.nama_siswa}</p>
                            <p><strong>NIS:</strong> ${pelanggaran.siswa.nis}</p>
                            <p><strong>Kelas:</strong> ${pelanggaran.siswa.kelas.nama_kelas}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-semibold">Data Pelanggaran</h6>
                            <p><strong>Jenis:</strong> ${pelanggaran.jenis_pelanggaran.nama_pelanggaran}</p>
                            <p><strong>Status Pelanggaran:</strong> 
                                ${pelanggaran.poin >= 1 && pelanggaran.poin <= 15 ? '<span class="badge bg-info">Ringan - ' + pelanggaran.poin + '</span>' : 
                                  pelanggaran.poin >= 16 && pelanggaran.poin <= 30 ? '<span class="badge bg-warning">Sedang - ' + pelanggaran.poin + '</span>' : 
                                  pelanggaran.poin >= 31 && pelanggaran.poin <= 50 ? '<span class="badge bg-danger">Berat - ' + pelanggaran.poin + '</span>' : 
                                  '<span class="badge bg-dark">Sangat Berat - ' + pelanggaran.poin + '</span>'}
                            </p>
                            <p><strong>Tanggal:</strong> ${new Date(pelanggaran.tanggal).toLocaleDateString('id-ID')}</p>
                        </div>
                    </div>
                    ${pelanggaran.keterangan ? `
                        <div class="mt-3">
                            <h6 class="fw-semibold">Keterangan</h6>
                            <p>${pelanggaran.keterangan}</p>
                        </div>
                    ` : ''}
                `;
                
                document.getElementById('modalContent').innerHTML = content;
            }
            
            const modal = new bootstrap.Modal(document.getElementById('detailModal'));
            modal.show();
        }
    </script>
@endsection