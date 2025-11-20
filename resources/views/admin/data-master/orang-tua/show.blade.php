@extends('layout.main')
@section('title', 'Detail Orang Tua')
@section('content')
    <div class="row">
        <div class="col-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-semibold mb-4">Detail Orang Tua</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-semibold">ID:</td>
                                    <td>{{ $orangTua->id }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Nama Lengkap:</td>
                                    <td>
                                        <h6 class="mb-0">{{ $orangTua->user->nama_lengkap ?? '-' }}</h6>
                                        <small class="text-muted">{{ $orangTua->user->username ?? '' }}</small>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Hubungan:</td>
                                    <td>
                                        <span class="badge bg-info">{{ $orangTua->hubungan }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Pekerjaan:</td>
                                    <td>{{ $orangTua->pekerjaan }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-semibold">Nama Siswa:</td>
                                    <td>
                                        <h6 class="mb-0">{{ $orangTua->siswa->nama_siswa ?? '-' }}</h6>
                                        <small class="text-muted">NIS: {{ $orangTua->siswa->nis ?? '' }}</small>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Kelas Siswa:</td>
                                    <td>
                                        @if($orangTua->siswa && $orangTua->siswa->kelas)
                                            <span class="badge bg-primary">{{ $orangTua->siswa->kelas->nama_kelas }}</span>
                                            <br><small class="text-muted">{{ $orangTua->siswa->kelas->jurusan }}</small>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Alamat:</td>
                                    <td>{{ $orangTua->alamat }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-3">
                        <a href="{{ route('orang-tua.index') }}" class="btn btn-secondary">
                            <i class="ti ti-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection