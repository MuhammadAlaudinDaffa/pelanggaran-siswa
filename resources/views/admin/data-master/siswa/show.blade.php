@extends('layout.main')
@section('title', 'Detail Siswa')
@section('content')
    <div class="row">
        <div class="col-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-semibold mb-4">Detail Siswa</h5>
                    
                    <!-- Foto Siswa -->
                    <div class="text-center mb-4">
                        @if($siswa->foto)
                            <img src="{{ asset('storage/' . $siswa->foto) }}" alt="Foto {{ $siswa->nama_siswa }}" 
                                 class="img-thumbnail" style="width: 200px; height: 200px; object-fit: cover; border-radius: 12px;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center mx-auto" 
                                 style="width: 200px; height: 200px; border-radius: 12px; border: 2px dashed #dee2e6;">
                                <div class="text-center">
                                    <i class="ti ti-user text-muted" style="font-size: 48px;"></i>
                                    <p class="text-muted mt-2 mb-0">Tidak ada foto</p>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-semibold">ID:</td>
                                    <td>{{ $siswa->siswa_id }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">User:</td>
                                    <td>{{ $siswa->user->nama_lengkap ?? '-' }} ({{ $siswa->user->username ?? '-' }})</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">NIS:</td>
                                    <td>{{ $siswa->nis }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">NISN:</td>
                                    <td>{{ $siswa->nisn ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Nama Siswa:</td>
                                    <td>{{ $siswa->nama_siswa }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Tempat Lahir:</td>
                                    <td>{{ $siswa->tempat_lahir ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Tanggal Lahir:</td>
                                    <td>{{ $siswa->tanggal_lahir ? date('d F Y', strtotime($siswa->tanggal_lahir)) : '-' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-semibold">Jenis Kelamin:</td>
                                    <td>
                                        @if($siswa->jenis_kelamin)
                                            <span class="badge {{ $siswa->jenis_kelamin == 'laki-laki' ? 'bg-info' : 'bg-warning' }}">
                                                {{ ucfirst($siswa->jenis_kelamin) }}
                                            </span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Alamat:</td>
                                    <td>{{ $siswa->alamat ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">No Telepon:</td>
                                    <td>{{ $siswa->no_telp ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Kelas:</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $siswa->kelas->nama_kelas ?? '-' }} - {{ $siswa->kelas->jurusan->nama_jurusan ?? '' }}</span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-3">
                        <a href="{{ route('admin.data-master.siswa.edit', $siswa->siswa_id) }}" class="btn btn-warning">
                            <i class="ti ti-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.data-master.siswa.index') }}" class="btn btn-secondary">
                            <i class="ti ti-arrow-left"></i> Kembali
                        </a>
                        <form action="{{ route('admin.data-master.siswa.destroy', $siswa->siswa_id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus siswa ini?')">
                                <i class="ti ti-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection