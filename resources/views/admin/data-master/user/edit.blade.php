@extends('layout.main')
@section('title', 'Edit User')
@section('content')
    <div class="row">
        <div class="col-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-semibold mb-4">Edit User</h5>
                    <form action="{{ route('admin.data-master.user.update', $user->user_id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" 
                                   id="username" name="username" value="{{ old('username', $user->username) }}" required>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password (Kosongkan jika tidak ingin mengubah)</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" 
                                   id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $user->nama_lengkap) }}" required>
                            @error('nama_lengkap')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="level" class="form-label">Level</label>
                            <select class="form-select @error('level') is-invalid @enderror" id="level" name="level" required>
                                <option value="">Pilih Level</option>
                                <option value="admin" {{ old('level', $user->level) == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="kepala_sekolah" {{ old('level', $user->level) == 'kepala_sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
                                <option value="kesiswaan" {{ old('level', $user->level) == 'kesiswaan' ? 'selected' : '' }}>Kesiswaan</option>
                                <option value="bimbingan_konseling" {{ old('level', $user->level) == 'bimbingan_konseling' ? 'selected' : '' }}>Bimbingan Konseling</option>
                                <option value="guru" {{ old('level', $user->level) == 'guru' ? 'selected' : '' }}>Guru</option>
                                <option value="orang_tua" {{ old('level', $user->level) == 'orang_tua' ? 'selected' : '' }}>Orang Tua</option>
                                <option value="siswa" {{ old('level', $user->level) == 'siswa' ? 'selected' : '' }}>Siswa</option>
                            </select>
                            @error('level')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="can_verify" name="can_verify" value="1" {{ old('can_verify', $user->can_verify) ? 'checked' : '' }}>
                                <label class="form-check-label" for="can_verify">
                                    Can Verify
                                </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Status Aktif
                                </label>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('admin.data-master.user.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function toggleCanVerify() {
        const levelSelect = document.getElementById('level');
        const canVerifyCheckbox = document.getElementById('can_verify');
        
        if (levelSelect.value === 'orang_tua') {
            canVerifyCheckbox.checked = false;
            canVerifyCheckbox.disabled = true;
        } else {
            canVerifyCheckbox.disabled = false;
        }
    }
    
    document.getElementById('level').addEventListener('change', toggleCanVerify);
    
    // Check on page load
    document.addEventListener('DOMContentLoaded', toggleCanVerify);
</script>
@endpush