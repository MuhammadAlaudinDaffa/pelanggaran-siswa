@extends('layout.main')
@section('title', 'Detail Jenis Prestasi')
@section('content')
    <div class="row">
        <div class="col-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-semibold mb-4">Detail Jenis Prestasi</h5>
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{ session('success') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-semibold">ID:</td>
                                    <td>{{ $prestasi->jenis_prestasi_id }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Nama Prestasi:</td>
                                    <td>{{ $prestasi->nama_prestasi }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Poin:</td>
                                    <td><span class="badge bg-success">{{ $prestasi->poin }} poin</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Kategori:</td>
                                    <td>{{ $prestasi->kategoriPrestasi->nama_kategori ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Reward:</td>
                                    <td>{{ $prestasi->reward ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Deskripsi:</td>
                                    <td>{{ $prestasi->deskripsi ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-3">
                        <a href="{{ route('admin.data-master.jenis-prestasi.edit', $prestasi->jenis_prestasi_id) }}" class="btn btn-warning">
                            <i class="ti ti-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.data-master.jenis-prestasi.index') }}" class="btn btn-secondary">
                            <i class="ti ti-arrow-left"></i> Kembali
                        </a>
                        <form action="{{ route('admin.data-master.jenis-prestasi.destroy', $prestasi->jenis_prestasi_id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus jenis prestasi ini?')">
                                <i class="ti ti-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection