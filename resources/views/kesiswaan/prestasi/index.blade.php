@extends('layout.main')

@section('title', 'Data Prestasi')

@section('content')

    <!-- Card Laporan -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-success text-white">
                <div class="card-body text-center py-4">
                    <h4 class="card-title text-white mb-3">Catat Prestasi Siswa</h4>
                    <p class="card-text mb-4">Buat catatan prestasi untuk siswa yang berprestasi di sekolah</p>
                    <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.prestasi.create') }}"
                        class="btn btn-light btn-lg">
                        <i class="ti ti-plus me-2"></i> Buat Catatan Prestasi
                    </a>
                </div>
            </div>
        </div>
    </div>

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
                            @if(request('my_reports'))
                                Data Catatan Prestasi yang Anda Buat
                            @else
                                Data Prestasi
                            @endif
                        </h5>
                        <div class="btn-group" role="group">
                            <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.prestasi.index') }}" 
                               class="btn btn-sm {{ !request('my_reports') ? 'btn-primary' : 'btn-outline-primary' }}">
                                Semua Data
                            </a>
                            <a href="{{ request()->fullUrlWithQuery(['my_reports' => '1']) }}" 
                               class="btn btn-sm {{ request('my_reports') ? 'btn-primary' : 'btn-outline-primary' }}">
                                Catatan Saya
                            </a>
                        </div>
                    </div>

                    <!-- Filter and Search Controls -->
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <form method="GET" class="d-flex gap-2">
                                <input type="text" name="search" class="form-control"
                                    placeholder="Cari siswa, NIS, atau jenis prestasi..." value="{{ request('search') }}">
                                <select name="status" class="form-select">
                                    <option value="">Semua Status</option>
                                    <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu
                                    </option>
                                    <option value="diverifikasi" {{ request('status') == 'diverifikasi' ? 'selected' : '' }}>
                                        Diverifikasi</option>
                                    <option value="revisi" {{ request('status') == 'revisi' ? 'selected' : '' }}>Revisi
                                    </option>
                                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak
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
                                    <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.prestasi.index') }}"
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
                                        <h6 class="fw-semibold mb-0">Jenis Prestasi</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Tingkat</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Poin</h6>
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
                                @forelse($prestasi as $index => $item)
                                    <tr>
                                        <td class="border-bottom-0">{{ $prestasi->firstItem() + $index }}</td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">{{ $item->siswa->nama_siswa }}</h6>
                                            <span class="fw-normal">{{ $item->siswa->nis }}</span>
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-normal">{{ $item->siswa->kelas->nama_kelas }}</p>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-1">{{ $item->jenisPrestasi->nama_prestasi }}</h6>
                                            <span
                                                class="fw-normal text-muted">{{ $item->jenisPrestasi->kategoriPrestasi->nama_kategori ?? 'Tidak ada kategori' }}</span>
                                        </td>
                                        <td class="border-bottom-0">
                                            @if($item->tingkat)
                                                <span
                                                    class="badge bg-info rounded-3 fw-semibold">{{ ucfirst($item->tingkat) }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="border-bottom-0">
                                            <span class="badge bg-success rounded-3 fw-semibold">{{ $item->poin }}</span>
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
                                            @elseif($item->status_verifikasi === 'ditolak')
                                                <span class="badge bg-danger rounded-3 fw-semibold">Ditolak</span>
                                            @else
                                                <span class="badge bg-info rounded-3 fw-semibold">Revisi</span>
                                            @endif
                                        </td>
                                        <td class="border-bottom-0">
                                            <div class="d-flex align-items-center gap-2">
                                                <!-- Action Buttons -->
                                                <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.prestasi.show', $item->prestasi_id) }}"
                                                    class="btn btn-outline-primary btn-sm">
                                                    <i class="ti ti-eye fs-4"></i>
                                                </a>
                                                @php
                                                    $currentGuru = \App\Models\Guru::where('user_id', Auth::id())->first();
                                                    $canEdit = in_array($item->status_verifikasi, ['menunggu', 'revisi']) &&
                                                        $currentGuru && $currentGuru->guru_id == $item->guru_pencatat;
                                                @endphp
                                                @if($canEdit)
                                                    <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.prestasi.edit', $item->prestasi_id) }}"
                                                        class="btn btn-outline-warning btn-sm">
                                                        <i class="ti ti-pencil fs-4"></i>
                                                    </a>
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
                                                                    onclick="verifikasi({{ $item->prestasi_id }}, 'diverifikasi')">
                                                                    <i class="ti ti-check me-2"></i>Verifikasi
                                                                </button></li>
                                                            <li><button class="dropdown-item text-warning" type="button"
                                                                    onclick="verifikasi({{ $item->prestasi_id }}, 'revisi')">
                                                                    <i class="ti ti-edit me-2"></i>Revisi
                                                                </button></li>
                                                            <li><button class="dropdown-item text-danger" type="button"
                                                                    onclick="verifikasi({{ $item->prestasi_id }}, 'ditolak')">
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
                                        <td colspan="9" class="text-center py-4">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="ti ti-trophy fs-1 text-muted mb-2"></i>
                                                <p class="text-muted mb-0">
                                                    {{ request('search') || request('status') ? 'Tidak ada data yang sesuai dengan filter.' : 'Tidak ada data prestasi' }}
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($prestasi->hasPages())
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="text-muted">
                                Menampilkan {{ $prestasi->firstItem() }} sampai {{ $prestasi->lastItem() }} dari
                                {{ $prestasi->total() }} data
                            </div>
                            <nav>
                                {{ $prestasi->appends(request()->query())->links('pagination::bootstrap-4') }}
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
                    <h5 class="modal-title" id="verifikasiTitle">Verifikasi Prestasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="verifikasiForm">
                    <div class="modal-body">
                        <input type="hidden" id="prestasiId">
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
            document.getElementById('prestasiId').value = id;
            document.getElementById('statusVerifikasi').value = status;

            let title = 'Verifikasi Prestasi';
            let btnClass = 'btn-primary';

            if (status === 'diverifikasi') {
                title = 'Verifikasi Prestasi';
                btnClass = 'btn-success';
            } else if (status === 'ditolak') {
                title = 'Tolak Prestasi';
                btnClass = 'btn-danger';
            } else if (status === 'revisi') {
                title = 'Minta Revisi Prestasi';
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

                const id = document.getElementById('prestasiId').value;
                const status = document.getElementById('statusVerifikasi').value;
                const catatan = document.getElementById('catatanVerifikasi').value;

                const url = `{{ \App\Helpers\RouteHelper::route('kesiswaan.prestasi.index') }}/${id}/verifikasi`;
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