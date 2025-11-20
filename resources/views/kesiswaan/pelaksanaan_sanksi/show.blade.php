@extends('layout.main')
@section('title', 'Detail Pelaksanaan Sanksi')
@section('content')
    <div class="row">
        <div class="col-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-semibold mb-4">Detail Pelaksanaan Sanksi</h5>

                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-semibold">ID:</td>
                                    <td>{{ $pelaksanaanSanksi->pelaksanaan_id }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Siswa:</td>
                                    <td>{{ $pelaksanaanSanksi->sanksi->pelanggaran->siswa->nama_siswa }}
                                        ({{ $pelaksanaanSanksi->sanksi->pelanggaran->siswa->nis }})</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Kelas:</td>
                                    <td>
                                        <span
                                            class="badge bg-primary">{{ $pelaksanaanSanksi->sanksi->pelanggaran->siswa->kelas->nama_kelas }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Jenis Sanksi:</td>
                                    <td>{{ $pelaksanaanSanksi->sanksi->jenis_sanksi }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Tanggal Pelaksanaan:</td>
                                    <td>{{ \Carbon\Carbon::parse($pelaksanaanSanksi->tanggal_pelaksanaan)->format('d F Y') }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-semibold">Status:</td>
                                    <td>
                                        @if($pelaksanaanSanksi->status === 'terjadwal')
                                            <span class="badge bg-secondary rounded-3 fw-semibold">Terjadwal</span>
                                        @elseif($pelaksanaanSanksi->status === 'dikerjakan')
                                            <span class="badge bg-primary rounded-3 fw-semibold">Dikerjakan</span>
                                        @elseif($pelaksanaanSanksi->status === 'tuntas')
                                            <span class="badge bg-success rounded-3 fw-semibold">Tuntas</span>
                                        @elseif($pelaksanaanSanksi->status === 'terlambat')
                                            <span class="badge bg-danger rounded-3 fw-semibold">Terlambat</span>
                                        @else
                                            <span class="badge bg-warning rounded-3 fw-semibold">Perpanjangan</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Guru Pengawas:</td>
                                    <td>{{ $pelaksanaanSanksi->guruPengawas->nama_guru ?? 'Belum ditentukan' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Dibuat Tanggal:</td>
                                    <td>{{ \Carbon\Carbon::parse($pelaksanaanSanksi->created_at)->format('d F Y H:i') }}
                                    </td>
                                </tr>
                                @if($pelaksanaanSanksi->bukti_pelaksanaan)
                                    <tr>
                                        <td class="fw-semibold">Bukti:</td>
                                        <td><a href="{{ asset('storage/' . $pelaksanaanSanksi->bukti_pelaksanaan) }}"
                                                target="_blank" class="btn btn-sm btn-outline-primary">Lihat Bukti</a></td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>

                    @if($pelaksanaanSanksi->deskripsi_pelaksanaan)
                        <div class="row mt-3">
                            <div class="col-12">
                                <h6 class="fw-semibold">Deskripsi Pelaksanaan:</h6>
                                <p class="text-muted">{{ $pelaksanaanSanksi->deskripsi_pelaksanaan }}</p>
                            </div>
                        </div>
                    @endif

                    @if($pelaksanaanSanksi->catatan)
                        <div class="row mt-3">
                            <div class="col-12">
                                <h6 class="fw-semibold">Catatan:</h6>
                                <p class="text-muted">{{ $pelaksanaanSanksi->catatan }}</p>
                            </div>
                        </div>
                    @endif

                    <div class="mt-4">
                        <div class="d-flex gap-2">
                            <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.sanksi.show', $pelaksanaanSanksi->sanksi->sanksi_id) }}"
                                class="btn btn-warning">
                                <i class="ti ti-gavel"></i> Lihat Sanksi
                            </a>
                            <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.pelaksanaan_sanksi.index') }}"
                                class="btn btn-secondary">
                                <i class="ti ti-arrow-left"></i> Tabel P. Sanksi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection