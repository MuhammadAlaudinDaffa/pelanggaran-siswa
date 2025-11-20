@extends('layout.main')
@section('title', 'Dashboard Admin')
@section('content')
	<!-- Welcome Header -->
	<div class="row mb-4">
		<div class="col-12">
			<div class="card bg-primary text-white">
				<div class="card-body">
					<h4 class="card-title text-white mb-1">Selamat Datang, {{ Auth::user()->name }}</h4>
					<p class="card-text mb-0">Dashboard Admin - Kelola Seluruh Sistem Pelanggaran dan Prestasi</p>
				</div>
			</div>
		</div>
	</div>
	
	<!-- Data Master Section -->
	<div class="row">
		<!-- Academic Data Card -->
		<div class="col-lg-6 col-md-12 mb-4">
			<div class="card h-100">
				<div class="card-body">
					<h5 class="card-title mb-3"><i class="ti ti-school me-2"></i>Data Akademik</h5>
					<div class="row g-3">
						<div class="col-6">
							<div class="d-flex align-items-center p-2 bg-light rounded">
								<i class="ti ti-building text-info fs-4 me-2"></i>
								<div>
									<h4 class="mb-0">{{ $data['jurusan'] }}</h4>
									<small class="text-muted">Jurusan</small>
								</div>
							</div>
						</div>
						<div class="col-6">
							<div class="d-flex align-items-center p-2 bg-light rounded">
								<i class="ti ti-door text-success fs-4 me-2"></i>
								<div>
									<h4 class="mb-0">{{ $data['kelas'] }}</h4>
									<small class="text-muted">Kelas</small>
								</div>
							</div>
						</div>
					</div>
					<div class="mt-3">
						<div class="btn-group w-100" role="group">
							<a href="{{ route('admin.data-master.jurusan.index') }}" class="btn btn-outline-info btn-sm">
								<i class="ti ti-building me-1"></i> Jurusan
							</a>
							<a href="{{ route('admin.data-master.kelas.index') }}" class="btn btn-outline-success btn-sm">
								<i class="ti ti-door me-1"></i> Kelas
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<!-- User Management Card -->
		<div class="col-lg-6 col-md-12 mb-4">
			<div class="card h-100">
				<div class="card-body">
					<h5 class="card-title mb-3"><i class="ti ti-users me-2"></i>Manajemen Pengguna</h5>
					<div class="row g-3">
						<div class="col-6">
							<div class="d-flex align-items-center p-2 bg-light rounded">
								<i class="ti ti-user-check text-warning fs-4 me-2"></i>
								<div>
									<h4 class="mb-0">{{ $data['users'] }}</h4>
									<small class="text-muted">Users</small>
								</div>
							</div>
						</div>
						<div class="col-6">
							<div class="d-flex align-items-center p-2 bg-light rounded">
								<i class="ti ti-users text-primary fs-4 me-2"></i>
								<div>
									<h4 class="mb-0">{{ $data['siswa'] }}</h4>
									<small class="text-muted">Siswa</small>
								</div>
							</div>
						</div>
					</div>
					<div class="mt-3">
						<div class="btn-group w-100" role="group">
							<a href="{{ route('admin.data-master.user.index') }}" class="btn btn-outline-warning btn-sm">
								<i class="ti ti-user-check me-1"></i> Users
							</a>
							<a href="{{ route('admin.data-master.siswa.index') }}" class="btn btn-outline-primary btn-sm">
								<i class="ti ti-users me-1"></i> Siswa
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<!-- Pelanggaran & Prestasi Section -->
	<div class="row">
		<!-- Pelanggaran Management Card -->
		<div class="col-lg-6 col-md-12 mb-4">
			<div class="card h-100">
				<div class="card-body">
					<h5 class="card-title mb-3"><i class="ti ti-alert-triangle me-2 text-danger"></i>Manajemen Pelanggaran</h5>
					<div class="row g-3">
						<div class="col-4">
							<div class="text-center p-2 bg-light-danger rounded">
								<h4 class="text-danger mb-0">{{ $data['jenis_pelanggaran'] }}</h4>
								<small class="text-muted">Jenis</small>
							</div>
						</div>
						<div class="col-4">
							<div class="text-center p-2 bg-light-danger rounded">
								<h4 class="text-danger mb-0">{{ $data['pelanggaran'] }}</h4>
								<small class="text-muted">Total</small>
							</div>
						</div>
						<div class="col-4">
							<div class="text-center p-2 bg-light-warning rounded">
								<h4 class="text-warning mb-0">{{ $data['sanksi'] }}</h4>
								<small class="text-muted">Sanksi</small>
							</div>
						</div>
					</div>
					<div class="mt-3">
						<div class="d-grid gap-2">
							<a href="{{ route('admin.kesiswaan.pelanggaran.index') }}" class="btn btn-danger btn-sm">
								<i class="ti ti-eye me-1"></i> Kelola Pelanggaran
							</a>
							<div class="btn-group" role="group">
								<a href="{{ route('admin.data-master.jenis-pelanggaran.index') }}" class="btn btn-outline-danger btn-sm">
									<i class="ti ti-list me-1"></i> Jenis
								</a>
								<a href="{{ route('admin.kesiswaan.sanksi.index') }}" class="btn btn-outline-warning btn-sm">
									<i class="ti ti-gavel me-1"></i> Sanksi
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<!-- Prestasi Management Card -->
		<div class="col-lg-6 col-md-12 mb-4">
			<div class="card h-100">
				<div class="card-body">
					<h5 class="card-title mb-3"><i class="ti ti-trophy me-2 text-success"></i>Manajemen Prestasi</h5>
					<div class="row g-3">
						<div class="col-6">
							<div class="text-center p-2 bg-light-success rounded">
								<h4 class="text-success mb-0">{{ $data['jenis_prestasi'] }}</h4>
								<small class="text-muted">Jenis Prestasi</small>
							</div>
						</div>
						<div class="col-6">
							<div class="text-center p-2 bg-light-success rounded">
								<h4 class="text-success mb-0">{{ $data['prestasi'] }}</h4>
								<small class="text-muted">Total Prestasi</small>
							</div>
						</div>
					</div>
					<div class="mt-3">
						<div class="d-grid gap-2">
							<a href="{{ route('admin.kesiswaan.prestasi.index') }}" class="btn btn-success btn-sm">
								<i class="ti ti-eye me-1"></i> Kelola Prestasi
							</a>
							<a href="{{ route('admin.data-master.jenis-prestasi.index') }}" class="btn btn-outline-success btn-sm">
								<i class="ti ti-list me-1"></i> Kelola Jenis Prestasi
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<!-- Additional Services -->
	<div class="row">
		<!-- Bimbingan Konseling Card -->
		<div class="col-lg-4 col-md-6 mb-4">
			<div class="card h-100">
				<div class="card-body text-center">
					<div class="p-3 bg-info-subtle rounded-circle d-inline-flex mb-3">
						<i class="ti ti-message-circle fs-1 text-info"></i>
					</div>
					<h5 class="card-title">Bimbingan Konseling</h5>
					<h3 class="text-info mb-3">{{ $data['bimbingan_konseling'] }}</h3>
					<a href="{{ route('admin.bimbingan_konseling.bk.index') }}" class="btn btn-info btn-sm">
						<i class="ti ti-eye me-1"></i> Kelola BK
					</a>
				</div>
			</div>
		</div>
		
		<!-- Overview Siswa Card -->
		<div class="col-lg-4 col-md-6 mb-4">
			<div class="card h-100">
				<div class="card-body text-center">
					<div class="p-3 bg-primary-subtle rounded-circle d-inline-flex mb-3">
						<i class="ti ti-chart-bar fs-1 text-primary"></i>
					</div>
					<h5 class="card-title">Overview Siswa</h5>
					<p class="text-muted mb-3">Monitoring & Laporan</p>
					<div class="d-grid gap-2">
						<a href="{{ route('admin.kesiswaan.siswa_overview.index') }}" class="btn btn-primary btn-sm">
							<i class="ti ti-users me-1"></i> Overview Siswa
						</a>
						<a href="{{ route('admin.kesiswaan.monitoring_pelanggaran.index') }}" class="btn btn-outline-primary btn-sm">
							<i class="ti ti-eye me-1"></i> Monitoring
						</a>
					</div>
				</div>
			</div>
		</div>
		
		<!-- Quick Access Card -->
		<div class="col-lg-4 col-md-6 mb-4">
			<div class="card h-100">
				<div class="card-body">
					<h5 class="card-title mb-3"><i class="ti ti-dashboard me-2"></i>Akses Cepat</h5>
					<div class="d-grid gap-2">
						<a href="{{ route('admin.data-master.index') }}" class="btn btn-outline-secondary btn-sm">
							<i class="ti ti-database me-1"></i> Data Master
							</a>
						<a href="{{ route('admin.data-master.guru-management.index') }}" class="btn btn-outline-secondary btn-sm">
							<i class="ti ti-user-star me-1"></i> Manajemen Guru
						</a>
						<a href="{{ route('admin.data-master.orang-tua.index') }}" class="btn btn-outline-secondary btn-sm">
							<i class="ti ti-users me-1"></i> Data Orang Tua
						</a>
						<a href="{{ route('admin.guru.info_kelas.index') }}" class="btn btn-outline-secondary btn-sm">
							<i class="ti ti-message-circle me-1"></i> Info Kelas
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection