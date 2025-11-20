@extends('layout.main')
@section('title', 'Data Bimbingan Konseling')
@section('content')

    <!-- Card Keluhan untuk Siswa -->
    @if(Auth::user()->level === 'siswa')
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white">
                <div class="card-body text-center py-4">
                    <h4 class="card-title text-white mb-3">Ajukan Keluhan atau Masalah</h4>
                    <p class="card-text mb-4">Sampaikan keluhan atau masalah Anda kepada guru BK</p>
                    <a href="{{ \App\Helpers\RouteHelper::route('bimbingan_konseling.bk.create') }}" class="btn btn-light btn-lg">
                        <i class="ti ti-plus me-2"></i> Buat Keluhan
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session('success') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title fw-semibold mb-0">
                            @if(Auth::user()->level === 'siswa')
                                Riwayat Konseling Saya
                            @else
                                Data Bimbingan Konseling
                            @endif
                        </h5>
                    </div>

                    <!-- Filter Controls -->
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <form method="GET" class="d-flex gap-2">
                                <input type="text" name="search" class="form-control" 
                                    placeholder="Cari topik atau keluhan..." value="{{ request('search') }}">
                                <select name="status" class="form-select">
                                    <option value="">Semua Status</option>
                                    <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="berkelanjutan" {{ request('status') == 'berkelanjutan' ? 'selected' : '' }}>Berkelanjutan</option>
                                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                                <button type="submit" class="btn btn-primary">Filter</button>
                                @if(request('search') || request('status'))
                                    <a href="{{ \App\Helpers\RouteHelper::route('bimbingan_konseling.bk.index') }}" class="btn btn-outline-secondary">Reset</a>
                                @endif
                            </form>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th class="border-bottom-0">No</th>
                                    @if(Auth::user()->level !== 'siswa')
                                        <th class="border-bottom-0">Siswa</th>
                                    @endif
                                    <th class="border-bottom-0">Jenis Layanan</th>
                                    <th class="border-bottom-0">Topik</th>
                                    <th class="border-bottom-0">Status</th>
                                    <th class="border-bottom-0">Tanggal</th>
                                    <th class="border-bottom-0">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bimbinganKonseling as $index => $item)
                                    <tr>
                                        <td class="border-bottom-0">{{ $loop->iteration }}</td>
                                        @if(Auth::user()->level !== 'siswa')
                                            <td class="border-bottom-0">
                                                <div class="d-flex align-items-center gap-2">
                                                    <div>
                                                        <h6 class="fw-semibold mb-0">{{ $item->siswa->nama_siswa }}</h6>
                                                        <span class="fw-normal">{{ $item->siswa->nis }}</span>
                                                    </div>
                                                    @if($item->status === 'menunggu' && ($item->guru_konselor || $item->konselor_user_id))
                                                        <i class="ti ti-user-check text-success" title="Sudah diklaim konselor"></i>
                                                    @endif
                                                </div>
                                            </td>
                                        @endif
                                        <td class="border-bottom-0">
                                            <span class="badge bg-info">{{ ucfirst($item->jenis_layanan) }}</span>
                                        </td>
                                        <td class="border-bottom-0">{{ $item->topik }}</td>
                                        <td class="border-bottom-0">
                                            @if($item->status === 'menunggu')
                                                <span class="badge bg-warning">Menunggu</span>
                                            @elseif($item->status === 'berkelanjutan')
                                                <span class="badge bg-primary">Berkelanjutan</span>
                                            @elseif($item->status === 'selesai')
                                                <span class="badge bg-success">Selesai</span>
                                            @else
                                                <span class="badge bg-danger">Ditolak</span>
                                            @endif
                                        </td>
                                        <td class="border-bottom-0">
                                            {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}
                                        </td>
                                        <td class="border-bottom-0">
                                            <div class="d-flex align-items-center gap-2">
                                                <a href="{{ \App\Helpers\RouteHelper::route('bimbingan_konseling.bk.show', $item->bk_id) }}" 
                                                   class="btn btn-outline-primary btn-sm">
                                                    <i class="ti ti-eye fs-4"></i>
                                                </a>
                                                @if(Auth::user()->level === 'siswa' && $item->status === 'menunggu')
                                                    <a href="{{ \App\Helpers\RouteHelper::route('bimbingan_konseling.bk.edit', $item->bk_id) }}" 
                                                       class="btn btn-outline-warning btn-sm">
                                                        <i class="ti ti-pencil fs-4"></i>
                                                    </a>
                                                @endif
                                                @if(in_array(Auth::user()->level, ['bimbingan_konseling', 'admin']) && $item->status === 'menunggu' && !$item->guru_konselor && !$item->konselor_user_id)
                                                    <button class="btn btn-outline-success btn-sm" 
                                                            onclick="ambilKasus({{ $item->bk_id }})">
                                                        <i class="ti ti-hand-grab fs-4"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ Auth::user()->level === 'siswa' ? '6' : '7' }}" class="text-center py-4">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="ti ti-database-off fs-1 text-muted mb-2"></i>
                                                <p class="text-muted mb-0">Tidak ada data bimbingan konseling</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function ambilKasus(id) {
            if(confirm('Apakah Anda yakin ingin mengambil kasus ini?')) {
                fetch(`{{ \App\Helpers\RouteHelper::route('bimbingan_konseling.bk.index') }}/${id}/ambil`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        location.reload();
                    } else {
                        alert('Gagal mengambil kasus');
                    }
                });
            }
        }
    </script>
@endsection