@extends('layout.main')
@section('title', 'Detail User')
@section('content')
    <div class="row">
        <div class="col-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-semibold mb-4">Detail User</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-semibold">ID:</td>
                                    <td>{{ $user->user_id }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Username:</td>
                                    <td>{{ $user->username }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Nama Lengkap:</td>
                                    <td>{{ $user->nama_lengkap }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Level:</td>
                                    <td>
                                        <span class="badge bg-primary">{{ ucfirst(str_replace('_', ' ', $user->level)) }}</span>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="fw-semibold">Can Verify:</td>
                                    <td>
                                        <span class="badge {{ $user->can_verify ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $user->can_verify ? 'Ya' : 'Tidak' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Status:</td>
                                    <td>
                                        <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-danger' }}">
                                            {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Last Login:</td>
                                    <td>{{ $user->last_login ? date('d/m/Y H:i', strtotime($user->last_login)) : '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-3">
                        @if ($user->user_id !== 1)
                            <a href="{{ route('admin.data-master.user.edit', $user->user_id) }}" class="btn btn-warning">
                                <i class="ti ti-edit"></i> Edit
                            </a>
                        @endif
                        <a href="{{ route('admin.data-master.user.index') }}" class="btn btn-secondary">
                            <i class="ti ti-arrow-left"></i> Kembali
                        </a>
                        @if ($user->user_id !== 1)
                            <form action="{{ route('admin.data-master.user.destroy', $user->user_id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus user ini?')">
                                    <i class="ti ti-trash"></i> Hapus
                                </button>
                            </form>
                        @else
                            <span class="badge bg-warning fs-6">User ini dilindungi dan tidak dapat dimodifikasi</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection