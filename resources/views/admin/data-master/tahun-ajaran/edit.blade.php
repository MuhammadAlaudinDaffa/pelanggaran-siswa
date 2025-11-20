@extends('layout.main')
@section('title', 'Edit Tahun Ajaran')
@section('content')
    <div class="row">
        <div class="col-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-semibold mb-4">Edit Tahun Ajaran</h5>
                    <form action="{{ route('admin.data-master.tahun-ajaran.update', $tahunAjaran->tahun_ajaran_id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="kode_tahun" class="form-label">Kode Tahun</label>
                                    <input type="text" class="form-control @error('kode_tahun') is-invalid @enderror" 
                                           id="kode_tahun" name="kode_tahun" value="{{ old('kode_tahun', $tahunAjaran->kode_tahun) }}" 
                                           placeholder="Contoh: 2023-2024-1" required>
                                    @error('kode_tahun')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="tahun_ajaran" class="form-label">Tahun Ajaran</label>
                                    <input type="text" class="form-control @error('tahun_ajaran') is-invalid @enderror" 
                                           id="tahun_ajaran" name="tahun_ajaran" value="{{ old('tahun_ajaran', $tahunAjaran->tahun_ajaran) }}" required>
                                    @error('tahun_ajaran')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="semester" class="form-label">Semester</label>
                                    <select class="form-select @error('semester') is-invalid @enderror" id="semester" name="semester" required>
                                        <option value="">Pilih Semester</option>
                                        <option value="1" {{ old('semester', $tahunAjaran->semester) == '1' ? 'selected' : '' }}>Semester 1</option>
                                        <option value="2" {{ old('semester', $tahunAjaran->semester) == '2' ? 'selected' : '' }}>Semester 2</option>
                                    </select>
                                    @error('semester')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                    <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror" 
                                           id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai', $tahunAjaran->tanggal_mulai) }}" required>
                                    @error('tanggal_mulai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                                    <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror" 
                                           id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai', $tahunAjaran->tanggal_selesai) }}" required>
                                    @error('tanggal_selesai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="status_aktif" name="status_aktif" value="1" {{ old('status_aktif', $tahunAjaran->status_aktif) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status_aktif">
                                            Status Aktif
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('admin.data-master.tahun-ajaran.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.getElementById('tanggal_mulai').addEventListener('change', function() {
        const tanggalMulai = this.value;
        const tanggalSelesaiInput = document.getElementById('tanggal_selesai');
        tanggalSelesaiInput.min = tanggalMulai;
        
        if (tanggalSelesaiInput.value && tanggalSelesaiInput.value <= tanggalMulai) {
            tanggalSelesaiInput.value = '';
        }
    });
    
    // Set initial min value
    document.addEventListener('DOMContentLoaded', function() {
        const tanggalMulai = document.getElementById('tanggal_mulai').value;
        if (tanggalMulai) {
            document.getElementById('tanggal_selesai').min = tanggalMulai;
        }
    });
</script>
@endpush