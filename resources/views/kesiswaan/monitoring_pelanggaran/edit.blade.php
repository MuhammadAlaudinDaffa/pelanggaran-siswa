@extends('layout.main')

@section('title', 'Edit Monitoring Pelanggaran')

@section('content')
    <div class="row">
        <div class="col-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-semibold mb-4">Edit Monitoring Pelanggaran</h5>

                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="alert alert-info">
                                <h6 class="fw-semibold mb-2">Data Pelanggaran:</h6>
                                <p class="mb-1"><strong>Siswa:</strong> {{ $monitoring->pelanggaran->siswa->nama_siswa }} ({{ $monitoring->pelanggaran->siswa->nis }})</p>
                                <p class="mb-1"><strong>Kelas:</strong> {{ $monitoring->pelanggaran->siswa->kelas->nama_kelas }}</p>
                                <p class="mb-0"><strong>Jenis Pelanggaran:</strong> {{ $monitoring->pelanggaran->jenisPelanggaran->nama_pelanggaran }}</p>
                            </div>
                        </div>
                    </div>

                    <form action="{{ \App\Helpers\RouteHelper::route('kesiswaan.monitoring_pelanggaran.update', $monitoring->monitoring_id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Status Monitoring <span class="text-danger">*</span></label>
                                    <select class="form-select @error('status_monitoring') is-invalid @enderror" name="status_monitoring" required>
                                        <option value="">Pilih status...</option>
                                        <option value="dipantau" {{ old('status_monitoring', $monitoring->status_monitoring) == 'dipantau' ? 'selected' : '' }}>Dipantau</option>
                                        <option value="tindak_lanjut" {{ old('status_monitoring', $monitoring->status_monitoring) == 'tindak_lanjut' ? 'selected' : '' }}>Tindak Lanjut</option>
                                        <option value="progres_baik" {{ old('status_monitoring', $monitoring->status_monitoring) == 'progres_baik' ? 'selected' : '' }}>Progres Baik</option>
                                        <option value="selesai" {{ old('status_monitoring', $monitoring->status_monitoring) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                        <option value="eskalasi" {{ old('status_monitoring', $monitoring->status_monitoring) == 'eskalasi' ? 'selected' : '' }}>Eskalasi</option>
                                    </select>
                                    @error('status_monitoring')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Monitoring <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('tanggal_monitoring') is-invalid @enderror" 
                                           name="tanggal_monitoring" value="{{ $monitoring->tanggal_monitoring->format('Y-m-d') }}" readonly required>
                                    @error('tanggal_monitoring')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Catatan Monitoring</label>
                            <textarea class="form-control @error('catatan_monitoring') is-invalid @enderror" 
                                      name="catatan_monitoring" rows="4" placeholder="Masukkan catatan monitoring...">{{ old('catatan_monitoring', $monitoring->catatan_monitoring) }}</textarea>
                            @error('catatan_monitoring')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tindak Lanjut</label>
                            <input type="text" class="form-control @error('tindak_lanjut') is-invalid @enderror" 
                                   name="tindak_lanjut" value="{{ old('tindak_lanjut', $monitoring->tindak_lanjut) }}" placeholder="Masukkan tindak lanjut...">
                            @error('tindak_lanjut')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-device-floppy"></i> Update
                            </button>
                            <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.monitoring_pelanggaran.show', $monitoring->monitoring_id) }}" class="btn btn-secondary">
                                <i class="ti ti-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection