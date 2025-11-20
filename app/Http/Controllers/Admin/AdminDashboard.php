<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\JenisPelanggaran;
use App\Models\JenisPrestasi;
use App\Models\Sanksi;
use App\Models\User;
use App\Models\Pelanggaran;
use App\Models\Prestasi;
use App\Models\BimbinganKonseling;
use Illuminate\Http\Request;

class AdminDashboard extends Controller
{
    public function index()
    {
        $data = [
            'siswa' => Siswa::count(),
            'kelas' => Kelas::count(),
            'jurusan' => Jurusan::count(),
            'users' => User::count(),
            'jenis_pelanggaran' => JenisPelanggaran::count(),
            'jenis_prestasi' => JenisPrestasi::count(),
            'pelanggaran' => Pelanggaran::count(),
            'prestasi' => Prestasi::count(),
            'sanksi' => Sanksi::count(),
            'bimbingan_konseling' => BimbinganKonseling::count()
        ];
        
        return view('admin.index', compact('data'));
    }
}
