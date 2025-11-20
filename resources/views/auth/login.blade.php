<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Sistem Pelanggaran</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
</head>

<body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-10 col-lg-8 col-xxl-6">
                        <div class="row">
                            <!-- Login Form -->
                            <div class="col-md-6">
                                <div class="card mb-0">
                                    <div class="card-body">
                                        <div class="text-nowrap logo-img text-center d-block py-3 w-100">
                                            <img src="{{ asset('assets/images/logos/dark-logo.png') }}" width="180" alt="">
                                        </div>
                                        <p class="text-center">Sistem Informasi Pelanggaran Siswa</p>

                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                @foreach ($errors->all() as $error)
                                                    <p class="mb-0">{{ $error }}</p>
                                                @endforeach
                                            </div>
                                        @endif

                                        @if (session('success'))
                                            <div class="alert alert-success">
                                                {{ session('success') }}
                                            </div>
                                        @endif

                                        <form method="POST" action="{{ route('auth.login') }}">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="username" class="form-label">Username</label>
                                                <input type="text" class="form-control" id="username" name="username" 
                                                       value="{{ old('username') }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="password" class="form-label">Password</label>
                                                <input type="password" class="form-control" id="password" name="password" required>
                                            </div>

                                            <div class="d-flex align-items-center justify-content-between mb-4">
                                                <div class="form-check">
                                                    <input class="form-check-input primary" type="checkbox" name="remember" id="remember">
                                                    <label class="form-check-label text-dark" for="remember">
                                                        Ingat saya
                                                    </label>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Masuk</button>
                                            <div class="d-flex align-items-center justify-content-center">
                                                <p class="fs-4 mb-0 fw-bold">Belum punya akun?</p>
                                                <a class="text-primary fw-bold ms-2" href="{{ route('register', 'orang_tua') }}">Daftar sebagai Orang Tua</a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Information Panel -->
                            <div class="col-md-6">
                                <div class="card mb-0 h-100">
                                    <div class="card-body">
                                        <h5 class="card-title mb-4">Informasi Sistem</h5>
                                        
                                        <div class="mb-4">
                                            <h6 class="text-primary">Kebijakan Penggunaan</h6>
                                            <ul class="list-unstyled small">
                                                <li>• Gunakan username dan password yang telah diberikan</li>
                                                <li>• Jaga kerahasiaan akun Anda</li>
                                                <li>• Laporkan jika ada masalah akses</li>
                                                <li>• Data yang diinput harus akurat dan benar</li>
                                            </ul>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <h6 class="text-success">Akses Pengguna</h6>
                                            <div class="small">
                                                <div class="mb-2">
                                                    <strong>Staff Sekolah:</strong><br>
                                                    Admin, Kepala Sekolah, Kesiswaan, BK, Guru
                                                </div>
                                                <div class="mb-2">
                                                    <strong>Orang Tua:</strong><br>
                                                    Dapat mendaftar sendiri dengan NISN siswa
                                                </div>
                                                <div>
                                                    <strong>Siswa:</strong><br>
                                                    Akun dibuat oleh admin sekolah
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-0">
                                            <h6 class="text-warning">Bantuan</h6>
                                            <p class="small mb-0">
                                                Jika mengalami kesulitan login atau lupa password, 
                                                hubungi admin sekolah atau bagian kesiswaan.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>