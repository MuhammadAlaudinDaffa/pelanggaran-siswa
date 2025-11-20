@extends('layout.main')
@section('title', 'Daftar Guru')
@section('content')
    <div class="row">
        <div class="col-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-semibold mb-4">Daftar Guru</h5>
                    <div class="alert alert-info d-flex align-items-center mb-3" role="alert">
                        <i class="ti ti-info-circle me-2 fs-4"></i>
                        <div class="flex-grow-1">
                            <strong>Tips:</strong> Untuk membuat data guru baru beserta user sekaligus, gunakan fitur pembuatan user dengan level "Guru". Jika ingin menambah data guru untuk user yang sudah ada, gunakan tombol "Tambah Guru" di bawah ini.
                        </div>
                        <a href="{{ route('admin.data-master.user.create') }}" class="btn btn-success ms-3">
                            <i class="ti ti-user-plus me-1"></i>Buat User + Guru
                        </a>
                    </div>
                    <div class="d-flex gap-2 mb-3">
                        <a href="{{ route('admin.data-master.guru-management.create') }}" class="btn btn-primary">
                            <i class="ti ti-plus"></i>
                            Tambah Guru
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
                                <input type="text" name="search" class="form-control" placeholder="Cari guru..." value="{{ request('search') }}">
                                <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">
                                <button type="submit" class="btn btn-outline-primary">Cari</button>
                                @if(request('search'))
                                    <a href="{{ route('admin.data-master.guru-management.index') }}" class="btn btn-outline-secondary">Reset</a>
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
                                        <h6 class="fw-semibold mb-0">NIP</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Nama Guru</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Bidang Studi</h6>
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
                                @if ($guru->count() == 0)
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            <p class="mb-0 fw-normal">{{ request('search') ? 'Tidak ada data yang sesuai dengan pencarian.' : 'Tidak ada data.' }}</p>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($guru as $item)
                                        <tr>
                                            <td class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">{{ $item->nip ?? '-' }}</h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="mb-0 fw-semibold">{{ $item->nama_guru }}</p>
                                                <small class="text-muted">{{ $item->user->username ?? '' }}</small>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="mb-0">{{ $item->bidang_studi ?? '-' }}</p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <span class="badge {{ $item->status == 'aktif' ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ ucfirst($item->status) }}
                                                </span>
                                            </td>
                                            <td class="border-bottom-0">
                                                <a class="btn btn-outline-info btn-sm"
                                                    href="{{ route('admin.data-master.guru-management.show', $item->guru_id) }}">
                                                    <i class="ti ti-eye"></i>
                                                </a>
                                                <a class="btn btn-outline-warning btn-sm"
                                                    href="{{ route('admin.data-master.guru-management.edit', $item->guru_id) }}">
                                                    <i class="ti ti-edit"></i>
                                                </a>
                                                <form
                                                    action="{{ route('admin.data-master.guru-management.destroy', $item->guru_id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm"
                                                        onclick="return confirm('Yakin ingin menghapus guru ini?')">
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
                    @if($guru->hasPages())
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="text-muted">
                                Menampilkan {{ $guru->firstItem() }} sampai {{ $guru->lastItem() }} dari {{ $guru->total() }} data
                            </div>
                            <nav>
                                {{ $guru->links('pagination::bootstrap-4') }}
                            </nav>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection