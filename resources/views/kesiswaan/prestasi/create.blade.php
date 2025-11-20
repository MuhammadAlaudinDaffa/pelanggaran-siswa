@extends('layout.main')

@section('title', 'Tambah Prestasi')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-header mb-4">
                    <h5 class="card-title fw-semibold mb-0">Tambah Prestasi</h5>
                </div>
                <div class="card-body">
                    <form action="{{ \App\Helpers\RouteHelper::route('kesiswaan.prestasi.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="kelas_id" class="form-label">Kelas <span class="text-danger">*</span></label>
                                    <select class="form-select" id="kelas_id" required>
                                        <option value="">Pilih Kelas</option>
                                        @foreach($kelas as $k)
                                            <option value="{{ $k->kelas_id }}" {{ old('kelas_id') == $k->kelas_id ? 'selected' : '' }}>
                                                {{ $k->nama_kelas }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="siswa_id" class="form-label">Siswa <span class="text-danger">*</span></label>
                                    <select class="form-select @error('siswa_id') is-invalid @enderror" id="siswa_id" name="siswa_id" required disabled>
                                        <option value="">Pilih kelas terlebih dahulu</option>
                                    </select>
                                    @error('siswa_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="kategori_prestasi_id" class="form-label">Kategori Prestasi <span class="text-danger">*</span></label>
                                    <select class="form-select" id="kategori_prestasi_id" required>
                                        <option value="">Pilih Kategori Prestasi</option>
                                        @foreach($kategoriPrestasi as $kp)
                                            <option value="{{ $kp->kategori_prestasi_id }}" {{ old('kategori_prestasi_id') == $kp->kategori_prestasi_id ? 'selected' : '' }}>
                                                {{ $kp->nama_kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="jenis_prestasi_id" class="form-label">Jenis Prestasi <span class="text-danger">*</span></label>
                                    <select class="form-select @error('jenis_prestasi_id') is-invalid @enderror" id="jenis_prestasi_id" name="jenis_prestasi_id" required disabled>
                                        <option value="">Pilih kategori terlebih dahulu</option>
                                    </select>
                                    @error('jenis_prestasi_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tingkat" class="form-label">Tingkat</label>
                                    <select class="form-select @error('tingkat') is-invalid @enderror" id="tingkat" name="tingkat">
                                        <option value="">Pilih Tingkat</option>
                                        <option value="kecamatan" {{ old('tingkat') == 'kecamatan' ? 'selected' : '' }}>Kecamatan</option>
                                        <option value="provinsi" {{ old('tingkat') == 'provinsi' ? 'selected' : '' }}>Provinsi</option>
                                        <option value="nasional" {{ old('tingkat') == 'nasional' ? 'selected' : '' }}>Nasional</option>
                                    </select>
                                    @error('tingkat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="penghargaan" class="form-label">Penghargaan</label>
                                    <input type="text" class="form-control @error('penghargaan') is-invalid @enderror" id="penghargaan" name="penghargaan" value="{{ old('penghargaan') }}" placeholder="Contoh: Juara 1, Juara 2, dll">
                                    @error('penghargaan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tanggal" class="form-label">Tanggal</label>
                                    <input type="date" class="form-control" id="tanggal" value="{{ date('Y-m-d') }}" readonly>
                                    <small class="text-muted">Tanggal otomatis diisi hari ini</small>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tahun_ajaran" class="form-label">Tahun Ajaran</label>
                                    <input type="text" class="form-control" id="tahun_ajaran" value="{{ $tahunAjaran ? $tahunAjaran->tahun_ajaran : 'Tidak ada tahun ajaran aktif' }}" readonly>
                                    <small class="text-muted">Tahun ajaran aktif saat ini</small>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" rows="3" placeholder="Keterangan tambahan tentang prestasi...">{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="bukti_dokumen" class="form-label">Bukti Dokumen</label>
                            <input type="file" class="form-control @error('bukti_dokumen') is-invalid @enderror" id="bukti_dokumen" name="bukti_dokumen" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                            <small class="text-muted">Format yang diizinkan: JPG, PNG, PDF, DOC, DOCX. Maksimal 2MB</small>
                            @error('bukti_dokumen')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.prestasi.index') }}" class="btn btn-outline-secondary">
                                <i class="ti ti-arrow-left fs-4"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-device-floppy fs-4"></i> Simpan
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
        const kelasSelect = document.getElementById('kelas_id');
        const siswaSelect = document.getElementById('siswa_id');
        const kategoriSelect = document.getElementById('kategori_prestasi_id');
        const jenisSelect = document.getElementById('jenis_prestasi_id');

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
                fetch(`/api/jenis-prestasi-by-kategori/${kategoriId}`)
                    .then(response => response.json())
                    .then(data => {
                        jenisSelect.innerHTML = '<option value="">Pilih Jenis Prestasi</option>';
                        data.forEach(jenis => {
                            jenisSelect.innerHTML += `<option value="${jenis.jenis_prestasi_id}">${jenis.nama_prestasi}</option>`;
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

        @if(old('kategori_prestasi_id'))
            kategoriSelect.value = '{{ old('kategori_prestasi_id') }}';
            kategoriSelect.dispatchEvent(new Event('change'));
            
            setTimeout(() => {
                @if(old('jenis_prestasi_id'))
                    jenisSelect.value = '{{ old('jenis_prestasi_id') }}';
                @endif
            }, 500);
        @endif
    });
</script>
@endsection