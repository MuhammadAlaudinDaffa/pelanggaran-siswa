@extends('layout.main')
@section('title', 'Detail Pelanggaran')
@section('content')
        <div class="row">
            <div class="col-12 d-flex align-items-stretch">
                <div class="card w-100">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-semibold mb-4">Detail Pelanggaran</h5>

                        <!-- Bukti Foto -->
                        @if($pelanggaran->bukti_foto)
                        <div class="text-center mb-4">
                            <img src="{{ asset('storage/' . $pelanggaran->bukti_foto) }}" alt="Bukti Pelanggaran" 
                                 class="img-thumbnail" style="width: 300px; height: 200px; object-fit: cover; border-radius: 12px;">
                        </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="fw-semibold">ID:</td>
                                        <td>{{ $pelanggaran->pelanggaran_id }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">Siswa:</td>
                                        <td>
                                            @if(in_array(Auth::user()->level, ['admin', 'kesiswaan', 'kepala_sekolah']))
                                                {{ $pelanggaran->siswa->nama_siswa }} ({{ $pelanggaran->siswa->nis }})
                                            @else
                                                {{ $pelanggaran->siswa->nama_siswa }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">Kelas:</td>
                                        <td>
                                            <span class="badge bg-primary">{{ $pelanggaran->siswa->kelas->nama_kelas }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">Jenis Pelanggaran:</td>
                                        <td>{{ $pelanggaran->jenisPelanggaran->nama_pelanggaran }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">Kategori:</td>
                                        <td>{{ $pelanggaran->jenisPelanggaran->kategoriPelanggaran->nama_kategori ?? 'Tidak ada kategori' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">Status Pelanggaran:</td>
                                        <td>
                                            @php
                                                $status = '';
                                                $badgeClass = '';
                                                if ($pelanggaran->poin >= 1 && $pelanggaran->poin <= 15) {
                                                    $status = 'Ringan';
                                                    $badgeClass = 'bg-info';
                                                } elseif ($pelanggaran->poin >= 16 && $pelanggaran->poin <= 30) {
                                                    $status = 'Sedang';
                                                    $badgeClass = 'bg-warning';
                                                } elseif ($pelanggaran->poin >= 31 && $pelanggaran->poin <= 50) {
                                                    $status = 'Berat';
                                                    $badgeClass = 'bg-danger';
                                                } elseif ($pelanggaran->poin >= 51) {
                                                    $status = 'Sangat Berat';
                                                    $badgeClass = 'bg-dark';
                                                }
                                            @endphp
                                            <span class="badge {{ $badgeClass }} rounded-3 fw-semibold">{{ $status }} - {{ $pelanggaran->poin }}</span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="fw-semibold">Tanggal:</td>
                                        <td>{{ \Carbon\Carbon::parse($pelanggaran->tanggal)->format('d F Y') }}</td>
                                    </tr>
                                    @if(in_array(Auth::user()->level, ['admin', 'kesiswaan', 'kepala_sekolah']))
                                    <tr>
                                        <td class="fw-semibold">Guru Pencatat:</td>
                                        <td>{{ $pelanggaran->guruPencatat->nama_guru ?? 'Tidak diketahui'}}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td class="fw-semibold">Status:</td>
                                        <td>
                                            @if($pelanggaran->status_verifikasi === 'menunggu')
                                                <span class="badge bg-warning rounded-3 fw-semibold">Menunggu</span>
                                            @elseif($pelanggaran->status_verifikasi === 'diverifikasi')
                                                <span class="badge bg-success rounded-3 fw-semibold">Diverifikasi</span>
                                            @elseif($pelanggaran->status_verifikasi === 'tolak')
                                                <span class="badge bg-danger rounded-3 fw-semibold">Ditolak</span>
                                            @else
                                                <span class="badge bg-info rounded-3 fw-semibold">Revisi</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @if($pelanggaran->guruVerifikator || $pelanggaran->verifikator_tim)
                                    <tr>
                                        <td class="fw-semibold">Verifikator:</td>
                                        <td>
                                            @if($pelanggaran->guruVerifikator)
                                                {{ $pelanggaran->guruVerifikator->nama_guru }}
                                                @if($pelanggaran->guruVerifikator->user)
                                                    <span class="badge bg-secondary ms-1">{{ ucfirst($pelanggaran->guruVerifikator->user->level) }}</span>
                                                @endif
                                            @else
                                                {{ $pelanggaran->verifikator_tim }}
                                            @endif
                                        </td>
                                    </tr>
                                    @elseif($pelanggaran->status_verifikasi !== 'menunggu')
                                        <tr>
                                            <td class="fw-semibold">Verifikator:</td>
                                            <td>Tidak diketahui</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td class="fw-semibold">Tahun Ajaran:</td>
                                        <td>{{ $pelanggaran->tahunAjaran->tahun_ajaran }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        @if($pelanggaran->keterangan)
                        <div class="row mt-3">
                            <div class="col-12">
                                <h6 class="fw-semibold">Keterangan:</h6>
                                <p class="text-muted">{{ $pelanggaran->keterangan }}</p>
                            </div>
                        </div>
                        @endif

                        @if($pelanggaran->catatan_verifikasi)
                        <div class="row mt-3">
                            <div class="col-12">
                                <h6 class="fw-semibold">Catatan Verifikasi:</h6>
                                <p class="text-muted">{{ $pelanggaran->catatan_verifikasi }}</p>
                            </div>
                        </div>
                        @endif

                        <div class="mt-4">
                            <!-- Verification Actions -->
                            @if(in_array(Auth::user()->level, ['admin', 'kesiswaan']) && $pelanggaran->status_verifikasi === 'menunggu')
                                <div class="border rounded p-3 mb-3 bg-light">
                                    <h6 class="fw-semibold mb-3"><i class="ti ti-shield-check me-2"></i>Aksi Verifikasi</h6>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-success" onclick="verifikasi({{ $pelanggaran->pelanggaran_id }}, 'diverifikasi')">
                                            <i class="ti ti-check"></i> Verifikasi
                                        </button>
                                        <button class="btn btn-warning" onclick="verifikasi({{ $pelanggaran->pelanggaran_id }}, 'revisi')">
                                            <i class="ti ti-edit"></i> Revisi
                                        </button>
                                        <button class="btn btn-danger" onclick="verifikasi({{ $pelanggaran->pelanggaran_id }}, 'tolak')">
                                            <i class="ti ti-x"></i> Tolak
                                        </button>
                                    </div>
                                </div>
                            @endif

                            <!-- Kepala Sekolah Special Features -->
                            @if(Auth::user()->level === 'kepala_sekolah' && $pelanggaran->status_verifikasi === 'diverifikasi')
                                @php
                                    $existingSanksi = \App\Models\Sanksi::where('pelanggaran_id', $pelanggaran->pelanggaran_id)->first();
                                    $existingMonitoring = \App\Models\MonitoringPelanggaran::where('pelanggaran_id', $pelanggaran->pelanggaran_id)->first();
                                @endphp

                                @if($existingSanksi || $existingMonitoring)
                                    <div class="border rounded p-3 mb-3 bg-light">
                                        <h6 class="fw-semibold mb-3"><i class="ti ti-eye me-2"></i>Informasi Tindak Lanjut</h6>

                                        @if($existingSanksi)
                                            <div class="card mb-3">
                                                <div class="card-body">
                                                    <h6 class="card-title"><i class="ti ti-gavel me-2"></i>Sanksi</h6>
                                                    <p class="card-text"><strong>Jenis:</strong> {{ $existingSanksi->jenis_sanksi }}</p>
                                                    <p class="card-text"><strong>Status:</strong> 
                                                        <span class="badge bg-{{ $existingSanksi->status === 'selesai' ? 'success' : ($existingSanksi->status === 'berjalan' ? 'primary' : 'warning') }}">
                                                            {{ ucfirst($existingSanksi->status) }}
                                                        </span>
                                                    </p>
                                                    <p class="card-text"><strong>Periode:</strong> 
                                                        {{ \Carbon\Carbon::parse($existingSanksi->tanggal_mulai)->format('d/m/Y') }} - 
                                                        {{ $existingSanksi->tanggal_selesai ? \Carbon\Carbon::parse($existingSanksi->tanggal_selesai)->format('d/m/Y') : 'Belum ditentukan' }}
                                                    </p>
                                                    @if($existingSanksi->deskripsi_sanksi)
                                                        <p class="card-text"><strong>Deskripsi:</strong> {{ $existingSanksi->deskripsi_sanksi }}</p>
                                                    @endif
                                                    <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.sanksi.show', $existingSanksi->sanksi_id) }}" class="btn btn-sm btn-outline-primary">
                                                        <i class="ti ti-eye"></i> Lihat Detail Sanksi
                                                    </a>
                                                </div>
                                            </div>
                                        @endif

                                        @if($existingMonitoring)
                                            <div class="card">
                                                <div class="card-body">
                                                    <h6 class="card-title"><i class="ti ti-eye-check me-2"></i>Monitoring</h6>
                                                    <p class="card-text"><strong>Status:</strong> 
                                                        <span class="badge bg-{{ $existingMonitoring->status_monitoring === 'selesai' ? 'success' : ($existingMonitoring->status_monitoring === 'dipantau' ? 'primary' : 'warning') }}">
                                                            {{ ucfirst(str_replace('_', ' ', $existingMonitoring->status_monitoring)) }}
                                                        </span>
                                                    </p>
                                                    <p class="card-text"><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($existingMonitoring->tanggal_monitoring)->format('d/m/Y') }}</p>
                                                    @if($existingMonitoring->catatan_monitoring)
                                                        <p class="card-text"><strong>Catatan:</strong> {{ Str::limit($existingMonitoring->catatan_monitoring, 100) }}</p>
                                                    @endif
                                                    <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.monitoring_pelanggaran.show', $existingMonitoring->monitoring_id) }}" class="btn btn-sm btn-outline-info">
                                                        <i class="ti ti-eye"></i> Lihat Detail Monitoring
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            @endif

                            <!-- Navigation Actions -->
                            <div class="d-flex gap-2">
                                @php
                                    $currentGuru = \App\Models\Guru::where('user_id', Auth::id())->first();
                                    $canEdit = in_array($pelanggaran->status_verifikasi, ['menunggu', 'revisi']) &&
                                    ($currentGuru && $currentGuru->guru_id == $pelanggaran->guru_pencatat ||
                                    in_array(Auth::user()->level, ['admin', 'kesiswaan']));
                                @endphp
                                @if($pelanggaran->status_verifikasi === 'diverifikasi' && in_array(Auth::user()->level, ['admin', 'kesiswaan']))
                                    @php
                                        $existingSanksi = \App\Models\Sanksi::where('pelanggaran_id', $pelanggaran->pelanggaran_id)->first();
                                        $existingMonitoring = \App\Models\MonitoringPelanggaran::where('pelanggaran_id', $pelanggaran->pelanggaran_id)->first();
                                    @endphp
                                    @if($existingSanksi)
                                        <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.sanksi.show', $existingSanksi->sanksi_id) }}" class="btn btn-success">
                                            <i class="ti ti-gavel"></i> Lihat Sanksi
                                        </a>
                                    @else
                                        <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.sanksi.create') }}?pelanggaran_id={{ $pelanggaran->pelanggaran_id }}" class="btn btn-warning">
                                            <i class="ti ti-gavel"></i> Buat Sanksi
                                        </a>
                                    @endif
                                    @if($existingMonitoring)
                                        <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.monitoring_pelanggaran.show', $existingMonitoring->monitoring_id) }}" class="btn btn-outline-info">
                                            <i class="ti ti-eye-check"></i> Lihat Monitoring
                                        </a>
                                    @else
                                        <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.monitoring_pelanggaran.create') }}?pelanggaran_id={{ $pelanggaran->pelanggaran_id }}" class="btn btn-outline-warning">
                                            <i class="ti ti-eye-check"></i> Mulai Monitoring
                                        </a>
                                    @endif
                                @endif
                                @if(($currentGuru && $currentGuru->guru_id == $pelanggaran->guru_pencatat) && $canEdit)
                                    <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.pelanggaran.edit', $pelanggaran->pelanggaran_id) }}" class="btn btn-warning">
                                        <i class="ti ti-pencil"></i> Edit
                                    </a>
                                @endif
                                @if(Auth::user()->level === 'siswa')
                                    <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.siswa_overview.show', Auth::id()) }}" class="btn btn-secondary">
                                        <i class="ti ti-arrow-left"></i> Kembali ke Data Siswa
                                    </a>
                                @elseif(request('from') === 'siswa_overview' && request('siswa_id'))
                                    <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.siswa_overview.show', request('siswa_id')) }}" class="btn btn-secondary">
                                        <i class="ti ti-arrow-left"></i> Kembali ke Overview Siswa
                                    </a>
                                @else
                                    <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.pelanggaran.index') }}" class="btn btn-secondary">
                                        <i class="ti ti-arrow-left"></i> Tabel Pelanggaran
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Verifikasi -->
        <div class="modal fade" id="verifikasiModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="verifikasiTitle">Verifikasi Pelanggaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form id="verifikasiForm">
                        <div class="modal-body">
                            <input type="hidden" id="pelanggaranId">
                            <input type="hidden" id="statusVerifikasi">

                            <div class="mb-3">
                                <label class="form-label">Catatan Verifikasi</label>
                                <textarea class="form-control" id="catatanVerifikasi" rows="3" placeholder="Masukkan catatan verifikasi (opsional)"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary" id="submitVerifikasi">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
        function verifikasi(id, status) {
            document.getElementById('pelanggaranId').value = id;
            document.getElementById('statusVerifikasi').value = status;

            let title, btnClass;
            if (status === 'diverifikasi') {
                title = 'Verifikasi Pelanggaran';
                btnClass = 'btn btn-success';
            } else if (status === 'revisi') {
                title = 'Minta Revisi Pelanggaran';
                btnClass = 'btn btn-warning';
            } else {
                title = 'Tolak Pelanggaran';
                btnClass = 'btn btn-danger';
            }

            document.getElementById('verifikasiTitle').textContent = title;
            document.getElementById('submitVerifikasi').className = btnClass;

            const modal = new bootstrap.Modal(document.getElementById('verifikasiModal'));
            modal.show();
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('verifikasiForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const id = document.getElementById('pelanggaranId').value;
                const status = document.getElementById('statusVerifikasi').value;
                const catatan = document.getElementById('catatanVerifikasi').value;

                @if(in_array(Auth::user()->level, ['admin', 'kesiswaan']))
                    const url = `{{ \App\Helpers\RouteHelper::route('kesiswaan.pelanggaran.verifikasi', ':id') }}`.replace(':id', id);
                @else
                    console.error('Unauthorized access attempt');
                    alert('Anda tidak memiliki akses untuk melakukan verifikasi');
                    return;
                @endif
                const data = {
                    _token: '{{ csrf_token() }}',
                    status_verifikasi: status,
                    catatan_verifikasi: catatan
                };

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('verifikasiModal'));
                    modal.hide();
                    location.reload();
                })
                .catch(error => {
                    console.log('Error:', error);
                    alert('Terjadi kesalahan saat memverifikasi data');
                });
            });
        });
        </script>
@endsection