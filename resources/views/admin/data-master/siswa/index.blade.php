@extends('layout.main')
@section('title', 'Daftar Siswa')
@section('content')
    <div class="row">
        <div class="col-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-semibold mb-4">Daftar Siswa</h5>
                    <div class="alert alert-info d-flex align-items-center mb-3" role="alert">
                        <i class="ti ti-info-circle me-2 fs-4"></i>
                        <div class="flex-grow-1">
                            <strong>Informasi:</strong> Data siswa hanya dapat dibuat bersamaan dengan pembuatan user. Untuk menambah siswa baru, silakan buat user dengan level "Siswa" terlebih dahulu.
                        </div>
                        <a href="{{ route('admin.data-master.user.create') }}" class="btn btn-primary ms-3">
                            <i class="ti ti-plus me-1"></i>Buat User Siswa
                        </a>
                    </div>
                    <div class="d-flex justify-content-end mb-3">
                        <a href="{{ route('admin.data-master.index') }}" class="btn btn-outline-info">
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
                                <input type="text" name="search" class="form-control" placeholder="Cari siswa..." value="{{ request('search') }}">
                                <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">
                                <button type="submit" class="btn btn-outline-primary">Cari</button>
                                @if(request('search'))
                                    <a href="{{ route('admin.data-master.siswa.index') }}" class="btn btn-outline-secondary">Reset</a>
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
                                        <h6 class="fw-semibold mb-0">NIS</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Foto</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Nama Siswa</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Kelas</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Jenis Kelamin</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Aksi</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($siswa->count() == 0)
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            <p class="mb-0 fw-normal">{{ request('search') ? 'Tidak ada data yang sesuai dengan pencarian.' : 'Tidak ada data.' }}</p>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($siswa as $item)
                                        <tr>
                                            <td class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">{{ $item->nis }}</h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                @if($item->foto)
                                                    <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto {{ $item->nama_siswa }}"
                                                        class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                                @else
                                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center"
                                                        style="width: 50px; height: 50px;">
                                                        <i class="ti ti-user text-muted"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="mb-0 fw-semibold">{{ $item->nama_siswa }}</p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <span class="badge bg-primary">{{ $item->kelas->nama_kelas ?? '-' }}</span>
                                            </td>
                                            <td class="border-bottom-0">
                                                <span class="badge {{ $item->jenis_kelamin == 'laki-laki' ? 'bg-info' : 'bg-warning' }}">
                                                    {{ ucfirst($item->jenis_kelamin ?? '-') }}
                                                </span>
                                            </td>
                                            <td class="border-bottom-0">
                                                <a class="btn btn-outline-info btn-sm"
                                                    href="{{ route('admin.data-master.siswa.show', $item->siswa_id) }}">
                                                    <i class="ti ti-eye"></i>
                                                </a>
                                                <a class="btn btn-outline-warning btn-sm"
                                                    href="{{ route('admin.data-master.siswa.edit', $item->siswa_id) }}">
                                                    <i class="ti ti-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.data-master.siswa.destroy', $item->siswa_id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm"
                                                        onclick="return confirm('Yakin ingin menghapus siswa ini?')">
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
                    @if($siswa->hasPages())
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="text-muted">
                                Menampilkan {{ $siswa->firstItem() }} sampai {{ $siswa->lastItem() }} dari {{ $siswa->total() }} data
                            </div>
                            <nav>
                                {{ $siswa->links('pagination::bootstrap-4') }}
                            </nav>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection