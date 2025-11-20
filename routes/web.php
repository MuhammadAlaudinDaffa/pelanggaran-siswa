<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDashboard;
use App\Http\Controllers\Admin\AdminKategoriPelanggaran;
use App\Http\Controllers\Admin\AdminKategoriPrestasi;
use App\Http\Controllers\Admin\AdminUserManager;
use App\Http\Controllers\Admin\AdminKelas;
use App\Http\Controllers\Admin\AdminSiswa;
use App\Http\Controllers\Admin\AdminTahunAjaran;
use App\Http\Controllers\Admin\AdminOrangTua;
use App\Http\Controllers\Admin\AdminJurusan;
use App\Http\Controllers\Admin\AdminGuru;
use App\Http\Controllers\Admin\AdminDataMaster;
use App\Http\Controllers\Admin\AdminJenisPelanggaran;
use App\Http\Controllers\Admin\AdminJenisPrestasi;

use App\Http\Controllers\Kesiswaan\KesiswaanDashboard;
use App\Http\Controllers\Kesiswaan\KesiswaanPelanggaran;
use App\Http\Controllers\Kesiswaan\KesiswaanPrestasi;
use App\Http\Controllers\Kesiswaan\KesiswaanSanksi;
use App\Http\Controllers\Kesiswaan\KesiswaanPelaksanaanSanksi;
use App\Http\Controllers\Kesiswaan\MonitoringPelanggaranController;

use App\Http\Controllers\KepalaSekolah\KepalaSekolahDashboard;
use App\Http\Controllers\Siswa\SiswaDashboard;
use App\Http\Controllers\Guru\GuruDashboard;
use App\Http\Controllers\OrangTua\OrangTuaDashboard;
use App\Http\Controllers\BimbinganKonseling\BimbinganKonselingBK;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Api\CascadingController;

// API Routes for cascading dropdowns
Route::get('/api/siswa-by-kelas/{kelasId}', [CascadingController::class, 'getSiswaByKelas']);
Route::get('/api/jenis-pelanggaran-by-kategori/{kategoriId}', [CascadingController::class, 'getJenisPelanggaranByKategori']);
Route::get('/api/jenis-prestasi-by-kategori/{kategoriId}', [CascadingController::class, 'getJenisPrestasiByKategori']);

Route::get('/', [RoleController::class, 'login'])->name('login');
Route::get('/register/{role}', [RoleController::class, 'register'])->name('register');
Route::post('/login', [RoleController::class, 'authenticate'])->name('auth.login');
Route::post('/register', [RoleController::class, 'handleRegister'])->name('auth.register');
Route::post('/logout', [RoleController::class, 'logout'])->name('logout');
Route::get('/no-access', function() { return view('no-access'); })->name('no.access');

// Role-specific dashboard routes
Route::get('/admin', [AdminDashboard::class, 'index'])->middleware('admin')->name('admin.index');
Route::get('/kepala-sekolah', [KepalaSekolahDashboard::class, 'index'])->middleware('kepala_sekolah')->name('kepala_sekolah.index');
Route::get('/kesiswaan', [KesiswaanDashboard::class, 'index'])->middleware('kesiswaan')->name('kesiswaan.index');
Route::get('/bimbingan-konseling', function() { return view('bimbingan_konseling.index'); })->middleware('bimbingan_konseling')->name('bimbingan_konseling.index');
Route::get('/guru', [GuruDashboard::class, 'index'])->middleware('guru')->name('guru.index');
Route::get('/orang-tua', [OrangTuaDashboard::class, 'index'])->middleware('orang_tua')->name('orang_tua.index');
Route::get('/siswa', [SiswaDashboard::class, 'index'])->middleware('siswa')->name('siswa.index');

