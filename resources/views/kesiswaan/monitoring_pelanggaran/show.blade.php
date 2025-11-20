@extends('layout.main')

@section('title', 'Detail Monitoring Pelanggaran')

@section('content')
    <div class="row">
        <div class="col-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-semibold mb-4">Detail Monitoring Pelanggaran</h5>

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{ session('success') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>{{ session('error') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-semibold">ID Monitoring:</td>
                                    <td>{{ $monitoring->monitoring_id }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Siswa:</td>
                                    <td>{{ $monitoring->pelanggaran->siswa->nama_siswa }}
                                        ({{ $monitoring->pelanggaran->siswa->nis }})</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Kelas:</td>
                                    <td>
                                        <span
                                            class="badge bg-primary">{{ $monitoring->pelanggaran->siswa->kelas->nama_kelas }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Jenis Pelanggaran:</td>
                                    <td>{{ $monitoring->pelanggaran->jenisPelanggaran->nama_pelanggaran }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Status Pelanggaran:</td>
                                    <td>
                                        @php
                                            $status = '';
                                            $badgeClass = '';
                                            if ($monitoring->pelanggaran->poin >= 1 && $monitoring->pelanggaran->poin <= 15) {
                                                $status = 'Ringan';
                                                $badgeClass = 'bg-info';
                                            } elseif ($monitoring->pelanggaran->poin >= 16 && $monitoring->pelanggaran->poin <= 30) {
                                                $status = 'Sedang';
                                                $badgeClass = 'bg-warning';
                                            } elseif ($monitoring->pelanggaran->poin >= 31 && $monitoring->pelanggaran->poin <= 50) {
                                                $status = 'Berat';
                                                $badgeClass = 'bg-danger';
                                            } elseif ($monitoring->pelanggaran->poin >= 51) {
                                                $status = 'Sangat Berat';
                                                $badgeClass = 'bg-dark';
                                            }
                                        @endphp
                                        <span class="badge {{ $badgeClass }} rounded-3 fw-semibold">{{ $status }} -
                                            {{ $monitoring->pelanggaran->poin }}</span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-semibold">Status Monitoring:</td>
                                    <td>
                                        @if($monitoring->status_monitoring === 'dipantau')
                                            <span class="badge bg-info rounded-3 fw-semibold">Dipantau</span>
                                        @elseif($monitoring->status_monitoring === 'tindak_lanjut')
                                            <span class="badge bg-warning rounded-3 fw-semibold">Tindak Lanjut</span>
                                        @elseif($monitoring->status_monitoring === 'progres_baik')
                                            <span class="badge bg-primary rounded-3 fw-semibold">Progres Baik</span>
                                        @elseif($monitoring->status_monitoring === 'selesai')
                                            <span class="badge bg-success rounded-3 fw-semibold">Selesai</span>
                                        @else
                                            <span class="badge bg-danger rounded-3 fw-semibold">Eskalasi</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Tanggal Monitoring:</td>
                                    <td>{{ \Carbon\Carbon::parse($monitoring->tanggal_monitoring)->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Kepala Sekolah:</td>
                                    <td>{{ $monitoring->guruKepsek->nama_guru }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Dibuat Tanggal:</td>
                                    <td>{{ \Carbon\Carbon::parse($monitoring->created_at)->format('d F Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if($monitoring->catatan_monitoring)
                        <div class="row mt-3">
                            <div class="col-12">
                                <h6 class="fw-semibold">Catatan Monitoring:</h6>
                                <p class="text-muted">{{ $monitoring->catatan_monitoring }}</p>
                            </div>
                        </div>
                    @endif

                    @if($monitoring->tindak_lanjut)
                        <div class="row mt-3">
                            <div class="col-12">
                                <h6 class="fw-semibold">Tindak Lanjut:</h6>
                                <p class="text-muted">{{ $monitoring->tindak_lanjut }}</p>
                            </div>
                        </div>
                    @endif

                    <div class="mt-4">
                        <div class="d-flex gap-2">
                            <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.pelanggaran.show', $monitoring->pelanggaran->pelanggaran_id) }}"
                                class="btn btn-info">
                                <i class="ti ti-file-text"></i> Lihat Pelanggaran
                            </a>
                            @if(in_array(Auth::user()->level, ['admin', 'kesiswaan', 'kepala_sekolah']))
                                <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.monitoring_pelanggaran.edit', $monitoring->monitoring_id) }}"
                                    class="btn btn-warning">
                                    <i class="ti ti-pencil"></i> Edit
                                </a>
                            @endif
                            <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.monitoring_pelanggaran.index') }}"
                                class="btn btn-secondary">
                                <i class="ti ti-arrow-left"></i> Tabel Monitor
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection