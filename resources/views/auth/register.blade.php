@extends('auth.auth-layout.main')
@section('title', 'Register')
@section('form')
	<p class="text-center mb-4">Daftar sebagai <strong>{{ $roleName ?? 'User' }}</strong></p>
	@if ($errors->any())
		<div class="alert alert-danger">
			@foreach ($errors->all() as $error)
				<div>{{ $error }}</div>
			@endforeach
		</div>
	@endif
	<form action="{{ route('auth.register') }}" method="POST">
		@csrf
		<input type="hidden" name="level" value="{{ $role }}">
		
		@if($role === 'orang_tua')
			<div class="row">
				<div class="col-md-6">
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
						<label for="nisn_siswa" class="form-label">NISN Siswa</label>
						<input type="text" class="form-control @error('nisn_siswa') is-invalid @enderror" 
							   id="nisn_siswa" name="nisn_siswa" value="{{ old('nisn_siswa') }}" 
							   placeholder="Masukkan NISN siswa" required>
						<small class="text-muted">Masukkan NISN siswa yang terdaftar</small>
						@error('nisn_siswa')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>
				</div>
				<div class="col-md-6">
					<div class="mb-3">
						<label for="hubungan" class="form-label">Hubungan</label>
						<select class="form-select @error('hubungan') is-invalid @enderror" id="hubungan" name="hubungan" required>
							<option value="">Pilih Hubungan</option>
							<option value="ayah" {{ old('hubungan') == 'ayah' ? 'selected' : '' }}>Ayah</option>
							<option value="ibu" {{ old('hubungan') == 'ibu' ? 'selected' : '' }}>Ibu</option>
							<option value="wali" {{ old('hubungan') == 'wali' ? 'selected' : '' }}>Wali</option>
						</select>
						@error('hubungan')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>
					<div class="mb-3">
						<label for="pekerjaan" class="form-label">Pekerjaan</label>
						<input type="text" class="form-control @error('pekerjaan') is-invalid @enderror" 
							   id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan') }}" required>
						@error('pekerjaan')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>
					<div class="mb-3">
						<label for="alamat" class="form-label">Alamat</label>
						<textarea class="form-control @error('alamat') is-invalid @enderror" 
								  id="alamat" name="alamat" rows="3" required>{{ old('alamat') }}</textarea>
						@error('alamat')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>
				</div>
			</div>
		@endif
		
		<button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Daftar</button>
		<div class="d-flex align-items-center justify-content-center">
			<p class="fs-4 mb-0 fw-bold">Sudah punya akun?</p>
			<a class="text-primary fw-bold ms-2" href="{{ route('login') }}">Masuk</a>
		</div>
	</form>
@endsection