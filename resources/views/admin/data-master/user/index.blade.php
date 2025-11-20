@extends('layout.main')
@section('title', 'Daftar User')
@section('content')
    <div class="row">
        <div class="col-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-semibold mb-4">Daftar User</h5>
                    <div class="d-flex gap-2 mb-3">
                        <a href="{{ route('admin.data-master.user.create') }}" class="btn btn-primary">
                            <i class="ti ti-plus"></i>
                            Tambah User
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
                                <input type="text" name="search" class="form-control" placeholder="Cari user..." value="{{ request('search') }}">
                                <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">
                                <button type="submit" class="btn btn-outline-primary">Cari</button>
                                @if(request('search'))
                                    <a href="{{ route('admin.data-master.user.index') }}" class="btn btn-outline-secondary">Reset</a>
                                @endif
                            </form>
                        </div>
                        <div class="col-md-6 text-end">
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
                                        <h6 class="fw-semibold mb-0">Id</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Username</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Nama Lengkap</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Level</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Can Verify</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Status</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Last Login</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Aksi</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($users->count() == 0)
                                    <tr>
                                        <td colspan="8" class="text-center">
                                            <p class="mb-0 fw-normal">{{ request('search') ? 'Tidak ada data yang sesuai dengan pencarian.' : 'Tidak ada data.' }}</p>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($users as $user)
                                        <tr class="{{ !$user->is_active ? 'table-secondary opacity-75' : '' }}">
                                            <td class="border-bottom-0 {{ !$user->is_active ? 'text-muted' : '' }}">
                                                {{ $user->user_id }}
                                            </td>
                                            <td class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0 {{ !$user->is_active ? 'text-muted' : '' }}">
                                                    {{ $user->username }}</h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="mb-0 fw-semibold {{ !$user->is_active ? 'text-muted' : '' }}">
                                                    {{ $user->nama_lengkap }}</p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <span
                                                    class="badge bg-primary">{{ ucfirst(str_replace('_', ' ', $user->level)) }}</span>
                                            </td>
                                            <td class="border-bottom-0">
                                                <span class="badge {{ $user->can_verify ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $user->can_verify ? 'Ya' : 'Tidak' }}
                                                </span>
                                            </td>
                                            <td class="border-bottom-0">
                                                <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                                </span>
                                            </td>
                                            <td class="border-bottom-0">
                                                <small class="{{ !$user->is_active ? 'text-muted' : '' }}">
                                                    {{ $user->last_login ? date('d/m/Y H:i', strtotime($user->last_login)) : '-' }}
                                                </small>
                                            </td>
                                            <td class="border-bottom-0">
                                                <a class="btn btn-outline-info btn-sm"
                                                    href="{{ route('admin.data-master.user.show', $user->user_id) }}">
                                                    <i class="ti ti-eye"></i>
                                                </a>
                                                @if ($user->user_id !== 1)
                                                    <a class="btn btn-outline-warning btn-sm"
                                                        href="{{ route('admin.data-master.user.edit', $user->user_id) }}">
                                                        <i class="ti ti-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.data-master.user.destroy', $user->user_id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger btn-sm"
                                                            onclick="return confirm('Yakin ingin menghapus user ini?')">
                                                            <i class="ti ti-trash"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="badge bg-warning">Protected</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    @if($users->hasPages())
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="text-muted">
                                Menampilkan {{ $users->firstItem() }} sampai {{ $users->lastItem() }} dari {{ $users->total() }} data
                            </div>
                            <nav>
                                {{ $users->links('pagination::bootstrap-4') }}
                            </nav>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection