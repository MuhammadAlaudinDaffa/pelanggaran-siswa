@extends('layout.main')
@section('title', 'Dashboard Admin')
@section('content')
	<div class="row">
		<div class="col-12">
			<h4 class="fw-semibold mb-4">Dashboard Admin</h4>
		</div>
	</div>
	
	<!-- Data Statistics Cards -->
	<div class="row">
		<div class="col-lg-3 col-md-6">
			<div class="card">
				<div class="card-body">
					<div class="d-flex align-items-center">
						<div class="bg-primary rounded-circle p-3 d-flex align-items-center justify-content-center">
							<i class="ti ti-users text-white fs-6"></i>
						</div>
						<div class="ms-3">
							<h3 class="fw-semibold mb-0">{{ $data['siswa'] }}</h3>
							<p class="text-muted mb-0">Total Siswa</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-lg-3 col-md-6">
			<div class="card">
				<div class="card-body">
					<div class="d-flex align-items-center">
						<div class="bg-success rounded-circle p-3 d-flex align-items-center justify-content-center">
							<i class="ti ti-school text-white fs-6"></i>
						</div>
						<div class="ms-3">
							<h3 class="fw-semibold mb-0">{{ $data['kelas'] }}</h3>
							<p class="text-muted mb-0">Total Kelas</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-lg-3 col-md-6">
			<div class="card">
				<div class="card-body">
					<div class="d-flex align-items-center">
						<div class="bg-info rounded-circle p-3 d-flex align-items-center justify-content-center">
							<i class="ti ti-building text-white fs-6"></i>
						</div>
						<div class="ms-3">
							<h3 class="fw-semibold mb-0">{{ $data['jurusan'] }}</h3>
							<p class="text-muted mb-0">Total Jurusan</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-lg-3 col-md-6">
			<div class="card">
				<div class="card-body">
					<div class="d-flex align-items-center">
						<div class="bg-warning rounded-circle p-3 d-flex align-items-center justify-content-center">
							<i class="ti ti-user-check text-white fs-6"></i>
						</div>
						<div class="ms-3">
							<h3 class="fw-semibold mb-0">{{ $data['users'] }}</h3>
							<p class="text-muted mb-0">Total Users</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row mt-4">
		<div class="col-lg-4 col-md-6">
			<div class="card">
				<div class="card-body">
					<div class="d-flex align-items-center">
						<div class="bg-danger rounded-circle p-3 d-flex align-items-center justify-content-center">
							<i class="ti ti-alert-triangle text-white fs-6"></i>
						</div>
						<div class="ms-3">
							<h3 class="fw-semibold mb-0">{{ $data['jenis_pelanggaran'] }}</h3>
							<p class="text-muted mb-0">Jenis Pelanggaran</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-lg-4 col-md-6">
			<div class="card">
				<div class="card-body">
					<div class="d-flex align-items-center">
						<div class="bg-success rounded-circle p-3 d-flex align-items-center justify-content-center">
							<i class="ti ti-trophy text-white fs-6"></i>
						</div>
						<div class="ms-3">
							<h3 class="fw-semibold mb-0">{{ $data['jenis_prestasi'] }}</h3>
							<p class="text-muted mb-0">Jenis Prestasi</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-lg-4 col-md-6">
			<div class="card">
				<div class="card-body">
					<div class="d-flex align-items-center">
						<div class="bg-secondary rounded-circle p-3 d-flex align-items-center justify-content-center">
							<i class="ti ti-gavel text-white fs-6"></i>
						</div>
						<div class="ms-3">
							<h3 class="fw-semibold mb-0">{{ $data['sanksi'] }}</h3>
							<p class="text-muted mb-0">Total Sanksi</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row mt-4">
		<div class="col-lg-3 col-md-6">
			<div class="card">
				<div class="card-body">
					<div class="d-flex align-items-center">
						<div class="bg-danger rounded-circle p-3 d-flex align-items-center justify-content-center">
							<i class="ti ti-exclamation-circle text-white fs-6"></i>
						</div>
						<div class="ms-3">
							<h3 class="fw-semibold mb-0">{{ $data['pelanggaran'] }}</h3>
							<p class="text-muted mb-0">Total Pelanggaran</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-lg-3 col-md-6">
			<div class="card">
				<div class="card-body">
					<div class="d-flex align-items-center">
						<div class="bg-success rounded-circle p-3 d-flex align-items-center justify-content-center">
							<i class="ti ti-award text-white fs-6"></i>
						</div>
						<div class="ms-3">
							<h3 class="fw-semibold mb-0">{{ $data['prestasi'] }}</h3>
							<p class="text-muted mb-0">Total Prestasi</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-lg-3 col-md-6">
			<div class="card">
				<div class="card-body">
					<div class="d-flex align-items-center">
						<div class="bg-info rounded-circle p-3 d-flex align-items-center justify-content-center">
							<i class="ti ti-message-circle text-white fs-6"></i>
						</div>
						<div class="ms-3">
							<h3 class="fw-semibold mb-0">{{ $data['bimbingan_konseling'] }}</h3>
							<p class="text-muted mb-0">Bimbingan Konseling</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection