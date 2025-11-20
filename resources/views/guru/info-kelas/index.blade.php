@extends('layout.main')
@section('title', 'Informasi Kelas')
@section('content')

    @if (Session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ Session('success') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (Session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ Session('error') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(isset($noGuruData) && $noGuruData)
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="ti ti-user-exclamation fs-1 text-warning mb-3"></i>
                        <h5 class="text-warning mb-3">Data Guru Tidak Ditemukan</h5>
                        <p class="text-muted">Anda tidak termasuk dari data guru, komunikasikan dengan admin aplikasi untuk bantuan lebih lanjut</p>
                    </div>
                </div>
            </div>
        </div>
    @else

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h5 class="card-title fw-semibold mb-1">Informasi Kelas</h5>
                            @if($kelas)
                                <p class="text-muted mb-0">{{ $kelas->nama_kelas }} - {{ $kelas->jurusan->nama_jurusan ?? '' }}</p>
                            @else
                                <p class="text-muted mb-0">Anda belum menjadi wali kelas</p>
                            @endif
                        </div>
                        @if($isWaliKelas)
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#pesanModal">
                                <i class="ti ti-plus me-2"></i>Kirim Pesan
                            </button>
                        @endif
                    </div>

                    @if($messages->count() > 0)
                        <div class="row">
                            @foreach($messages as $message)
                                @php
                                    $priorityColors = [
                                        'rendah' => 'border-success bg-success bg-opacity-10',
                                        'sedang' => 'border-info bg-info bg-opacity-10', 
                                        'tinggi' => 'border-warning bg-warning bg-opacity-10',
                                        'penting' => 'border-danger bg-danger bg-opacity-10',
                                        'darurat' => 'border-danger bg-danger bg-opacity-10'
                                    ];
                                    $priorityBadges = [
                                        'rendah' => 'bg-success',
                                        'sedang' => 'bg-info',
                                        'tinggi' => 'bg-warning',
                                        'penting' => 'bg-danger',
                                        'darurat' => 'bg-danger'
                                    ];
                                @endphp
                                <div class="col-12 mb-3">
                                    <div class="card {{ $priorityColors[$message->prioritas_pesan] }}">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <span class="badge {{ $priorityBadges[$message->prioritas_pesan] }}">{{ ucfirst($message->prioritas_pesan) }}</span>
                                            </div>
                                            <p class="card-text">{{ $message->pesan }}</p>
                                            <small class="text-muted">
                                                <i class="ti ti-user me-1"></i>{{ $message->guru->nama_guru }}
                                                <i class="ti ti-clock ms-3 me-1"></i>{{ \Carbon\Carbon::parse($message->created_at)->format('d M Y H:i') }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="ti ti-message-circle fs-1 text-muted mb-3"></i>
                            <h6 class="text-muted">Belum ada pesan untuk kelas ini</h6>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Kirim Pesan -->
    @if($isWaliKelas)
    <div class="modal fade" id="pesanModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Kirim Pesan ke Kelas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ \App\Helpers\RouteHelper::route('guru.info_kelas.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Prioritas</label>
                            <select class="form-select" name="prioritas_pesan" required>
                                <option value="rendah">Rendah</option>
                                <option value="sedang" selected>Sedang</option>
                                <option value="tinggi">Tinggi</option>
                                <option value="penting">Penting</option>
                                <option value="darurat">Darurat</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Pesan</label>
                            <textarea class="form-control" name="pesan" rows="5" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Kirim Pesan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
    @endif

@endsection