// Admin
Route::middleware('admin')->name('admin.')->group(function () {
    Route::get('admin/data-master', [AdminDataMaster::class, 'index'])->name('data-master.index');
    Route::resource('admin/data-master/kategori-pelanggaran', AdminKategoriPelanggaran::class)->names('data-master.kategori-pelanggaran');
    Route::resource('admin/data-master/kategori-prestasi', AdminKategoriPrestasi::class)->names('data-master.kategori-prestasi');
    Route::resource('admin/data-master/jenis-pelanggaran', AdminJenisPelanggaran::class)->names('data-master.jenis-pelanggaran');
    Route::resource('admin/data-master/jenis-prestasi', AdminJenisPrestasi::class)->names('data-master.jenis-prestasi');
    Route::resource('admin/data-master/user', AdminUserManager::class)->names('data-master.user');
    Route::resource('admin/data-master/kelas', AdminKelas::class)->names('data-master.kelas');
    Route::resource('admin/data-master/jurusan', AdminJurusan::class)->names('data-master.jurusan');
    Route::resource('admin/data-master/siswa', AdminSiswa::class)->names('data-master.siswa');
    Route::resource('admin/data-master/tahun-ajaran', AdminTahunAjaran::class)->names('data-master.tahun-ajaran');
    Route::resource('admin/data-master/guru-management', AdminGuru::class)->names('data-master.guru-management');
    Route::get('admin/data-master/orang-tua', [AdminOrangTua::class, 'index'])->name('admin.data-master.orang-tua.index');
    Route::get('admin/data-master/orang-tua/{id}', [AdminOrangTua::class, 'show'])->name('admin.data-master.orang-tua.show');

    Route::resource('admin/kesiswaan/pelanggaran', KesiswaanPelanggaran::class)->names('kesiswaan.pelanggaran');
    Route::post('admin/kesiswaan/pelanggaran/{pelanggaran}/verifikasi', [KesiswaanPelanggaran::class, 'verifikasi'])->name('kesiswaan.pelanggaran.verifikasi');
    
    Route::resource('admin/kesiswaan/prestasi', KesiswaanPrestasi::class)->names('kesiswaan.prestasi');
    Route::post('admin/kesiswaan/prestasi/{prestasi}/verifikasi', [KesiswaanPrestasi::class, 'verifikasi'])->name('kesiswaan.prestasi.verifikasi');
    
    Route::resource('admin/kesiswaan/sanksi', KesiswaanSanksi::class)->names('kesiswaan.sanksi');
    Route::resource('admin/kesiswaan/pelaksanaan-sanksi', KesiswaanPelaksanaanSanksi::class)->names('kesiswaan.pelaksanaan_sanksi');
    Route::resource('admin/kesiswaan/monitoring-pelanggaran', MonitoringPelanggaranController::class)->names('kesiswaan.monitoring_pelanggaran');
    Route::resource('admin/kesiswaan/siswa-overview', \App\Http\Controllers\Kesiswaan\SiswaOverviewController::class)->names('kesiswaan.siswa_overview')->only(['index', 'show']);
    
    Route::resource('admin/bimbingan-konseling/bk', BimbinganKonselingBK::class)->names('bimbingan_konseling.bk');
    Route::post('admin/bimbingan-konseling/bk/{bk}/ambil', [BimbinganKonselingBK::class, 'ambil'])->name('bimbingan_konseling.bk.ambil');
    Route::post('admin/bimbingan-konseling/bk/{bk}/reply', [BimbinganKonselingBK::class, 'reply'])->name('bimbingan_konseling.bk.reply');
    
    Route::get('admin/guru/info-kelas', [\App\Http\Controllers\Guru\InfoKelasController::class, 'index'])->name('guru.info_kelas.index');
    Route::post('admin/guru/info-kelas', [\App\Http\Controllers\Guru\InfoKelasController::class, 'store'])->name('guru.info_kelas.store');
});

// Kepala Sekolah (Read-only access)
Route::middleware('kepala_sekolah')->name('kepala_sekolah.')->group(function () {
    Route::resource('kepala-sekolah/kesiswaan/pelanggaran', KesiswaanPelanggaran::class)->names('kesiswaan.pelanggaran');
    Route::resource('kepala-sekolah/kesiswaan/prestasi', KesiswaanPrestasi::class)->names('kesiswaan.prestasi')->only(['index', 'show']);
    Route::resource('kepala-sekolah/kesiswaan/sanksi', KesiswaanSanksi::class)->names('kesiswaan.sanksi')->only(['index', 'show']);
    Route::resource('kepala-sekolah/kesiswaan/pelaksanaan-sanksi', KesiswaanPelaksanaanSanksi::class)->names('kesiswaan.pelaksanaan_sanksi')->only(['index', 'show']);
    Route::resource('kepala-sekolah/kesiswaan/monitoring-pelanggaran', MonitoringPelanggaranController::class)->names('kesiswaan.monitoring_pelanggaran');
    Route::resource('kepala-sekolah/kesiswaan/siswa-overview', \App\Http\Controllers\Kesiswaan\SiswaOverviewController::class)->names('kesiswaan.siswa_overview')->only(['index', 'show']);
    Route::get('kepala-sekolah/guru/info-kelas', [\App\Http\Controllers\Guru\InfoKelasController::class, 'index'])->name('guru.info_kelas.index');
    Route::post('kepala-sekolah/guru/info-kelas', [\App\Http\Controllers\Guru\InfoKelasController::class, 'store'])->name('guru.info_kelas.store');
});

