<?php

namespace App\Http\Controllers\OrangTua;

use App\Http\Controllers\Controller;
use App\Models\Orangtua;
use App\Models\Siswa;
use App\Models\Pelanggaran;
use App\Models\Prestasi;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrangTuaDashboard extends Controller
{
    public function index()
    {
        $orangTua = Orangtua::where('user_id', Auth::id())->first();
        
        if (!$orangTua) {
            return view('orang_tua.index', ['error' => 'Data orang tua tidak ditemukan']);
        }
        
        $siswa = Siswa::find($orangTua->siswa_id);
        
        if (!$siswa) {
            return view('orang_tua.index', ['error' => 'Data siswa tidak ditemukan']);
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
        
        return view('orang_tua.index', compact('siswa', 'pelanggaranStats', 'prestasiStats'));
    }
}