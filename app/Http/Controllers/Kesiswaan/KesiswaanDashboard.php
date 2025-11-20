<?php

namespace App\Http\Controllers\Kesiswaan;

use App\Http\Controllers\Controller;
use App\Models\Pelanggaran;
use App\Models\Prestasi;

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

        return view('kesiswaan.index', compact(
            'totalPelanggaran', 'pelanggaranMenunggu', 'pelanggaranDiverifikasi', 'pelanggaranRevisi', 'pelanggaranDitolak',
            'totalPrestasi', 'prestasiMenunggu', 'prestasiDiverifikasi', 'prestasiRevisi', 'prestasiDitolak'
        ));
    }
}