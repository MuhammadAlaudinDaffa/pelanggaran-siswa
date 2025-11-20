@extends('layout.main')
@section('title', 'Daftar Tahun Ajaran')
@section('content')
    <div class="row">
        <div class="col-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-semibold mb-4">Daftar Tahun Ajaran</h5>
                    <div class="d-flex gap-2 mb-3">
                        <a href="{{ route('admin.data-master.tahun-ajaran.create') }}" class="btn btn-primary">
                            <i class="ti ti-plus"></i>
                            Tambah Tahun Ajaran
                        </a>
                        <a href="{{ route('admin.data-master.index') }}" class="btn btn-outline-info ms-auto">
                            <i class="ti ti-arrow-left"></i>
                            Kembali ke Data Master
                        </a>
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
                    
                    <!-- Filter and Pagination Controls -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <form method="GET" class="d-flex gap-2">
                                <input type="text" name="search" class="form-control" placeholder="Cari tahun ajaran..." value="{{ request('search') }}">
                                <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">
                                <button type="submit" class="btn btn-outline-primary">Cari</button>
                                @if(request('search'))
                                    <a href="{{ route('admin.data-master.tahun-ajaran.index') }}" class="btn btn-outline-secondary">Reset</a>
                                @endif
                            </form>
                        </div>
                        <div class="col-md-6 text-end">
                            <div class="d-flex justify-content-end align-items-center gap-2">
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
                                        <h6 class="fw-semibold mb-0">Kode</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Tahun Ajaran</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Semester</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Status</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Periode</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Data Terkait</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Aksi</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($tahunAjaran->count() == 0)
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <p class="mb-0 fw-normal">{{ request('search') ? 'Tidak ada data yang sesuai dengan pencarian.' : 'Tidak ada data.' }}</p>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($tahunAjaran as $item)
                                        <tr>
                                            <td class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">{{ $item->kode_tahun }}</h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="mb-0 fw-semibold">{{ $item->tahun_ajaran }}</p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <span class="badge bg-info">Semester {{ $item->semester }}</span>
                                            </td>
                                            <td class="border-bottom-0">
                                                <span class="badge {{ $item->status_aktif ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $item->status_aktif ? 'Aktif' : 'Tidak Aktif' }}
                                                </span>
                                            </td>
                                            <td class="border-bottom-0">
                                                <small>{{ date('d/m/Y', strtotime($item->tanggal_mulai)) }} s/d {{ date('d/m/Y', strtotime($item->tanggal_selesai)) }}</small>
                                            </td>
                                            <td class="border-bottom-0">
                                                <small>
                                                    <span class="badge bg-primary">{{ $item->pelanggaran_count }} Pelanggaran</span><br>
                                                    <span class="badge bg-success">{{ $item->prestasi_count }} Prestasi</span><br>
                                                    <span class="badge bg-info">{{ $item->bimbingan_konseling_count }} BK</span>
                                                </small>
                                            </td>
                                            <td class="border-bottom-0">
                                                <a class="btn btn-outline-info btn-sm"
                                                    href="{{ route('admin.data-master.tahun-ajaran.show', $item->tahun_ajaran_id) }}">
                                                    <i class="ti ti-eye"></i>
                                                </a>
                                                <a class="btn btn-outline-warning btn-sm"
                                                    href="{{ route('admin.data-master.tahun-ajaran.edit', $item->tahun_ajaran_id) }}">
                                                    <i class="ti ti-edit"></i>
                                                </a>
                                                <form
                                                    action="{{ route('admin.data-master.tahun-ajaran.destroy', $item->tahun_ajaran_id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm"
                                                        onclick="return confirm('Yakin ingin menghapus tahun ajaran ini?')">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    @if($tahunAjaran->hasPages())
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="text-muted">
                                Menampilkan {{ $tahunAjaran->firstItem() }} sampai {{ $tahunAjaran->lastItem() }} dari {{ $tahunAjaran->total() }} data
                            </div>
                            <nav>
                                {{ $tahunAjaran->links('pagination::bootstrap-4') }}
                            </nav>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection