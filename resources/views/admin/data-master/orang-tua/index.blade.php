@extends('layout.main')
@section('title', 'Daftar Orang Tua')
@section('content')
    <div class="row">
        <div class="col-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-semibold mb-4">Daftar Orang Tua</h5>
                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">ID</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Nama Orang Tua</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Siswa</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Hubungan</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Pekerjaan</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Aksi</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($orangTua->isEmpty())
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            <p class="mb-0 fw-normal">Tidak ada data.</p>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($orangTua as $item)
                                        <tr>
                                            <td class="border-bottom-0">
                                                {{ $item->orangtua_id }}
                                            </td>
                                            <td class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">{{ $item->nama_orangtua ?? '-' }}</h6>
                                                <small class="text-muted">{{ $item->user->username ?? '' }}</small>
                                            </td>
                                            <td class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">{{ $item->siswa->nama_siswa ?? '-' }}</h6>
                                                <small class="text-muted">{{ $item->siswa->nis ?? '' }}</small>
                                            </td>
                                            <td class="border-bottom-0">
                                                <span class="badge bg-info">{{ $item->hubungan }}</span>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="mb-0 fw-semibold">{{ $item->pekerjaan }}</p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <a class="btn btn-outline-info btn-sm" href="{{ route('orang-tua.show', $item->orangtua_id) }}">
                                                    <i class="ti ti-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection