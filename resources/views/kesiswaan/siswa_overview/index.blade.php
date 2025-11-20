@extends('layout.main')

@section('title', 'Overview Siswa')

@section('content')
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

    @if(isset($classStats) && \App\Models\Guru::where('user_id', Auth::id())->exists())
        <!-- Class Statistics -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title fw-semibold mb-3">Statistik Kelas {{ $kelas->nama_kelas }}</h6>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="text-center">
                                    <i class="ti ti-users fs-1 text-primary mb-2"></i>
                                    <h4 class="text-primary">{{ $classStats['total_siswa'] }}</h4>
                                    <p class="text-muted mb-0">Total Siswa</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <i class="ti ti-alert-triangle fs-1 text-danger mb-2"></i>
                                    <h4 class="text-danger">{{ $classStats['siswa_melanggar'] }}</h4>
                                    <p class="text-muted mb-0">Siswa Melanggar</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <i class="ti ti-minus fs-1 text-warning mb-2"></i>
                                    <h4 class="text-warning">{{ $classStats['total_poin_pelanggaran'] }}</h4>
                                    <p class="text-muted mb-0">Poin Pelanggaran</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <i class="ti ti-trophy fs-1 text-success mb-2"></i>
                                    <h4 class="text-success">{{ $classStats['total_poin_prestasi'] }}</h4>
                                    <p class="text-muted mb-0">Poin Prestasi</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title fw-semibold mb-0">Overview Siswa</h5>
                        @php
                            $guru = \App\Models\Guru::where('user_id', Auth::id())->first();
                            $kelas = $guru ? \App\Models\Kelas::where('wali_kelas_id', $guru->guru_id)->first() : null;
                        @endphp
                        @if($guru && $kelas && in_array(Auth::user()->level, ['admin', 'kesiswaan', 'kepala_sekolah']))
                            <div class="btn-group" role="group">
                                <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.siswa_overview.index') }}" 
                                   class="btn btn-sm {{ !request('kelas_filter') ? 'btn-primary' : 'btn-outline-primary' }}">
                                    Semua Siswa
                                </a>
                                <a href="{{ request()->fullUrlWithQuery(['kelas_filter' => '1']) }}" 
                                   class="btn btn-sm {{ request('kelas_filter') ? 'btn-primary' : 'btn-outline-primary' }}">
                                    Kelas {{ $kelas->nama_kelas }}
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Search Filter -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <form method="GET" class="d-flex gap-2">
                                @if(request('kelas_filter'))
                                    <input type="hidden" name="kelas_filter" value="1">
                                @endif
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Cari nama siswa atau NIS..." 
                                       value="{{ request('search') }}">
                                <button type="submit" class="btn btn-outline-primary">Cari</button>
                                @if(request('search'))
                                    <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.siswa_overview.index') }}{{ request('kelas_filter') ? '?kelas_filter=1' : '' }}" 
                                       class="btn btn-outline-secondary">Reset</a>
                                @endif
                            </form>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">No</h6>
                                    </th>
                                    <th class="border-bottom-0" colspan="2">
                                        <h6 class="fw-semibold mb-0">Siswa</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Kelas</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Total Pel. & Pres.</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Total Poin</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Aksi</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($siswa as $index => $item)
                                    <tr>
                                        <td class="border-bottom-0">{{ $siswa->firstItem() + $index }}</td>
                                        <td class="border-bottom-0">
                                            @if($item->foto)
                                                <img src="{{ asset('storage/siswa/' . $item->foto) }}" alt="Foto {{ $item->nama_siswa }}"
                                                    class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                            @else
                                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center"
                                                    style="width: 50px; height: 50px;">
                                                    <i class="ti ti-user text-muted"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">{{ $item->nama_siswa }}</h6>
                                            <span class="fw-normal">{{ $item->nis }}</span>
                                        </td>
                                        <td class="border-bottom-0">
                                            <span class="badge bg-primary">{{ $item->kelas->nama_kelas ?? '-' }}</span>
                                        </td>
                                        <td class="border-bottom-0 text-center">
                                            <div class="d-flex align-items-center justify-content-center gap-2">
                                                @if($item->total_pelanggaran > 0)
                                                    <span class="badge bg-danger rounded-3 fw-semibold">{{ $item->total_pelanggaran }}</span>
                                                @else
                                                    <span class="text-muted">0</span>
                                                @endif
                                                <span class="text-muted">/</span>
                                                @if($item->total_prestasi > 0)
                                                    <span class="badge bg-success rounded-3 fw-semibold">{{ $item->total_prestasi }}</span>
                                                @else
                                                    <span class="text-muted">0</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="border-bottom-0 text-center">
                                            <div class="d-flex align-items-center justify-content-center gap-2">
                                                @php
                                                    $totalPelanggaranPoin = $item->total_poin_pelanggaran ?? 0;
                                                    $totalPrestasiPoin = $item->total_poin_prestasi ?? 0;
                                                @endphp
                                                @if($totalPelanggaranPoin > 0)
                                                    <span class="badge bg-danger rounded-3 fw-semibold">{{ $totalPelanggaranPoin }}</span>
                                                @else
                                                    <span class="text-muted">0</span>
                                                @endif
                                                <span class="text-muted">/</span>
                                                @if($totalPrestasiPoin > 0)
                                                    <span class="badge bg-success rounded-3 fw-semibold">{{ $totalPrestasiPoin }}</span>
                                                @else
                                                    <span class="text-muted">0</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="border-bottom-0">
                                            <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.siswa_overview.show', $item->siswa_id) }}"
                                                class="btn btn-outline-primary btn-sm">
                                                <i class="ti ti-eye fs-4"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="ti ti-users fs-1 text-muted mb-2"></i>
                                                <p class="text-muted mb-0">
                                                    {{ request('search') ? 'Tidak ada data yang sesuai dengan pencarian.' : 'Tidak ada data siswa' }}
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($siswa->hasPages())
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="text-muted">
                                Menampilkan {{ $siswa->firstItem() }} sampai {{ $siswa->lastItem() }} dari
                                {{ $siswa->total() }} data
                            </div>
                            <nav>
                                {{ $siswa->appends(request()->query())->links('pagination::bootstrap-4') }}
                            </nav>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection