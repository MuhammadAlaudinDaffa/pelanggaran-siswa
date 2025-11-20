@extends('layout.main')
@section('title', 'Detail Kategori Pelanggaran')
@section('content')
    <div class="row">
        <div class="col-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-semibold mb-4">Detail Kategori Pelanggaran</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-semibold">ID:</td>
                                    <td>{{ $kategoriPelanggaran->kategori_pelanggaran_id }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Nama Kategori:</td>
                                    <td>{{ $kategoriPelanggaran->nama_kategori }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Deskripsi:</td>
                                    <td>{{ $kategoriPelanggaran->deskripsi }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-3">
                        <a href="{{ route('admin.data-master.kategori-pelanggaran.edit', $kategoriPelanggaran->kategori_pelanggaran_id) }}" class="btn btn-warning">
                            <i class="ti ti-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.data-master.kategori-pelanggaran.index') }}" class="btn btn-secondary">
                            <i class="ti ti-arrow-left"></i> Kembali
                        </a>
                        <form action="{{ route('admin.data-master.kategori-pelanggaran.destroy', $kategoriPelanggaran->kategori_pelanggaran_id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus kategori ini?')">
                                <i class="ti ti-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection