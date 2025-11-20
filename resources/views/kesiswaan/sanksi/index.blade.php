@extends('layout.main')

@section('title', 'Data Sanksi')

@section('content')
            <!-- Card Laporan -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card bg-warning text-white">
                        <div class="card-body text-center py-4">
                            @if(Auth::user()->level === 'kepala_sekolah')
                                <h4 class="card-title text-white mb-3">Data Sanksi</h4>
                                <p class="card-text mb-4">Hanya tim kesiswaan yang dapat membuat sanksi. Anda dapat melihat data pelanggaran yang telah diverifikasi melalui tombol di bawah ini.</p>
                                <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.pelanggaran.index') }}"
                                    class="btn btn-light btn-lg">
                                    <i class="ti ti-eye me-2"></i> Lihat Data Pelanggaran
                                </a>
                            @else
                                <h4 class="card-title text-white mb-3">Manajemen Sanksi</h4>
                                <p class="card-text mb-4">Tekan tombol dibawah ini untuk memilih data pelanggaran dengan cepat. Anda juga dapat melihat salah satu laporan pelanggaran yang berstatus diverifikasi, lalu buat sanksi melalui data pelanggaran tersebut.</p>
                                <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.pelanggaran.index') }}"
                                    class="btn btn-light btn-lg">
                                    <i class="ti ti-exclamation-triangle me-2"></i> Pilih Laporan untuk Sanksi
                                </a>
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
                                <h5 class="card-title fw-semibold mb-0">Data Sanksi</h5>
                            </div>

                            <!-- Filter and Search Controls -->
                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <form method="GET" class="d-flex gap-2">
                                        <input type="text" name="search" class="form-control"
                                            placeholder="Cari siswa atau jenis sanksi..."
                                            value="{{ request('search') }}">
                                        <select name="status" class="form-select">
                                            <option value="">Semua Status</option>
                                            <option value="direncanakan" {{ request('status') == 'direncanakan' ? 'selected' : '' }}>Direncanakan</option>
                                            <option value="berjalan" {{ request('status') == 'berjalan' ? 'selected' : '' }}>Berjalan</option>
                                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                            <option value="ditunda" {{ request('status') == 'ditunda' ? 'selected' : '' }}>Ditunda</option>
                                            <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                        </select>
                                        <select name="sort" class="form-select">
                                            <option value="desc" {{ request('sort', 'desc') == 'desc' ? 'selected' : '' }}>Terbaru</option>
                                            <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Terlama</option>
                                        </select>
                                        @php
    $hasFilters = request('search') || request('status') || request('sort', 'desc') != 'desc';
                                        @endphp
                                        <button type="submit"
                                            class="btn {{ $hasFilters ? 'btn-primary' : 'btn-dark' }}">Filter</button>
                                        @if(request('search') || request('status') || request('sort', 'desc') != 'desc')
                                            <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.sanksi.index') }}"
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
                                                <h6 class="fw-semibold mb-0">Jenis Sanksi</h6>
                                            </th>
                                            <th class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">Periode</h6>
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
                                        @forelse($sanksi as $index => $item)
                                            <tr>
                                                <td class="border-bottom-0">{{ $sanksi->firstItem() + $index }}</td>
                                                <td class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-0">{{ $item->pelanggaran->siswa->nama_siswa }}</h6>
                                                    <span class="fw-normal">{{ $item->pelanggaran->siswa->nis }}</span>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <p class="mb-0 fw-normal">{{ $item->pelanggaran->siswa->kelas->nama_kelas ?? 'N/A' }}</p>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-1">{{ $item->jenis_sanksi }}</h6>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <p class="mb-0 fw-normal">
                                                        @if($item->tanggal_mulai && $item->tanggal_selesai)
                                                            {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d/m/Y') }}
                                                        @elseif($item->tanggal_mulai)
                                                            Mulai: {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d/m/Y') }}
                                                        @else
                                                            Belum ditentukan
                                                        @endif
                                                    </p>
                                                </td>
                                                <td class="border-bottom-0">
                                                    @if($item->status === 'direncanakan')
                                                        <span class="badge bg-secondary rounded-3 fw-semibold">Direncanakan</span>
                                                    @elseif($item->status === 'berjalan')
                                                        <span class="badge bg-primary rounded-3 fw-semibold">Berjalan</span>
                                                    @elseif($item->status === 'selesai')
                                                        <span class="badge bg-success rounded-3 fw-semibold">Selesai</span>
                                                    @elseif($item->status === 'ditunda')
                                                        <span class="badge bg-warning rounded-3 fw-semibold">Ditunda</span>
                                                    @else
                                                        <span class="badge bg-danger rounded-3 fw-semibold">Dibatalkan</span>
                                                    @endif
                                                </td>
                                                <td class="border-bottom-0">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.sanksi.show', $item->sanksi_id) }}"
                                                            class="btn btn-outline-primary btn-sm">
                                                            <i class="ti ti-eye fs-4"></i>
                                                        </a>
                                                        @if(in_array(Auth::user()->level, ['admin', 'kesiswaan']))
                                                            <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.sanksi.edit', $item->sanksi_id) }}"
                                                            class="btn btn-outline-warning btn-sm">
                                                                <i class="ti ti-pencil fs-4"></i>
                                                            </a>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center py-4">
                                                    <div class="d-flex flex-column align-items-center">
                                                        <i class="ti ti-database-off fs-1 text-muted mb-2"></i>
                                                        <p class="text-muted mb-0">
                                                            {{ request('search') || request('status') ? 'Tidak ada data yang sesuai dengan filter.' : 'Tidak ada data sanksi' }}
                                                        </p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            @if($sanksi->hasPages())
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <div class="text-muted">
                                        Menampilkan {{ $sanksi->firstItem() }} sampai {{ $sanksi->lastItem() }} dari
                                        {{ $sanksi->total() }} data
                                    </div>
                                    <nav>
                                        {{ $sanksi->appends(request()->query())->links('pagination::bootstrap-4') }}
                                    </nav>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
@endsection