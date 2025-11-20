<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Pelanggaran;
use App\Models\Prestasi;
use App\Models\BimbinganKonseling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaDashboard extends Controller
{
    public function index()
    {
        $siswa = Siswa::where('user_id', Auth::id())->first();
        
        if (!$siswa) {
            return view('siswa.index', ['error' => 'Data siswa tidak ditemukan']);
        }
        
        // Pelanggaran statistics
        $pelanggaranStats = [
            'total' => Pelanggaran::where('siswa_id', $siswa->siswa_id)->where('status_verifikasi', 'diverifikasi')->count(),
            'poin' => Pelanggaran::where('siswa_id', $siswa->siswa_id)->where('status_verifikasi', 'diverifikasi')->sum('poin')
        ];
        
        // Prestasi statistics
        $prestasiStats = [
            'total' => Prestasi::where('siswa_id', $siswa->siswa_id)->where('status_verifikasi', 'diverifikasi')->count(),
            'poin' => Prestasi::where('siswa_id', $siswa->siswa_id)->where('status_verifikasi', 'diverifikasi')->sum('poin')
        ];
        
        // BK statistics
        $bkStats = [
            'menunggu' => BimbinganKonseling::where('siswa_id', $siswa->siswa_id)->whereNull('bk_parent_id')->where('status', 'menunggu')->count(),
            'berkelanjutan' => BimbinganKonseling::where('siswa_id', $siswa->siswa_id)->whereNull('bk_parent_id')->where('status', 'berkelanjutan')->count(),
            'tindak_lanjut' => BimbinganKonseling::where('siswa_id', $siswa->siswa_id)->whereNull('bk_parent_id')->where('status', 'tindak_lanjut')->count(),
            'selesai' => BimbinganKonseling::where('siswa_id', $siswa->siswa_id)->whereNull('bk_parent_id')->where('status', 'selesai')->count(),
            'ditolak' => BimbinganKonseling::where('siswa_id', $siswa->siswa_id)->whereNull('bk_parent_id')->where('status', 'ditolak')->count()
        ];
        $bkStats['total'] = array_sum($bkStats);
        
        return view('siswa.index', compact('siswa', 'pelanggaranStats', 'prestasiStats', 'bkStats'));
    }
}