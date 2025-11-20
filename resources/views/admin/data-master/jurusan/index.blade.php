@extends('layout.main')
@section('title', 'Daftar Jurusan')
@section('content')
    <div class="row">
        <div class="col-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-semibold mb-4">Daftar Jurusan</h5>
                    <div class="d-flex gap-2 mb-3">
                        <a href="{{ route('admin.data-master.jurusan.create') }}" class="btn btn-secondary">
                            <i class="ti ti-plus"></i>
                            Tambah Jurusan
                        </a>
                        <a href="{{ route('admin.data-master.kelas.index') }}" class="btn btn-outline-info">
                            <i class="ti ti-arrow-left"></i>
                            Kembali ke Kelas
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
                    
                    <!-- Filter and Pagination Controls -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <form method="GET" class="d-flex gap-2">
                                <input type="text" name="search" class="form-control" placeholder="Cari jurusan..." value="{{ request('search') }}">
                                <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">
                                <button type="submit" class="btn btn-outline-primary">Cari</button>
                                @if(request('search'))
                                    <a href="{{ route('admin.data-master.jurusan.index') }}" class="btn btn-outline-secondary">Reset</a>
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
                                        <h6 class="fw-semibold mb-0">Id</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Nama Jurusan</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Deskripsi</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Aksi</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($jurusan->count() == 0)
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <p class="mb-0 fw-normal">{{ request('search') ? 'Tidak ada data yang sesuai dengan pencarian.' : 'Tidak ada data.' }}</p>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($jurusan as $item)
                                        <tr>
                                            <td class="border-bottom-0">
                                                {{ $item->jurusan_id }}
                                            </td>
                                            <td class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">{{ $item->nama_jurusan }}</h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="mb-0 fw-normal">{{ $item->deskripsi }}</p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <a class="btn btn-outline-info btn-sm" href="{{ route('admin.data-master.jurusan.show', $item->jurusan_id) }}">
                                                    <i class="ti ti-eye"></i>
                                                </a>
                                                <a class="btn btn-outline-warning btn-sm" href="{{ route('admin.data-master.jurusan.edit', $item->jurusan_id) }}">
                                                    <i class="ti ti-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.data-master.jurusan.destroy', $item->jurusan_id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Yakin ingin menghapus jurusan ini?')">
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
                    @if($jurusan->hasPages())
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="text-muted">
                                Menampilkan {{ $jurusan->firstItem() }} sampai {{ $jurusan->lastItem() }} dari {{ $jurusan->total() }} data
                            </div>
                            <nav>
                                {{ $jurusan->links('pagination::bootstrap-4') }}
                            </nav>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection