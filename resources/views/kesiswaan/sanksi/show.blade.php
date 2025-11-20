@extends('layout.main')
@section('title', 'Detail Sanksi')
@section('content')
        <div class="row">
            <div class="col-12 d-flex align-items-stretch">
                <div class="card w-100">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-semibold mb-4">Detail Sanksi</h5>

                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="fw-semibold">ID:</td>
                                        <td>{{ $sanksi->sanksi_id }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">Siswa:</td>
                                        <td>{{ $sanksi->pelanggaran->siswa->nama_siswa }}
                                            ({{ $sanksi->pelanggaran->siswa->nis }})</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">Kelas:</td>
                                        <td>
                                            <span
                                                class="badge bg-primary">{{ $sanksi->pelanggaran->siswa->kelas->nama_kelas }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">Jenis Pelanggaran:</td>
                                        <td>{{ $sanksi->pelanggaran->jenisPelanggaran->nama_pelanggaran }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">Status Pelanggaran:</td>
                                        <td>
                                            @php
                                                $status = '';
                                                $badgeClass = '';
                                                if ($sanksi->pelanggaran->poin >= 1 && $sanksi->pelanggaran->poin <= 15) {
                                                    $status = 'Ringan';
                                                    $badgeClass = 'bg-info';
                                                } elseif ($sanksi->pelanggaran->poin >= 16 && $sanksi->pelanggaran->poin <= 30) {
                                                    $status = 'Sedang';
                                                    $badgeClass = 'bg-warning';
                                                } elseif ($sanksi->pelanggaran->poin >= 31 && $sanksi->pelanggaran->poin <= 50) {
                                                    $status = 'Berat';
                                                    $badgeClass = 'bg-danger';
                                                } elseif ($sanksi->pelanggaran->poin >= 51) {
                                                    $status = 'Sangat Berat';
                                                    $badgeClass = 'bg-dark';
                                                }
                                            @endphp
                                            <span class="badge {{ $badgeClass }} rounded-3 fw-semibold">{{ $status }} -
                                                {{ $sanksi->pelanggaran->poin }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">Jenis Sanksi:</td>
                                        <td>{{ $sanksi->jenis_sanksi }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="fw-semibold">Tanggal Pelanggaran:</td>
                                        <td>{{ \Carbon\Carbon::parse($sanksi->pelanggaran->tanggal)->format('d F Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">Tanggal Mulai Sanksi:</td>
                                        <td>{{ $sanksi->tanggal_mulai ? \Carbon\Carbon::parse($sanksi->tanggal_mulai)->format('d F Y') : 'Belum ditentukan' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">Tanggal Selesai Sanksi:</td>
                                        <td>{{ $sanksi->tanggal_selesai ? \Carbon\Carbon::parse($sanksi->tanggal_selesai)->format('d F Y') : 'Belum ditentukan' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">Status:</td>
                                        <td>
                                            @if($sanksi->status === 'direncanakan')
                                                <span class="badge bg-secondary rounded-3 fw-semibold">Direncanakan</span>
                                            @elseif($sanksi->status === 'berjalan')
                                                <span class="badge bg-primary rounded-3 fw-semibold">Berjalan</span>
                                            @elseif($sanksi->status === 'selesai')
                                                <span class="badge bg-success rounded-3 fw-semibold">Selesai</span>
                                            @elseif($sanksi->status === 'ditunda')
                                                <span class="badge bg-warning rounded-3 fw-semibold">Ditunda</span>
                                            @else
                                                <span class="badge bg-danger rounded-3 fw-semibold">Dibatalkan</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">Penanggung Jawab:</td>
                                        <td>{{ $sanksi->guruPenanggungjawab->nama_guru ?? 'Belum ditentukan' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">Dibuat Tanggal:</td>
                                        <td>{{ \Carbon\Carbon::parse($sanksi->created_at)->format('d F Y H:i') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        @if($sanksi->deskripsi_sanksi)
                            <div class="row mt-3">
                                <div class="col-12">
                                    <h6 class="fw-semibold">Deskripsi Sanksi:</h6>
                                    <p class="text-muted">{{ $sanksi->deskripsi_sanksi }}</p>
                                </div>
                            </div>
                        @endif

                        @if($sanksi->catatan_pelaksanaan)
                            <div class="row mt-3">
                                <div class="col-12">
                                    <h6 class="fw-semibold">Catatan Pelaksanaan:</h6>
                                    <p class="text-muted">{{ $sanksi->catatan_pelaksanaan }}</p>
                                </div>
                            </div>
                        @endif

                        <div class="mt-4">
                            <div class="d-flex gap-2">
                                <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.pelanggaran.show', $sanksi->pelanggaran->pelanggaran_id) }}"
                                    class="btn btn-info">
                                    <i class="ti ti-file-text"></i> Lihat Pelanggaran
                                </a>
                                @php
                                    $canEdit = in_array(Auth::user()->level, ['admin', 'kesiswaan']);
                                    
                                    // If status is selesai or dibatalkan, check if within 3 days
                                    if (in_array($sanksi->status, ['selesai', 'dibatalkan']) && $sanksi->tanggal_selesai) {
                                        $daysSinceCompleted = \Carbon\Carbon::parse($sanksi->tanggal_selesai)->diffInDays(now());
                                        $canEdit = $canEdit && $daysSinceCompleted <= 3;
                                    }
                                @endphp
                                @if($canEdit)
                                    <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.sanksi.edit', $sanksi->sanksi_id) }}" class="btn btn-warning">
                                        <i class="ti ti-pencil"></i> Edit
                                    </a>
                                @endif
                                <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.sanksi.index') }}"
                                    class="btn btn-secondary">
                                    <i class="ti ti-arrow-left"></i> Tabel Sanksi
                                </a>
                                <p class="text-muted fs-2">Bagian Pelaksanaan Sanksi berada di bawah</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pelaksanaan Sanksi Card -->
        <div class="row mt-2">
            <div class="col-12 d-flex align-items-stretch">
                <div class="card w-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="card-title fw-semibold mb-0">Data Pelaksanaan Sanksi</h5>
                            <div class="d-flex gap-2">
                                @php
                                    $pelaksanaan = $sanksi->pelaksanaan->first();
                                @endphp
                                @if($pelaksanaan)
                                    <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.pelaksanaan_sanksi.show', $pelaksanaan->pelaksanaan_id) }}"
                                        class="btn btn-outline-info btn-sm">
                                        <i class="ti ti-eye"></i> Lihat Pelaksanaan
                                    </a>
                                @endif
                                @if($sanksi->status !== 'dibatalkan' && in_array(Auth::user()->level, ['admin', 'kesiswaan']))
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#pelaksanaanModal">
                                        <i class="ti ti-{{ $pelaksanaan ? 'pencil' : 'plus' }}"></i>
                                        {{ $pelaksanaan ? 'Edit Pelaksanaan' : 'Buat Pelaksanaan' }}
                                    </button>
                                @endif
                            </div>
                        </div>

                        @php
                            $pelaksanaan = $sanksi->pelaksanaan->first();
                        @endphp
                        @if($pelaksanaan)
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td class="fw-semibold">Tanggal Pelaksanaan:</td>
                                            <td>{{ \Carbon\Carbon::parse($pelaksanaan->tanggal_pelaksanaan)->format('d F Y') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">Status:</td>
                                            <td>
                                                @if($pelaksanaan->status === 'terjadwal')
                                                    <span class="badge bg-secondary rounded-3 fw-semibold">Terjadwal</span>
                                                @elseif($pelaksanaan->status === 'dikerjakan')
                                                    <span class="badge bg-primary rounded-3 fw-semibold">Dikerjakan</span>
                                                @elseif($pelaksanaan->status === 'tuntas')
                                                    <span class="badge bg-success rounded-3 fw-semibold">Tuntas</span>
                                                @elseif($pelaksanaan->status === 'terlambat')
                                                    <span class="badge bg-danger rounded-3 fw-semibold">Terlambat</span>
                                                @else
                                                    <span class="badge bg-warning rounded-3 fw-semibold">Perpanjangan</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">Guru Pengawas:</td>
                                            <td>{{ $pelaksanaan->guruPengawas->nama_guru ?? 'Belum ditentukan' }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td class="fw-semibold">Dibuat Tanggal:</td>
                                            <td>{{ \Carbon\Carbon::parse($pelaksanaan->created_at)->format('d F Y H:i') }}</td>
                                        </tr>
                                        @if($pelaksanaan->bukti_pelaksanaan)
                                            <tr>
                                                <td class="fw-semibold">Bukti:</td>
                                                <td><a href="{{ asset('storage/' . $pelaksanaan->bukti_pelaksanaan) }}" target="_blank"
                                                        class="btn btn-sm btn-outline-primary">Lihat Bukti</a></td>
                                            </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>

                            @if($pelaksanaan->deskripsi_pelaksanaan)
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <h6 class="fw-semibold">Deskripsi Pelaksanaan:</h6>
                                        <p class="text-muted">{{ $pelaksanaan->deskripsi_pelaksanaan }}</p>
                                    </div>
                                </div>
                            @endif

                            @if($pelaksanaan->catatan)
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <h6 class="fw-semibold">Catatan:</h6>
                                        <p class="text-muted">{{ $pelaksanaan->catatan }}</p>
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="text-center py-4">
                                <i class="ti ti-calendar-off fs-1 text-muted mb-2"></i>
                                <p class="text-muted mb-0">Belum ada data pelaksanaan sanksi</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if (in_array(Auth::user()->level, ['admin', 'kesiswaan']) && $sanksi->status !== 'dibatalkan')
        <!-- Modal Pelaksanaan -->
        <div class="modal fade" id="pelaksanaanModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $sanksi->pelaksanaan->first() ? 'Edit' : 'Buat' }} Pelaksanaan Sanksi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    @php
                        $pelaksanaan = $sanksi->pelaksanaan->first();
                    @endphp
                    <form id="pelaksanaanForm" method="POST" enctype="multipart/form-data"
                    action="{{ $pelaksanaan ? \App\Helpers\RouteHelper::route('kesiswaan.pelaksanaan_sanksi.update', $pelaksanaan->pelaksanaan_id) : \App\Helpers\RouteHelper::route('kesiswaan.pelaksanaan_sanksi.store') }}">
                    @csrf
                    @if($pelaksanaan)
                    @method('PUT')
                    @else
                    <input type="hidden" name="sanksi_id" value="{{ $sanksi->sanksi_id }}">
                    @endif
                    
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Pelaksanaan <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="tanggal_pelaksanaan"
                                        value="{{ $sanksi->pelaksanaan->first()->tanggal_pelaksanaan ?? '' }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select" name="status" required>
                                        <option value="terjadwal" {{ ($sanksi->pelaksanaan->first()->status ?? '') == 'terjadwal' ? 'selected' : '' }}>Terjadwal</option>
                                        <option value="dikerjakan" {{ ($sanksi->pelaksanaan->first()->status ?? '') == 'dikerjakan' ? 'selected' : '' }}>Dikerjakan</option>
                                        <option value="tuntas" {{ ($sanksi->pelaksanaan->first()->status ?? '') == 'tuntas' ? 'selected' : '' }}>Tuntas</option>
                                        <option value="terlambat" {{ ($sanksi->pelaksanaan->first()->status ?? '') == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                                        <option value="perpanjangan" {{ ($sanksi->pelaksanaan->first()->status ?? '') == 'perpanjangan' ? 'selected' : '' }}>Perpanjangan</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Guru Pengawas</label>
                            <select class="form-select" name="guru_pengawas">
                                <option value="">Pilih Guru...</option>
                                @foreach(\App\Models\Guru::all() as $guru)
                                <option value="{{ $guru->guru_id }}" {{ ($sanksi->pelaksanaan->first()->guru_pengawas ?? '') == $guru->guru_id ? 'selected' : '' }}>
                                    {{ $guru->nama_guru }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Deskripsi Pelaksanaan</label>
                            <textarea class="form-control" name="deskripsi_pelaksanaan"
                            rows="3">{{ $sanksi->pelaksanaan->first()->deskripsi_pelaksanaan ?? '' }}</textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Bukti Pelaksanaan</label>
                            <input type="file" class="form-control" name="bukti_pelaksanaan"
                            accept="image/*,application/pdf">
                            @if($sanksi->pelaksanaan->first() && $sanksi->pelaksanaan->first()->bukti_pelaksanaan)
                                <small class="text-muted">File saat ini: <a
                                href="{{ asset('storage/' . $sanksi->pelaksanaan->first()->bukti_pelaksanaan) }}"
                                        target="_blank">Lihat</a></small>
                            @endif
                        </div>
                                    
                        <div class="mb-3">
                            <label class="form-label">Catatan</label>
                            <textarea class="form-control" name="catatan"
                            rows="2">{{ $sanksi->pelaksanaan->first()->catatan ?? '' }}</textarea>
                        </div>
                    </div>
                                
                    <div class="modal-footer">
                            <p class="text-muted">Kolom selain bertanda <span class="text-danger">*</span> dapat dikosongkan</p>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit"
                            class="btn btn-primary">{{ $sanksi->pelaksanaan->first() ? 'Update' : 'Simpan' }}</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
@endsection