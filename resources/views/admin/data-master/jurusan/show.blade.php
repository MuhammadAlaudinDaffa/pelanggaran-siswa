@extends('layout.main')
@section('title', 'Detail Jurusan')
@section('content')
    <div class="row">
        <div class="col-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-semibold mb-4">Detail Jurusan</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">ID</label>
                                <p class="form-control-plaintext">{{ $jurusan->jurusan_id }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nama Jurusan</label>
                                <p class="form-control-plaintext">{{ $jurusan->nama_jurusan }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Deskripsi</label>
                                <p class="form-control-plaintext">{{ $jurusan->deskripsi }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Dibuat Pada</label>
                                <p class="form-control-plaintext">{{ $jurusan->created_at }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.data-master.jurusan.edit', $jurusan->jurusan_id) }}"
                            class="btn btn-warning">
                            <i class="ti ti-edit"></i>
                            Edit
                        </a>
                        <a href="{{ route('admin.data-master.jurusan.index') }}" class="btn btn-secondary">
                            <i class="ti ti-arrow-left"></i>
                            Kembali
                        </a>
                        <form action="{{ route('admin.data-master.jurusan.destroy', $jurusan->jurusan_id) }}" method="POST"
                            class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Yakin ingin menghapus jurusan ini?')">
                                <i class="ti ti-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection