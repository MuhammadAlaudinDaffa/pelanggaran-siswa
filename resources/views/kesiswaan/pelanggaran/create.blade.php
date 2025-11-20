@extends('layout.main')
@section('title', 'Tambah Pelanggaran')
@section('content')
    <div class="row">
        <div class="col-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-semibold mb-4">Tambah Pelanggaran</h5>
                    
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form action="{{ \App\Helpers\RouteHelper::route('kesiswaan.pelanggaran.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Kelas <span class="text-danger">*</span></label>
                                    <select id="kelas_id" class="form-select" required>
                                        <option value="">Pilih Kelas</option>
                                        @foreach($kelas as $k)
                                            <option value="{{ $k->kelas_id }}" {{ old('kelas_id') == $k->kelas_id ? 'selected' : '' }}>
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
                                            <option value="{{ $kp->kategori_pelanggaran_id }}" {{ old('kategori_pelanggaran_id') == $kp->kategori_pelanggaran_id ? 'selected' : '' }}>
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
                                    <input type="date" name="tanggal" class="form-control" 
                                           value="{{ date('Y-m-d') }}" readonly>
                                    <small class="text-muted">Tanggal otomatis diisi hari ini</small>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Tahun Ajaran</label>
                                    <input type="text" class="form-control" 
                                           value="{{ $tahunAjaran->tahun_ajaran ?? 'Tidak ada tahun ajaran aktif' }} - {{ $tahunAjaran->semester ?? '' }}" readonly>
                                    <small class="text-muted">Tahun ajaran aktif terlama dipilih otomatis</small>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Keterangan</label>
                                    <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" 
                                              rows="4" placeholder="Masukkan keterangan pelanggaran">{{ old('keterangan') }}</textarea>
                                    @error('keterangan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Bukti Foto</label>
                                    <input type="file" name="bukti_foto" class="form-control @error('bukti_foto') is-invalid @enderror" 
                                           accept="image/*">
                                    <small class="text-muted">Format: JPG, PNG, JPEG. Maksimal 2MB</small>
                                    @error('bukti_foto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-device-floppy"></i> Simpan
                            </button>
                            <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.pelanggaran.index') }}" class="btn btn-secondary">
                                <i class="ti ti-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>
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
                        })
                        .catch(error => {
                            jenisSelect.innerHTML = '<option value="">Error loading data</option>';
                        });
                } else {
                    jenisSelect.innerHTML = '<option value="">Pilih kategori terlebih dahulu</option>';
                    jenisSelect.disabled = true;
                }
            });

            // Restore old values if validation fails
            @if(old('kelas_id'))
                kelasSelect.value = '{{ old('kelas_id') }}';
                kelasSelect.dispatchEvent(new Event('change'));
                
                setTimeout(() => {
                    @if(old('siswa_id'))
                        siswaSelect.value = '{{ old('siswa_id') }}';
                    @endif
                }, 500);
            @endif

            @if(old('kategori_pelanggaran_id'))
                kategoriSelect.value = '{{ old('kategori_pelanggaran_id') }}';
                kategoriSelect.dispatchEvent(new Event('change'));
                
                setTimeout(() => {
                    @if(old('jenis_pelanggaran_id'))
                        jenisSelect.value = '{{ old('jenis_pelanggaran_id') }}';
                    @endif
                }, 500);
            @endif
        });
    </script>
@endsection