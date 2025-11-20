@extends('layout.main')
@section('title', 'Detail Guru')
@section('content')
    <div class="row">
        <div class="col-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-semibold mb-4">Detail Guru</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-semibold">ID:</td>
                                    <td>{{ $guru->guru_id }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">NIP:</td>
                                    <td>{{ $guru->nip ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Nama Guru:</td>
                                    <td>{{ $guru->nama_guru }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Jenis Kelamin:</td>
                                    <td>{{ $guru->jenis_kelamin }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Bidang Studi:</td>
                                    <td>{{ $guru->bidang_studi ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Email:</td>
                                    <td>{{ $guru->email ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">No. Telp:</td>
                                    <td>{{ $guru->no_telp ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Status:</td>
                                    <td>
                                        <span class="badge {{ $guru->status == 'aktif' ? 'bg-success' : 'bg-secondary' }}">
                                            {{ ucfirst($guru->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @if($guru->user)
                                <tr>
                                    <td class="fw-semibold">Username:</td>
                                    <td>{{ $guru->user->username }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-3">
                        <a href="{{ route('admin.data-master.guru-management.edit', $guru->guru_id) }}" class="btn btn-warning">
                            <i class="ti ti-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.data-master.guru-management.index') }}" class="btn btn-secondary">
                            <i class="ti ti-arrow-left"></i> Kembali
                        </a>
                        <form action="{{ route('admin.data-master.guru-management.destroy', $guru->guru_id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus guru ini?')">
                                <i class="ti ti-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection