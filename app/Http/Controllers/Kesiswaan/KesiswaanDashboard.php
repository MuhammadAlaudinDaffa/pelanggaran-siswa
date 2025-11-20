<?php

namespace App\Http\Controllers\Kesiswaan;

use App\Http\Controllers\Controller;
use App\Models\Pelanggaran;
use App\Models\Prestasi;
use App\Models\Sanksi;
use App\Models\PelaksanaanSanksi;

class KesiswaanDashboard extends Controller
{
    public function index()
    {
        // Pelanggaran statistics
        $totalPelanggaran = Pelanggaran::count();
        $pelanggaranMenunggu = Pelanggaran::where('status_verifikasi', 'menunggu')->count();
        $pelanggaranDiverifikasi = Pelanggaran::where('status_verifikasi', 'diverifikasi')->count();
        $pelanggaranRevisi = Pelanggaran::where('status_verifikasi', 'revisi')->count();
        $pelanggaranDitolak = Pelanggaran::where('status_verifikasi', 'ditolak')->count();

        // Prestasi statistics
        $totalPrestasi = Prestasi::count();
        $prestasiMenunggu = Prestasi::where('status_verifikasi', 'menunggu')->count();
        $prestasiDiverifikasi = Prestasi::where('status_verifikasi', 'diverifikasi')->count();
        $prestasiRevisi = Prestasi::where('status_verifikasi', 'revisi')->count();
        $prestasiDitolak = Prestasi::where('status_verifikasi', 'ditolak')->count();

        // Sanksi statistics
        $totalSanksi = Sanksi::count();
        $sanksiAktif = Sanksi::where('status', 'aktif')->count();
        $sanksiSelesai = Sanksi::where('status', 'selesai')->count();

        // Pelaksanaan Sanksi statistics
        $totalPelaksanaanSanksi = PelaksanaanSanksi::count();
        $pelaksanaanMenunggu = PelaksanaanSanksi::where('status', 'menunggu')->count();
        $pelaksanaanTuntas = PelaksanaanSanksi::where('status', 'tuntas')->count();

        return view('kesiswaan.index', compact(
            'totalPelanggaran', 'pelanggaranMenunggu', 'pelanggaranDiverifikasi', 'pelanggaranRevisi', 'pelanggaranDitolak',
            'totalPrestasi', 'prestasiMenunggu', 'prestasiDiverifikasi', 'prestasiRevisi', 'prestasiDitolak',
            'totalSanksi', 'sanksiAktif', 'sanksiSelesai',
            'totalPelaksanaanSanksi', 'pelaksanaanMenunggu', 'pelaksanaanTuntas'
        ));
    }
}