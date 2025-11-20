@extends('layout.main')

@section('title', 'Data Pelanggaran')

@section('content')

    <!-- Card Laporan -->
    @if(\App\Models\Guru::where('user_id', Auth::id())->exists())
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white">
                <div class="card-body text-center py-4">
                    <h4 class="card-title text-white mb-3">Laporkan Pelanggaran Siswa</h4>
                    <p class="card-text mb-4">Buat laporan pelanggaran untuk siswa yang melanggar aturan sekolah</p>
                    <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.pelanggaran.create') }}"
                        class="btn btn-light btn-lg">
                        <i class="ti ti-plus me-2"></i> Buat Laporan Pelanggaran
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif
    
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
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title fw-semibold mb-0">
                            @if(Auth::user()->level === 'kepala_sekolah' && !request('my_reports'))
                                Data Pelanggaran Siswa
                            @elseif(request('my_reports') && (in_array(Auth::user()->level, ['admin', 'kesiswaan']) || Auth::user()->level === 'kepala_sekolah'))
                                Data Laporan Pelanggaran yang Anda Buat
                            @else
                                @if(in_array(Auth::user()->level, ['admin', 'kesiswaan']))
                                    Data Pelanggaran
                                @else
                                    Data Laporan Pelanggaran yang Anda Buat
                                @endif
                            @endif
                        </h5>
                        @if(in_array(Auth::user()->level, ['admin', 'kesiswaan', 'kepala_sekolah']) && \App\Models\Guru::where('user_id', Auth::id())->exists())
                            <div class="btn-group" role="group">
                                <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.pelanggaran.index') }}" 
                                   class="btn btn-sm {{ !request('my_reports') ? 'btn-primary' : 'btn-outline-primary' }}">
                                    Semua Data
                                </a>
                                <a href="{{ request()->fullUrlWithQuery(['my_reports' => '1']) }}" 
                                   class="btn btn-sm {{ request('my_reports') ? 'btn-primary' : 'btn-outline-primary' }}">
                                    Laporan Saya
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Filter and Search Controls -->
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <form method="GET" class="d-flex gap-2">
                                <input type="text" name="search" class="form-control"
                                    placeholder="Cari siswa, NIS, atau jenis pelanggaran..."
                                    value="{{ request('search') }}">
                                <select name="status" class="form-select">
                                    <option value="">Semua Status</option>
                                    <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu
                                    </option>
                                    <option value="diverifikasi" {{ request('status') == 'diverifikasi' ? 'selected' : '' }}>
                                        Diverifikasi</option>
                                    <option value="revisi" {{ request('status') == 'revisi' ? 'selected' : '' }}>Revisi
                                    </option>
                                    <option value="tolak" {{ request('status') == 'tolak' ? 'selected' : '' }}>Ditolak
                                    </option>
                                </select>
                                <select name="sort" class="form-select">
                                    <option value="desc" {{ request('sort', 'desc') == 'desc' ? 'selected' : '' }}>Terbaru
                                    </option>
                                    <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Terlama</option>
                                </select>
                                @php
                                    $hasFilters = request('search') || request('status') || request('sort', 'desc') != 'desc' || request('my_reports');
                                @endphp
                                <button type="submit"
                                    class="btn {{ $hasFilters ? 'btn-primary' : 'btn-dark' }}">Filter</button>
                                @if(request('search') || request('status') || request('sort', 'desc') != 'desc' || request('my_reports'))
                                    <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.pelanggaran.index') }}"
                                        class="btn btn-outline-secondary">Reset</a>
                                @endif
                            </form>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="d-flex justify-content-end align-items-center gap-2 mt-3">
                                <span class="text-muted">Tampilkan:</span>
                                <div class="btn-group" role="group">
                                    @foreach([10, 25, 50, 100] as $size)
                                        <a href="{{ request()->fullUrlWithQuery(['per_page' => $size]) }}"
                                            class="btn btn-sm {{ request('per_page', 10) == $size ? 'btn-primary' : 'btn-outline-primary' }}">
                                            {{ $size }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
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
                                        <h6 class="fw-semibold mb-0">Kelas</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Jenis Pelanggaran</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Status Pelanggaran</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Tanggal</h6>
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
                                @forelse($pelanggaran as $index => $item)
                                    <tr>
                                        <td class="border-bottom-0">{{ $pelanggaran->firstItem() + $index }}</td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">{{ $item->siswa->nama_siswa }}</h6>
                                            <span class="fw-normal">{{ $item->siswa->nis }}</span>
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-normal">{{ $item->siswa->kelas->nama_kelas }}</p>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-1">{{ $item->jenisPelanggaran->nama_pelanggaran }}</h6>
                                            <span
                                                class="fw-normal text-muted">{{ $item->jenisPelanggaran->kategoriPelanggaran->nama_kategori ?? 'Tidak ada kategori' }}</span>
                                        </td>
                                        <td class="border-bottom-0">
                                            @php
                                                $status = '';
                                                $badgeClass = '';
                                                if ($item->poin >= 1 && $item->poin <= 15) {
                                                    $status = 'Ringan';
                                                    $badgeClass = 'bg-info';
                                                } elseif ($item->poin >= 16 && $item->poin <= 30) {
                                                    $status = 'Sedang';
                                                    $badgeClass = 'bg-warning';
                                                } elseif ($item->poin >= 31 && $item->poin <= 50) {
                                                    $status = 'Berat';
                                                    $badgeClass = 'bg-danger';
                                                } elseif ($item->poin >= 51) {
                                                    $status = 'Sangat Berat';
                                                    $badgeClass = 'bg-dark';
                                                }
                                            @endphp
                                            <span class="badge {{ $badgeClass }} rounded-3 fw-semibold">{{ $status }} -
                                                {{ $item->poin }}</span>
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-normal">
                                                {{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}
                                            </p>
                                        </td>
                                        <td class="border-bottom-0">
                                            @if($item->status_verifikasi === 'menunggu')
                                                <span class="badge bg-warning rounded-3 fw-semibold">Menunggu</span>
                                            @elseif($item->status_verifikasi === 'diverifikasi')
                                                <span class="badge bg-success rounded-3 fw-semibold">Diverifikasi</span>
                                            @elseif($item->status_verifikasi === 'tolak')
                                                <span class="badge bg-danger rounded-3 fw-semibold">Ditolak</span>
                                            @else
                                                <span class="badge bg-info rounded-3 fw-semibold">Revisi</span>
                                            @endif
                                        </td>
                                        <td class="border-bottom-0">
                                            <div class="d-flex align-items-center gap-2">
                                                <!-- Action Buttons -->
                                                <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.pelanggaran.show', $item->pelanggaran_id) }}"
                                                    class="btn btn-outline-primary btn-sm">
                                                    <i class="ti ti-eye fs-4"></i>
                                                </a>
                                                @if(Auth::user()->level !== 'kepala_sekolah')
                                                    @php
                                                        $currentGuru = \App\Models\Guru::where('user_id', Auth::id())->first();
                                                        $canEdit = in_array($item->status_verifikasi, ['menunggu', 'revisi']) &&
                                                            ($currentGuru && $currentGuru->guru_id == $item->guru_pencatat || 
                                                             in_array(Auth::user()->level, ['admin', 'kesiswaan']));
                                                    @endphp
                                                    @if(($currentGuru && $currentGuru->guru_id == $item->guru_pencatat) && $canEdit)
                                                        <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.pelanggaran.edit', $item->pelanggaran_id) }}"
                                                            class="btn btn-outline-warning btn-sm">
                                                            <i class="ti ti-pencil fs-4"></i>
                                                        </a>
                                                    @endif
                                                @endif

                                                <!-- Sanksi Button -->
                                                @if($item->status_verifikasi === 'diverifikasi')
                                                    @php
                                                        $existingSanksi = \App\Models\Sanksi::where('pelanggaran_id', $item->pelanggaran_id)->first();
                                                    @endphp
                                                    @if($existingSanksi)
                                                        <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.sanksi.show', $existingSanksi->sanksi_id) }}"
                                                            class="btn btn-outline-success btn-sm" title="Lihat Sanksi">
                                                            <i class="ti ti-gavel fs-4"></i>
                                                        </a>
                                                    @elseif(in_array(Auth::user()->level, ['admin', 'kesiswaan']))
                                                        <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.sanksi.create') }}?pelanggaran_id={{ $item->pelanggaran_id }}"
                                                            class="btn btn-outline-warning btn-sm" title="Buat Sanksi">
                                                            <i class="ti ti-gavel fs-4"></i>
                                                        </a>
                                                    @endif
                                                @endif

                                                <!-- Verification Dropdown -->
                                                @if(in_array(Auth::user()->level, ['admin', 'kesiswaan']) && $item->status_verifikasi === 'menunggu')
                                                    <div class="dropdown">
                                                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle"
                                                            type="button" data-bs-toggle="dropdown" data-bs-boundary="viewport">
                                                            <i class="ti ti-shield-check fs-4"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li><button class="dropdown-item text-success" type="button"
                                                                    onclick="verifikasi({{ $item->pelanggaran_id }}, 'diverifikasi')">
                                                                    <i class="ti ti-check me-2"></i>Verifikasi
                                                                </button></li>
                                                            <li><button class="dropdown-item text-warning" type="button"
                                                                    onclick="verifikasi({{ $item->pelanggaran_id }}, 'revisi')">
                                                                    <i class="ti ti-edit me-2"></i>Revisi
                                                                </button></li>
                                                            <li><button class="dropdown-item text-danger" type="button"
                                                                    onclick="verifikasi({{ $item->pelanggaran_id }}, 'tolak')">
                                                                    <i class="ti ti-x me-2"></i>Tolak
                                                                </button></li>
                                                        </ul>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="ti ti-database-off fs-1 text-muted mb-2"></i>
                                                <p class="text-muted mb-0">
                                                    {{ request('search') || request('status') ? 'Tidak ada data yang sesuai dengan filter.' : 'Tidak ada data pelanggaran' }}
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($pelanggaran->hasPages())
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="text-muted">
                                Menampilkan {{ $pelanggaran->firstItem() }} sampai {{ $pelanggaran->lastItem() }} dari
                                {{ $pelanggaran->total() }} data
                            </div>
                            <nav>
                                {{ $pelanggaran->appends(request()->query())->links('pagination::bootstrap-4') }}
                            </nav>
                        </div>
                    @endif
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
                            <textarea class="form-control" id="catatanVerifikasi" rows="3"
                                placeholder="Masukkan catatan verifikasi (opsional)"></textarea>
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

            let title = 'Verifikasi Pelanggaran';
            let btnClass = 'btn-primary';

            if (status === 'diverifikasi') {
                title = 'Verifikasi Pelanggaran';
                btnClass = 'btn-success';
            } else if (status === 'tolak') {
                title = 'Tolak Pelanggaran';
                btnClass = 'btn-danger';
            } else if (status === 'revisi') {
                title = 'Minta Revisi Pelanggaran';
                btnClass = 'btn-info';
            }

            document.getElementById('verifikasiTitle').textContent = title;
            const submitBtn = document.getElementById('submitVerifikasi');
            submitBtn.className = 'btn ' + btnClass;

            const modal = new bootstrap.Modal(document.getElementById('verifikasiModal'));
            modal.show();
        }

        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('verifikasiForm').addEventListener('submit', function (e) {
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