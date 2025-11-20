<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Pelanggaran;
use App\Models\Prestasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuruDashboard extends Controller
{
    public function index()
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return view('guru.index', ['noGuruData' => true]);
        }
        
        $kelas = Kelas::where('wali_kelas_id', $guru->guru_id)->first();
        $isWaliKelas = (bool) $kelas;
        
        $data = [
            'guru' => $guru,
            'isWaliKelas' => $isWaliKelas,
            'kelas' => $kelas
        ];
        
        if ($isWaliKelas) {
            $data['classStats'] = [
                'total_siswa' => Siswa::where('kelas_id', $kelas->kelas_id)->count(),
                'siswa_melanggar' => Siswa::where('kelas_id', $kelas->kelas_id)
                    ->whereHas('pelanggaran', function($q) {
                        $q->where('status_verifikasi', 'diverifikasi');
                    })->count(),
                'total_pelanggaran' => Pelanggaran::whereHas('siswa', function($q) use ($kelas) {
                        $q->where('kelas_id', $kelas->kelas_id);
                    })->where('status_verifikasi', 'diverifikasi')->count(),
                'total_prestasi' => Prestasi::whereHas('siswa', function($q) use ($kelas) {
                        $q->where('kelas_id', $kelas->kelas_id);
                    })->where('status_verifikasi', 'diverifikasi')->count()
            ];
        }
        
        return view('guru.index', $data);
    }
}