// Kesiswaan
Route::middleware('kesiswaan')->name('kesiswaan.')->group(function () {
    Route::resource('kesiswaan/kesiswaan/pelanggaran', KesiswaanPelanggaran::class)->names('kesiswaan.pelanggaran');
    Route::post('kesiswaan/kesiswaan/pelanggaran/{pelanggaran}/verifikasi', [KesiswaanPelanggaran::class, 'verifikasi'])->name('kesiswaan.pelanggaran.verifikasi');
    
    Route::resource('kesiswaan/kesiswaan/prestasi', KesiswaanPrestasi::class)->names('kesiswaan.prestasi');
    Route::post('kesiswaan/kesiswaan/prestasi/{prestasi}/verifikasi', [KesiswaanPrestasi::class, 'verifikasi'])->name('kesiswaan.prestasi.verifikasi');

    Route::resource('kesiswaan/kesiswaan/sanksi', KesiswaanSanksi::class)->names('kesiswaan.sanksi');
    Route::resource('kesiswaan/kesiswaan/pelaksanaan-sanksi', KesiswaanPelaksanaanSanksi::class)->names('kesiswaan.pelaksanaan_sanksi');
    Route::resource('kesiswaan/kesiswaan/monitoring-pelanggaran', MonitoringPelanggaranController::class)->names('kesiswaan.monitoring_pelanggaran');
    Route::resource('kesiswaan/kesiswaan/siswa-overview', \App\Http\Controllers\Kesiswaan\SiswaOverviewController::class)->names('kesiswaan.siswa_overview')->only(['index', 'show']);
    Route::get('kesiswaan/guru/info-kelas', [\App\Http\Controllers\Guru\InfoKelasController::class, 'index'])->name('guru.info_kelas.index');
    Route::post('kesiswaan/guru/info-kelas', [\App\Http\Controllers\Guru\InfoKelasController::class, 'store'])->name('guru.info_kelas.store');
});

// Bimbingan Konseling
Route::middleware('bimbingan_konseling')->name('bimbingan_konseling.')->group(function () {
    Route::resource('bimbingan-konseling/bimbingan-konseling/bk', BimbinganKonselingBK::class)->names('bimbingan_konseling.bk');
    Route::post('bimbingan-konseling/bimbingan-konseling/bk/{bk}/ambil', [BimbinganKonselingBK::class, 'ambil'])->name('bimbingan_konseling.bk.ambil');
    Route::post('bimbingan-konseling/bimbingan-konseling/bk/{bk}/reply', [BimbinganKonselingBK::class, 'reply'])->name('bimbingan_konseling.bk.reply');
    Route::get('bimbingan-konseling/guru/info-kelas', [\App\Http\Controllers\Guru\InfoKelasController::class, 'index'])->name('guru.info_kelas.index');
    Route::post('bimbingan-konseling/guru/info-kelas', [\App\Http\Controllers\Guru\InfoKelasController::class, 'store'])->name('guru.info_kelas.store');
});

// Guru
Route::middleware('guru')->name('guru.')->group(function () {
    Route::get('guru/guru/info-kelas', [\App\Http\Controllers\Guru\InfoKelasController::class, 'index'])->name('guru.info_kelas.index');
    Route::post('guru/guru/info-kelas', [\App\Http\Controllers\Guru\InfoKelasController::class, 'store'])->name('guru.info_kelas.store');
    Route::resource('guru/kesiswaan/siswa-overview', \App\Http\Controllers\Kesiswaan\SiswaOverviewController::class)->names('kesiswaan.siswa_overview')->only(['index', 'show']);
    Route::resource('guru/kesiswaan/pelanggaran', KesiswaanPelanggaran::class)->names('kesiswaan.pelanggaran')->only(['index', 'show']);
    Route::resource('guru/kesiswaan/prestasi', KesiswaanPrestasi::class)->names('kesiswaan.prestasi')->only(['index', 'show']);
});

// Orang Tua
Route::middleware('orang_tua')->name('orang_tua.')->group(function () {
});

// Siswa
Route::middleware('siswa')->name('siswa.')->group(function () {
    Route::resource('siswa/bimbingan-konseling/bk', BimbinganKonselingBK::class)->names('bimbingan_konseling.bk')->only(['index', 'create', 'store', 'show', 'edit', 'update']);
    Route::post('siswa/bimbingan-konseling/bk/{bk}/reply', [BimbinganKonselingBK::class, 'reply'])->name('bimbingan_konseling.bk.reply');
    Route::get('siswa/kesiswaan/siswa-overview/{user}', [\App\Http\Controllers\Kesiswaan\SiswaOverviewController::class, 'show'])->name('kesiswaan.siswa_overview.show');
    Route::resource('siswa/kesiswaan/pelanggaran', KesiswaanPelanggaran::class)->names('kesiswaan.pelanggaran')->only(['index', 'show']);
    Route::resource('siswa/kesiswaan/prestasi', KesiswaanPrestasi::class)->names('kesiswaan.prestasi')->only(['index', 'show']);
});