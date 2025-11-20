@extends('layout.main')
@section('title', 'Detail Bimbingan Konseling')
@section('content')

    @if (Session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ Session('error') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <!-- Header Info -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="fw-semibold">Informasi Siswa</h6>
                            <p class="mb-1"><strong>Nama:</strong> {{ $bimbinganKonseling->siswa->nama_siswa }}</p>
                            <p class="mb-1"><strong>NIS:</strong> {{ $bimbinganKonseling->siswa->nis }}</p>
                            <p class="mb-0"><strong>Kelas:</strong> {{ $bimbinganKonseling->siswa->kelas->nama_kelas }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-semibold">Informasi Konseling</h6>
                            <p class="mb-1"><strong>Jenis Layanan:</strong> {{ ucfirst($bimbinganKonseling->jenis_layanan) }}</p>
                            <p class="mb-1"><strong>Topik:</strong> {{ $bimbinganKonseling->topik }}</p>
                            <p class="mb-0"><strong>Status:</strong> 
                                @if($bimbinganKonseling->status === 'menunggu')
                                    <span class="badge bg-warning">Menunggu</span>
                                @elseif($bimbinganKonseling->status === 'berkelanjutan')
                                    <span class="badge bg-primary">Berkelanjutan</span>
                                @elseif($bimbinganKonseling->status === 'tindak_lanjut')
                                    <span class="badge bg-info">Tindak Lanjut</span>
                                @elseif($bimbinganKonseling->status === 'selesai')
                                    <span class="badge bg-success">Selesai</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Thread Messages -->
            <div class="card">
                <div class="card-body">
                    <h6 class="fw-semibold mb-3">Percakapan</h6>

                    <!-- Parent Message -->
                    <div class="border rounded p-3 mb-3 bg-light">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <strong class="text-primary">{{ $bimbinganKonseling->siswa->nama_siswa }}</strong>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($bimbinganKonseling->created_at)->format('d M Y H:i') }}</small>
                        </div>
                        <p class="mb-0">{{ $bimbinganKonseling->keluhan_masalah }}</p>
                        @if($bimbinganKonseling->tindakan_solusi)
                            <hr>
                            <div class="bg-success bg-opacity-10 p-2 rounded mt-2">
                                <div class="d-flex justify-content-between align-items-start mb-1">
                                    <strong class="text-success">
                                        @if($bimbinganKonseling->guruKonselor)
                                            {{ $bimbinganKonseling->guruKonselor->nama_guru }}
                                        @elseif($bimbinganKonseling->konselor_user_id)
                                            {{ $bimbinganKonseling->konselorUser->name }} ({{ $bimbinganKonseling->konselor_tim }})
                                        @else
                                            {{ $bimbinganKonseling->konselor_tim }}
                                        @endif
                                    </strong>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($bimbinganKonseling->updated_at)->format('d M Y H:i') }}</small>
                                </div>
                                <strong>Tanggapan:</strong> {{ $bimbinganKonseling->tindakan_solusi }}
                                @if($bimbinganKonseling->hasil_evaluasi)
                                    <br><strong>Evaluasi:</strong> {{ $bimbinganKonseling->hasil_evaluasi }}
                                @endif
                            </div>
                        @endif
                    </div>

                    <!-- Child Messages -->
                    @foreach($bimbinganKonseling->children as $child)
                        <div class="border rounded p-3 mb-3 bg-light">
                            @if($child->keluhan_masalah)
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <strong class="text-primary">{{ $child->siswa->nama_siswa }}</strong>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($child->created_at)->format('d M Y H:i') }}</small>
                                </div>
                                <p class="mb-0">{{ $child->keluhan_masalah }}</p>
                            @endif
                            
                            @if($child->tanggal_tindak_lanjut && !$child->keluhan_masalah)
                                <div class="bg-info bg-opacity-10 p-2 rounded">
                                    <strong class="text-info">Tindak Lanjut Dijadwalkan</strong>
                                    <br><small>Tanggal: {{ \Carbon\Carbon::parse($child->tanggal_tindak_lanjut)->format('d F Y') }}</small>
                                </div>
                            @endif
                            
                            @if($child->tindakan_solusi)
                                <div class="bg-success bg-opacity-10 p-2 rounded mt-2">
                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                        <strong class="text-success">
                                            @if($child->guruKonselor)
                                                {{ $child->guruKonselor->nama_guru }}
                                            @elseif($child->konselor_user_id)
                                                {{ $child->konselorUser->name }} ({{ $child->konselor_tim }})
                                            @else
                                                {{ $child->konselor_tim }}
                                            @endif
                                        </strong>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($child->updated_at)->format('d M Y H:i') }}</small>
                                    </div>
                                    <strong>Tanggapan:</strong> {{ $child->tindakan_solusi }}
                                    @if($child->hasil_evaluasi)
                                        <br><strong>Evaluasi:</strong> {{ $child->hasil_evaluasi }}
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endforeach

                    <!-- Response Forms -->
                    @php $lastChild = $bimbinganKonseling->children->last() ?? $bimbinganKonseling; @endphp

                    @if(in_array(Auth::user()->level, ['admin', 'bimbingan_konseling']))
                        @if($lastChild->status === 'tindak_lanjut' && !$lastChild->tindakan_solusi && $lastChild->tanggal_tindak_lanjut)
                            <!-- Special form for tindak_lanjut response -->
                            <div class="border rounded p-3 bg-info bg-opacity-10">
                                <h6 class="fw-semibold mb-3"><i class="ti ti-calendar-check me-2"></i>Tindak Lanjut - {{ \Carbon\Carbon::parse($lastChild->tanggal_tindak_lanjut)->format('d F Y') }}</h6>
                                <form action="{{ \App\Helpers\RouteHelper::route('bimbingan_konseling.bk.update', $lastChild->bk_id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <textarea class="form-control" name="tindakan_solusi" rows="3" placeholder="Berikan hasil tindak lanjut..."></textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <select class="form-select" name="status">
                                                <option value="berkelanjutan">Berkelanjutan</option>
                                                <option value="selesai">Selesai</option>
                                                <option value="ditolak">Ditolak</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="date" class="form-control" value="{{ date('Y-m-d') }}" readonly>
                                            <input type="hidden" name="tanggal_konseling" value="{{ date('Y-m-d') }}">
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <textarea class="form-control" name="hasil_evaluasi" rows="2" placeholder="Hasil evaluasi tindak lanjut"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-info mt-2">Kirim Hasil Tindak Lanjut</button>
                                </form>
                            </div>
                        @elseif($lastChild->status === 'menunggu' && $lastChild->keluhan_masalah && !$lastChild->tindakan_solusi)
                            <!-- Regular response form -->
                            <div class="border rounded p-3 bg-warning bg-opacity-10">
                                <h6 class="fw-semibold mb-3">Berikan Tanggapan</h6>
                                <form action="{{ \App\Helpers\RouteHelper::route('bimbingan_konseling.bk.update', $lastChild->bk_id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <textarea class="form-control" name="tindakan_solusi" rows="3" placeholder="Berikan tanggapan..."></textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <select class="form-select" name="status">
                                                <option value="berkelanjutan">Berkelanjutan</option>
                                                <option value="tindak_lanjut">Tindak Lanjut</option>
                                                <option value="selesai">Selesai</option>
                                                <option value="ditolak">Ditolak</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="date" class="form-control" value="{{ date('Y-m-d') }}" readonly>
                                            <input type="hidden" name="tanggal_konseling" value="{{ date('Y-m-d') }}">
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <textarea class="form-control" name="hasil_evaluasi" rows="2" placeholder="Hasil evaluasi (opsional)"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-2">Kirim Tanggapan</button>
                                </form>
                            </div>
                        @endif
                    @elseif(Auth::user()->level === 'siswa' && in_array($lastChild->status, ['berkelanjutan', 'tindak_lanjut']) && $lastChild->tindakan_solusi)
                        <div class="border rounded p-3 bg-primary bg-opacity-10">
                            <h6 class="fw-semibold mb-3">Balas Konseling</h6>
                            <form action="{{ \App\Helpers\RouteHelper::route('bimbingan_konseling.bk.reply', $bimbinganKonseling->bk_id) }}" method="POST">
                                @csrf
                                <textarea class="form-control" name="keluhan_masalah" rows="3" placeholder="Sampaikan keluhan lanjutan..."></textarea>
                                <button type="submit" class="btn btn-primary mt-2">Kirim Balasan</button>
                            </form>
                        </div>
                    @elseif(Auth::user()->level === 'siswa' && $lastChild->status === 'tindak_lanjut' && !$lastChild->tindakan_solusi)
                        <div class="alert alert-info">
                            <i class="ti ti-clock me-2"></i>Menunggu hasil tindak lanjut dari konselor ({{ \Carbon\Carbon::parse($lastChild->tanggal_tindak_lanjut)->format('d F Y') }})
                        </div>
                    @endif

                    <div class="mt-3">
                        <a href="{{ \App\Helpers\RouteHelper::route('bimbingan_konseling.bk.index') }}" class="btn btn-secondary">
                            <i class="ti ti-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection