@extends('layout.main')
@section('title', 'Edit Pelanggaran')
@section('content')
    <div class="row">
        <div class="col-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-semibold mb-4">Edit Pelanggaran</h5>
                    
                    @if(!in_array($pelanggaran->status_verifikasi, ['menunggu', 'revisi']))
                        <div class="alert alert-warning">
                            <i class="ti ti-alert-triangle me-2"></i>
                            Pelanggaran ini sudah diverifikasi dan tidak dapat diedit.
                        </div>
                        <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.pelanggaran.index') }}" class="btn btn-secondary">
                            <i class="ti ti-arrow-left"></i> Kembali
                        </a>
                    @else
                    
                    <form action="{{ \App\Helpers\RouteHelper::route('kesiswaan.pelanggaran.update', $pelanggaran->pelanggaran_id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Kelas <span class="text-danger">*</span></label>
                                    <select id="kelas_id" class="form-select" required>
                                        <option value="">Pilih Kelas</option>
                                        @foreach($kelas as $k)
                                            <option value="{{ $k->kelas_id }}" {{ old('kelas_id', $pelanggaran->siswa->kelas_id ?? '') == $k->kelas_id ? 'selected' : '' }}>
                                                {{ $k->nama_kelas }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Siswa <span class="text-danger">*</span></label>
                                    <select name="siswa_id" id="siswa_id" class="form-select @error('siswa_id') is-invalid @enderror" required disabled>
                                        <option value="">Pilih kelas terlebih dahulu</option>
                                    </select>
                                    @error('siswa_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Kategori Pelanggaran <span class="text-danger">*</span></label>
                                    <select id="kategori_pelanggaran_id" class="form-select" required>
                                        <option value="">Pilih Kategori Pelanggaran</option>
                                        @foreach($kategoriPelanggaran as $kp)
                                            <option value="{{ $kp->kategori_pelanggaran_id }}" {{ old('kategori_pelanggaran_id', $pelanggaran->jenisPelanggaran->kategori_pelanggaran_id ?? '') == $kp->kategori_pelanggaran_id ? 'selected' : '' }}>
                                                {{ $kp->nama_kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Jenis Pelanggaran <span class="text-danger">*</span></label>
                                    <select name="jenis_pelanggaran_id" id="jenis_pelanggaran_id" class="form-select @error('jenis_pelanggaran_id') is-invalid @enderror" required disabled>
                                        <option value="">Pilih kategori terlebih dahulu</option>
                                    </select>
                                    @error('jenis_pelanggaran_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Tanggal</label>
                                    <input type="text" class="form-control" 
                                           value="{{ date('d/m/Y', strtotime($pelanggaran->tanggal)) }}" readonly>
                                    <small class="text-muted">Tanggal tidak dapat diubah</small>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Keterangan</label>
                                    <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" 
                                              rows="4" placeholder="Masukkan keterangan pelanggaran">{{ old('keterangan', $pelanggaran->keterangan) }}</textarea>
                                    @error('keterangan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Bukti Foto</label>
                                    @if($pelanggaran->bukti_foto)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $pelanggaran->bukti_foto) }}" alt="Bukti" 
                                                 class="img-thumbnail" style="width: 150px; height: 100px; object-fit: cover;">
                                            <small class="d-block text-muted">Foto saat ini</small>
                                        </div>
                                    @endif
                                    <input type="file" name="bukti_foto" class="form-control @error('bukti_foto') is-invalid @enderror" 
                                           accept="image/*">
                                    <small class="text-muted">Format: JPG, PNG, JPEG. Maksimal 2MB. Kosongkan jika tidak ingin mengubah foto.</small>
                                    @error('bukti_foto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-device-floppy"></i> Perbarui
                            </button>
                            <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.pelanggaran.index') }}" class="btn btn-secondary">
                                <i class="ti ti-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>
                    
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const kelasSelect = document.getElementById('kelas_id');
            const siswaSelect = document.getElementById('siswa_id');
            const kategoriSelect = document.getElementById('kategori_pelanggaran_id');
            const jenisSelect = document.getElementById('jenis_pelanggaran_id');

            // Handle kelas change
            kelasSelect.addEventListener('change', function() {
                const kelasId = this.value;
                siswaSelect.innerHTML = '<option value="">Loading...</option>';
                siswaSelect.disabled = true;

                if (kelasId) {
                    fetch(`/api/siswa-by-kelas/${kelasId}`)
                        .then(response => response.json())
                        .then(data => {
                            siswaSelect.innerHTML = '<option value="">Pilih Siswa</option>';
                            data.forEach(siswa => {
                                siswaSelect.innerHTML += `<option value="${siswa.siswa_id}">${siswa.nama_siswa}</option>`;
                            });
                            siswaSelect.disabled = false;
                            
                            // Restore selected siswa if editing
                            @if(isset($pelanggaran))
                                siswaSelect.value = '{{ old('siswa_id', $pelanggaran->siswa_id) }}';
                            @endif
                        })
                        .catch(error => {
                            siswaSelect.innerHTML = '<option value="">Error loading data</option>';
                        });
                } else {
                    siswaSelect.innerHTML = '<option value="">Pilih kelas terlebih dahulu</option>';
                    siswaSelect.disabled = true;
                }
            });

            // Handle kategori change
            kategoriSelect.addEventListener('change', function() {
                const kategoriId = this.value;
                jenisSelect.innerHTML = '<option value="">Loading...</option>';
                jenisSelect.disabled = true;

                if (kategoriId) {
                    fetch(`/api/jenis-pelanggaran-by-kategori/${kategoriId}`)
                        .then(response => response.json())
                        .then(data => {
                            jenisSelect.innerHTML = '<option value="">Pilih Jenis Pelanggaran</option>';
                            data.forEach(jenis => {
                                jenisSelect.innerHTML += `<option value="${jenis.jenis_pelanggaran_id}">${jenis.nama_pelanggaran}</option>`;
                            });
                            jenisSelect.disabled = false;
                            
                            // Restore selected jenis if editing
                            @if(isset($pelanggaran))
                                jenisSelect.value = '{{ old('jenis_pelanggaran_id', $pelanggaran->jenis_pelanggaran_id) }}';
                            @endif
                        })
                        .catch(error => {
                            jenisSelect.innerHTML = '<option value="">Error loading data</option>';
                        });
                } else {
                    jenisSelect.innerHTML = '<option value="">Pilih kategori terlebih dahulu</option>';
                    jenisSelect.disabled = true;
                }
            });

            // Initialize dropdowns on page load
            if (kelasSelect.value) {
                kelasSelect.dispatchEvent(new Event('change'));
            }
            if (kategoriSelect.value) {
                kategoriSelect.dispatchEvent(new Event('change'));
            }
        });
    </script>
@endsection