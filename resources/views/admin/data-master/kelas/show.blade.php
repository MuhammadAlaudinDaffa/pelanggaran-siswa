@extends('layout.main')
@section('title', 'Detail Kelas')
@section('content')
    <div class="row">
        <div class="col-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-semibold mb-4">Detail Kelas</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-semibold">ID:</td>
                                    <td>{{ $kelas->kelas_id }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Nama Kelas:</td>
                                    <td>{{ $kelas->nama_kelas }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Jurusan:</td>
                                    <td>{{ $kelas->jurusan->nama_jurusan ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Kapasitas:</td>
                                    <td>
                                        <span class="badge bg-info">{{ $kelas->kapasitas }} siswa</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Wali Kelas:</td>
                                    <td>{{ $kelas->waliKelas->nama_guru ?? 'Belum ditentukan' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-3">
                        <a href="{{ route('admin.data-master.kelas.edit', $kelas->kelas_id) }}" class="btn btn-warning">
                            <i class="ti ti-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.data-master.kelas.index') }}" class="btn btn-secondary">
                            <i class="ti ti-arrow-left"></i> Kembali
                        </a>
                        <form action="{{ route('admin.data-master.kelas.destroy', $kelas->kelas_id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus kelas ini?')">
                                <i class="ti ti-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection