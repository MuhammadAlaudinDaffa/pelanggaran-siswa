@extends('layout.main')

@section('title', 'Detail Overview Siswa')

@section('content')
    <div class="row">
        <div class="col-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-semibold mb-4">Detail Overview Siswa</h5>

                    <!-- Student Photo -->
                    <div class="text-center mb-4">
                        @if($siswa->foto)
                            <img src="{{ asset('storage/siswa/' . $siswa->foto) }}" alt="Foto {{ $siswa->nama_siswa }}"
                                 class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover; border: 4px solid #e9ecef;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center mx-auto rounded-circle" 
                                 style="width: 150px; height: 150px; border: 4px solid #e9ecef;">
                                <div class="text-center">
                                    <i class="ti ti-user text-muted" style="font-size: 36px;"></i>
                                    <p class="text-muted mt-1 mb-0 small">Tidak ada foto</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Student Info -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-semibold">Nama Siswa:</td>
                                    <td>{{ $siswa->nama_siswa }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">NIS:</td>
                                    <td>{{ $siswa->nis }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">NISN:</td>
                                    <td>{{ $siswa->nisn }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-semibold">Kelas:</td>
                                    <td><span class="badge bg-primary">{{ $siswa->kelas->nama_kelas ?? '-' }}</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Jurusan:</td>
                                    <td>{{ $siswa->kelas->jurusan->nama_jurusan ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Jenis Kelamin:</td>
                                    <td>{{ ucfirst($siswa->jenis_kelamin) }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Total Poin:</td>
                                    <td>
                                        @php
                                            $totalPelanggaranPoin = $pelanggaran->sum('poin');
                                            $totalPrestasiPoin = $prestasi->sum('poin');
                                        @endphp
                                        <div class="d-flex gap-2">
                                            @if($totalPelanggaranPoin > 0)
                                                <span class="badge bg-danger rounded-3 fw-semibold">{{ $totalPelanggaranPoin }}</span>
                                            @else
                                                <span class="text-muted">0</span>
                                            @endif
                                            <span class="text-muted">/</span>
                                            @if($totalPrestasiPoin > 0)
                                                <span class="badge bg-success rounded-3 fw-semibold">{{ $totalPrestasiPoin }}</span>
                                            @else
                                                <span class="text-muted">0</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Tabs -->
                    <ul class="nav nav-tabs" id="overviewTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pelanggaran-tab" data-bs-toggle="tab" 
                                    data-bs-target="#pelanggaran" type="button" role="tab">
                                <i class="ti ti-alert-triangle me-2"></i>Pelanggaran ({{ $pelanggaran->count() }})
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="prestasi-tab" data-bs-toggle="tab" 
                                    data-bs-target="#prestasi" type="button" role="tab">
                                <i class="ti ti-trophy me-2"></i>Prestasi ({{ $prestasi->count() }})
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content mt-3" id="overviewTabsContent">
                        <!-- Pelanggaran Tab -->
                        <div class="tab-pane fade show active" id="pelanggaran" role="tabpanel">
                            @if($pelanggaran->count() > 0)
                                <div class="table-responsive">
                                    <table class="table text-nowrap mb-0 align-middle">
                                        <thead class="text-dark fs-4">
                                            <tr>
                                                <th class="border-bottom-0">Jenis Pelanggaran</th>
                                                <th class="border-bottom-0">Status</th>
                                                <th class="border-bottom-0">Tanggal</th>
                                                @if(in_array(Auth::user()->level, ['admin', 'kesiswaan', 'kepala_sekolah']))
                                                    <th class="border-bottom-0">Guru Pencatat</th>
                                                @endif
                                                <th class="border-bottom-0">Verifikator</th>
                                                @if(in_array(Auth::user()->level, ['admin', 'kesiswaan', 'kepala_sekolah']))
                                                    <th class="border-bottom-0">Sanksi/Monitor</th>
                                                @endif
                                                <th class="border-bottom-0">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pelanggaran as $p)
                                                <tr>
                                                    <td class="border-bottom-0">
                                                        <h6 class="fw-semibold mb-1">{{ $p->jenisPelanggaran->nama_pelanggaran }}</h6>
                                                        <span class="text-muted">{{ $p->jenisPelanggaran->kategoriPelanggaran->nama_kategori ?? '' }}</span>
                                                    </td>
                                                    <td class="border-bottom-0">
                                                        @php
                                                            $status = '';
                                                            $badgeClass = '';
                                                            if ($p->poin >= 1 && $p->poin <= 15) {
                                                                $status = 'Ringan';
                                                                $badgeClass = 'bg-info';
                                                            } elseif ($p->poin >= 16 && $p->poin <= 30) {
                                                                $status = 'Sedang';
                                                                $badgeClass = 'bg-warning';
                                                            } elseif ($p->poin >= 31 && $p->poin <= 50) {
                                                                $status = 'Berat';
                                                                $badgeClass = 'bg-danger';
                                                            } elseif ($p->poin >= 51) {
                                                                $status = 'Sangat Berat';
                                                                $badgeClass = 'bg-dark';
                                                            }
                                                        @endphp
                                                        <span class="badge {{ $badgeClass }} rounded-3 fw-semibold">{{ $status }} - {{ $p->poin }}</span>
                                                    </td>
                                                    <td class="border-bottom-0">{{ \Carbon\Carbon::parse($p->tanggal)->format('d/m/Y') }}</td>
                                                    @if(in_array(Auth::user()->level, ['admin', 'kesiswaan', 'kepala_sekolah']))
                                                        <td class="border-bottom-0">{{ $p->guruPencatat->nama_guru ?? '-' }}</td>
                                                    @endif
                                                    <td class="border-bottom-0">
                                                        @if($p->guruVerifikator)
                                                            {{ $p->guruVerifikator->nama_guru }}
                                                        @elseif($p->verifikator_tim)
                                                            {{ $p->verifikator_tim }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    @if(in_array(Auth::user()->level, ['admin', 'kesiswaan', 'kepala_sekolah']))
                                                        <td class="border-bottom-0">
                                                            @php
                                                                $sanksi = \App\Models\Sanksi::where('pelanggaran_id', $p->pelanggaran_id)->first();
                                                                $monitoring = \App\Models\MonitoringPelanggaran::where('pelanggaran_id', $p->pelanggaran_id)->first();
                                                            @endphp
                                                            <div class="d-flex gap-1">
                                                                @if($sanksi)
                                                                    <span class="badge bg-warning">Sanksi</span>
                                                                @endif
                                                                @if($monitoring)
                                                                    <span class="badge bg-info">Monitor</span>
                                                                @endif
                                                                @if(!$sanksi && !$monitoring)
                                                                    <span class="text-muted">-</span>
                                                                @endif
                                                            </div>
                                                        </td>
                                                    @endif
                                                    <td class="border-bottom-0">
                                                        @if(Auth::user()->level === 'orang_tua')
                                                            <a href="{{ route('orang_tua.kesiswaan.pelanggaran.show', $p->pelanggaran_id) }}?from=siswa_overview&siswa_id={{ $siswa->siswa_id }}"
                                                                class="btn btn-outline-primary btn-sm">
                                                                <i class="ti ti-eye fs-4"></i>
                                                            </a>
                                                        @else
                                                            <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.pelanggaran.show', $p->pelanggaran_id) }}?from=siswa_overview&siswa_id={{ $siswa->siswa_id }}"
                                                                class="btn btn-outline-primary btn-sm">
                                                                <i class="ti ti-eye fs-4"></i>
                                                            </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="ti ti-alert-triangle fs-1 text-muted mb-2"></i>
                                    <p class="text-muted mb-0">Tidak ada data pelanggaran</p>
                                </div>
                            @endif
                        </div>

                        <!-- Prestasi Tab -->
                        <div class="tab-pane fade" id="prestasi" role="tabpanel">
                            @if($prestasi->count() > 0)
                                <div class="table-responsive">
                                    <table class="table text-nowrap mb-0 align-middle">
                                        <thead class="text-dark fs-4">
                                            <tr>
                                                <th class="border-bottom-0">Jenis Prestasi</th>
                                                <th class="border-bottom-0">Tingkat</th>
                                                <th class="border-bottom-0">Poin</th>
                                                <th class="border-bottom-0">Tanggal</th>
                                                @if(in_array(Auth::user()->level, ['admin', 'kesiswaan', 'kepala_sekolah']))
                                                    <th class="border-bottom-0">Guru Pencatat</th>
                                                @endif
                                                <th class="border-bottom-0">Verifikator</th>
                                                <th class="border-bottom-0">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($prestasi as $pr)
                                                <tr>
                                                    <td class="border-bottom-0">
                                                        <h6 class="fw-semibold mb-1">{{ $pr->jenisPrestasi->nama_prestasi }}</h6>
                                                        <span class="text-muted">{{ $pr->jenisPrestasi->kategoriPrestasi->nama_kategori ?? '' }}</span>
                                                    </td>
                                                    <td class="border-bottom-0">
                                                        @if($pr->tingkat)
                                                            <span class="badge bg-info rounded-3 fw-semibold">{{ ucfirst($pr->tingkat) }}</span>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                    <td class="border-bottom-0">
                                                        <span class="badge bg-success rounded-3 fw-semibold">+{{ $pr->poin }}</span>
                                                    </td>
                                                    <td class="border-bottom-0">{{ \Carbon\Carbon::parse($pr->tanggal)->format('d/m/Y') }}</td>
                                                    @if(in_array(Auth::user()->level, ['admin', 'kesiswaan', 'kepala_sekolah']))
                                                        <td class="border-bottom-0">{{ $pr->guruPencatat->nama_guru ?? '-' }}</td>
                                                    @endif
                                                    <td class="border-bottom-0">
                                                        @if($pr->guruVerifikator)
                                                            {{ $pr->guruVerifikator->nama_guru }}
                                                        @elseif($pr->verifikator_tim)
                                                            {{ $pr->verifikator_tim }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td class="border-bottom-0">
                                                        @if(Auth::user()->level === 'orang_tua')
                                                            <a href="{{ route('orang_tua.kesiswaan.prestasi.show', $pr->prestasi_id) }}?from=siswa_overview&siswa_id={{ $siswa->siswa_id }}"
                                                                class="btn btn-outline-primary btn-sm">
                                                                <i class="ti ti-eye fs-4"></i>
                                                            </a>
                                                        @else
                                                            <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.prestasi.show', $pr->prestasi_id) }}?from=siswa_overview&siswa_id={{ $siswa->siswa_id }}"
                                                                class="btn btn-outline-primary btn-sm">
                                                                <i class="ti ti-eye fs-4"></i>
                                                            </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="ti ti-trophy fs-1 text-muted mb-2"></i>
                                    <p class="text-muted mb-0">Tidak ada data prestasi</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-4">
                        @if(Auth::user()->level === 'siswa')
                            <a href="{{ route('siswa.index') }}" class="btn btn-secondary">
                                <i class="ti ti-arrow-left"></i> Kembali ke Dashboard
                            </a>
                        @elseif(Auth::user()->level === 'orang_tua')
                            <a href="{{ route('orang_tua.index') }}" class="btn btn-secondary">
                                <i class="ti ti-arrow-left"></i> Kembali ke Dashboard
                            </a>
                        @else
                            <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.siswa_overview.index') }}" class="btn btn-secondary">
                                <i class="ti ti-arrow-left"></i> Kembali
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection