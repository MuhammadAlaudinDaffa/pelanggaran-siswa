@extends('layout.main')
@section('title', 'Tambah User')
@section('content')
    <div class="row">
        <div class="col-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-semibold mb-4">Tambah User</h5>
                    <form action="{{ route('admin.data-master.user.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" 
                                   id="username" name="username" value="{{ old('username') }}" required>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" 
                                   id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required>
                            @error('nama_lengkap')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="level" class="form-label">Level</label>
                            <select class="form-select @error('level') is-invalid @enderror" id="level" name="level" required>
                                <option value="">Pilih Level</option>
                                <option value="admin" {{ old('level') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="kepala_sekolah" {{ old('level') == 'kepala_sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
                                <option value="kesiswaan" {{ old('level') == 'kesiswaan' ? 'selected' : '' }}>Kesiswaan</option>
                                <option value="bimbingan_konseling" {{ old('level') == 'bimbingan_konseling' ? 'selected' : '' }}>Bimbingan Konseling</option>
                                <option value="guru" {{ old('level') == 'guru' ? 'selected' : '' }}>Guru</option>
                                <option value="siswa" {{ old('level') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                            </select>
                            @error('level')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="can_verify" name="can_verify" value="1" {{ old('can_verify') ? 'checked' : '' }}>
                                <label class="form-check-label" for="can_verify">
                                    Can Verify
                                </label>
                            </div>
                        </div>

                        <!-- Siswa Fields -->
                        <div id="siswa-fields" style="display: none;">
                            <hr>
                            <h6 class="mb-3">Data Siswa</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nis" class="form-label">NIS</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control @error('nis') is-invalid @enderror" id="nis" name="nis" value="{{ old('nis') }}" placeholder="{{ $nextNis ?? '' }}">
                                            <button type="button" class="btn btn-outline-primary" onclick="setNisFromPlaceholder()" title="Gunakan NIS otomatis">
                                                <i class="ti ti-wand"></i>
                                            </button>
                                        </div>
                                        @error('nis')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="nisn" class="form-label">NISN (Opsional)</label>
                                        <input type="text" class="form-control" id="nisn" name="nisn" value="{{ old('nisn') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="nama_siswa" class="form-label">Nama Siswa</label>
                                        <input type="text" class="form-control @error('nama_siswa') is-invalid @enderror" id="nama_siswa" name="nama_siswa" value="{{ old('nama_siswa') }}">
                                        @error('nama_siswa')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="jenis_kelamin_siswa" class="form-label">Jenis Kelamin (Opsional)</label>
                                        <select class="form-select" id="jenis_kelamin_siswa" name="jenis_kelamin_siswa">
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="laki-laki" {{ old('jenis_kelamin_siswa') == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="perempuan" {{ old('jenis_kelamin_siswa') == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="kelas_id" class="form-label">Kelas (Opsional)</label>
                                        <select class="form-select" id="kelas_id" name="kelas_id">
                                            <option value="">Pilih Kelas</option>
                                            @foreach($kelas ?? [] as $k)
                                                <option value="{{ $k->kelas_id }}">{{ $k->nama_kelas }} - {{ $k->jurusan->nama_jurusan ?? '' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tempat_lahir" class="form-label">Tempat Lahir (Opsional)</label>
                                        <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir (Opsional)</label>
                                        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Guru Fields -->
                        <div id="guru-fields" style="display: none;">
                            <hr>
                            <h6 class="mb-3">Data Guru</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nip" class="form-label">NIP</label>
                                        <input type="text" class="form-control" id="nip" name="nip" value="{{ old('nip') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="nama_guru" class="form-label">Nama Guru</label>
                                        <input type="text" class="form-control @error('nama_guru') is-invalid @enderror" id="nama_guru" name="nama_guru" value="{{ old('nama_guru') }}">
                                        @error('nama_guru')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="jenis_kelamin_guru" class="form-label">Jenis Kelamin</label>
                                        <select class="form-select @error('jenis_kelamin_guru') is-invalid @enderror" id="jenis_kelamin_guru" name="jenis_kelamin_guru">
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="laki-laki" {{ old('jenis_kelamin_guru') == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="perempuan" {{ old('jenis_kelamin_guru') == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                        @error('jenis_kelamin_guru')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="bidang_studi" class="form-label">Bidang Studi</label>
                                        <input type="text" class="form-control" id="bidang_studi" name="bidang_studi" value="{{ old('bidang_studi') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                            <option value="">Pilih Status</option>
                                            <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                            <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Non Aktif</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('admin.data-master.user.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const levelSelect = document.getElementById('level');
            const canVerifyCheckbox = document.getElementById('can_verify');
            const siswaFields = document.getElementById('siswa-fields');
            const guruFields = document.getElementById('guru-fields');
            
            function toggleFields() {
                console.log('Level selected:', levelSelect.value);
                
                // Hide all fields first
                siswaFields.style.display = 'none';
                guruFields.style.display = 'none';
                
                // Show relevant fields based on selection
                if (levelSelect.value === 'siswa') {
                    console.log('Showing siswa fields');
                    siswaFields.style.display = 'block';
                    canVerifyCheckbox.checked = false;
                    canVerifyCheckbox.disabled = true;
                } else if (levelSelect.value === 'guru') {
                    console.log('Showing guru fields');
                    guruFields.style.display = 'block';
                    canVerifyCheckbox.disabled = false;
                } else {
                    canVerifyCheckbox.disabled = false;
                }
            }
            
            // Run on level change
            levelSelect.addEventListener('change', toggleFields);
            
            // Run on page load if level is already selected
            if (levelSelect.value) {
                toggleFields();
            }
        });
        
        function setNisFromPlaceholder() {
            const nisInput = document.getElementById('nis');
            const placeholder = nisInput.getAttribute('placeholder');
            if (placeholder) {
                nisInput.value = placeholder;
            }
        }
    </script>
@endsection
