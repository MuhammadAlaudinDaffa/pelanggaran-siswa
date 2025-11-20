@extends('layout.main')

@section('title', 'Edit Sanksi')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">
                            <i class="fas fa-edit me-2"></i>Edit Sanksi
                        </h4>
                    </div>
                    <div class="card-body">
                        <!-- Pelanggaran Info (Read Only) -->
                        <div class="alert alert-info">
                            <h6><i class="fas fa-info-circle me-2"></i>Informasi Pelanggaran</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Siswa:</strong> {{ $sanksi->pelanggaran->siswa->nama_siswa }}<br>
                                    <strong>NIS:</strong> {{ $sanksi->pelanggaran->siswa->nis }}<br>
                                    <strong>Kelas:</strong> {{ $sanksi->pelanggaran->siswa->kelas->nama_kelas ?? 'N/A' }}
                                </div>
                                <div class="col-md-6">
                                    <strong>Jenis Pelanggaran:</strong> {{ $sanksi->pelanggaran->jenisPelanggaran->nama_pelanggaran }}<br>
                                    <strong>Poin:</strong> {{ $sanksi->pelanggaran->poin }}<br>
                                    <strong>Tanggal:</strong> {{ date('d/m/Y', strtotime($sanksi->pelanggaran->tanggal)) }}
                                </div>
                            </div>
                        </div>

                        <form action="{{ \App\Helpers\RouteHelper::route('kesiswaan.sanksi.update', $sanksi) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="jenis_sanksi" class="form-label">Jenis Sanksi <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('jenis_sanksi') is-invalid @enderror" 
                                               name="jenis_sanksi" id="jenis_sanksi" 
                                               value="{{ old('jenis_sanksi', $sanksi->jenis_sanksi) }}" required>
                                        @error('jenis_sanksi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                        <select class="form-select @error('status') is-invalid @enderror" name="status" id="status" required>
                                            <option value="direncanakan" {{ old('status', $sanksi->status) == 'direncanakan' ? 'selected' : '' }}>Direncanakan</option>
                                            <option value="berjalan" {{ old('status', $sanksi->status) == 'berjalan' ? 'selected' : '' }}>Berjalan</option>
                                            <option value="selesai" {{ old('status', $sanksi->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                            <option value="ditunda" {{ old('status', $sanksi->status) == 'ditunda' ? 'selected' : '' }}>Ditunda</option>
                                            <option value="dibatalkan" {{ old('status', $sanksi->status) == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi_sanksi" class="form-label">Deskripsi Sanksi</label>
                                <textarea class="form-control @error('deskripsi_sanksi') is-invalid @enderror" 
                                          name="deskripsi_sanksi" id="deskripsi_sanksi" rows="3">{{ old('deskripsi_sanksi', $sanksi->deskripsi_sanksi) }}</textarea>
                                @error('deskripsi_sanksi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                        <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror" 
                                               name="tanggal_mulai" id="tanggal_mulai" 
                                               value="{{ old('tanggal_mulai', $sanksi->tanggal_mulai) }}">
                                        <small class="text-muted">Kosongkan jika belum direncanakan.</small>
                                        @error('tanggal_mulai')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                                        <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror" 
                                               name="tanggal_selesai" id="tanggal_selesai" 
                                               value="{{ old('tanggal_selesai', $sanksi->tanggal_selesai) }}" 
                                               {{ !in_array($sanksi->status, ['selesai', 'dibatalkan']) ? 'readonly' : '' }}>
                                        <small class="text-muted">Otomatis terisi saat status 'Selesai' atau 'Dibatalkan'</small>
                                        @error('tanggal_selesai')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="guru_penanggungjawab" class="form-label">Guru Penanggung Jawab</label>
                                <select class="form-select @error('guru_penanggungjawab') is-invalid @enderror" 
                                        name="guru_penanggungjawab" id="guru_penanggungjawab">
                                    <option value="">Pilih Guru...</option>
                                    @foreach($guru as $g)
                                        <option value="{{ $g->guru_id }}" 
                                                {{ old('guru_penanggungjawab', $sanksi->guru_penanggungjawab) == $g->guru_id ? 'selected' : '' }}>
                                            {{ $g->nama_guru }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('guru_penanggungjawab')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="catatan_pelaksanaan" class="form-label">Catatan Pelaksanaan</label>
                                <textarea class="form-control @error('catatan_pelaksanaan') is-invalid @enderror" 
                                          name="catatan_pelaksanaan" id="catatan_pelaksanaan" rows="3">{{ old('catatan_pelaksanaan', $sanksi->catatan_pelaksanaan) }}</textarea>
                                @error('catatan_pelaksanaan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.sanksi.show', $sanksi) }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-1"></i>Kembali
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>Update Sanksi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusSelect = document.getElementById('status');
    const tanggalSelesaiInput = document.getElementById('tanggal_selesai');
    const originalDate = '{{ $sanksi->tanggal_selesai }}';
    
    function toggleTanggalSelesai() {
        const status = statusSelect.value;
        if (status === 'selesai' || status === 'dibatalkan') {
            tanggalSelesaiInput.removeAttribute('readonly');
            // If switching between selesai/dibatalkan and there's an original date, keep it
            if (originalDate && (status === 'selesai' || status === 'dibatalkan')) {
                tanggalSelesaiInput.value = originalDate;
            } else if (!tanggalSelesaiInput.value) {
                tanggalSelesaiInput.value = new Date().toISOString().split('T')[0];
            }
        } else {
            tanggalSelesaiInput.setAttribute('readonly', true);
            // Only clear if there was no original date
            if (!originalDate) {
                tanggalSelesaiInput.value = '';
            }
        }
    }
    
    statusSelect.addEventListener('change', toggleTanggalSelesai);
    toggleTanggalSelesai(); // Initial check
});
</script>
@endsection