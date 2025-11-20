@extends('layout.main')
@section('title', 'Detail Tahun Ajaran')
@section('content')
    <div class="row">
        <div class="col-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-semibold mb-4">Detail Tahun Ajaran</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-semibold">ID:</td>
                                    <td>{{ $tahunAjaran->tahun_ajaran_id }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Kode Tahun:</td>
                                    <td>{{ $tahunAjaran->kode_tahun }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Tahun Ajaran:</td>
                                    <td>{{ $tahunAjaran->tahun_ajaran }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Semester:</td>
                                    <td>
                                        <span class="badge bg-info">Semester {{ $tahunAjaran->semester }}</span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-semibold">Status:</td>
                                    <td>
                                        <span class="badge {{ $tahunAjaran->status_aktif ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $tahunAjaran->status_aktif ? 'Aktif' : 'Tidak Aktif' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Tanggal Mulai:</td>
                                    <td>{{ date('d F Y', strtotime($tahunAjaran->tanggal_mulai)) }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Tanggal Selesai:</td>
                                    <td>{{ date('d F Y', strtotime($tahunAjaran->tanggal_selesai)) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-3">
                        <a href="{{ route('admin.data-master.tahun-ajaran.edit', $tahunAjaran->tahun_ajaran_id) }}" class="btn btn-warning">
                            <i class="ti ti-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.data-master.tahun-ajaran.index') }}" class="btn btn-secondary">
                            <i class="ti ti-arrow-left"></i> Kembali
                        </a>
                        <form action="{{ route('admin.data-master.tahun-ajaran.destroy', $tahunAjaran->tahun_ajaran_id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus tahun ajaran ini?')">
                                <i class="ti ti-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection