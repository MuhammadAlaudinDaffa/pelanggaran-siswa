<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\TahunAjaran;
use App\Models\KategoriPelanggaran;
use App\Models\KategoriPrestasi;
use App\Models\JenisPelanggaran;
use App\Models\JenisPrestasi;

use App\Models\User;

class AdminDataMaster extends Controller
{
    public function index()
    {
        $data = [
            'guruCount' => Guru::count(),
            'siswaCount' => Siswa::count(),
            'kelasCount' => Kelas::count(),
            'jurusanCount' => Jurusan::count(),
            'tahunAjaranCount' => TahunAjaran::count(),
            'kategoriPelanggaranCount' => KategoriPelanggaran::count(),
            'kategoriPrestasiCount' => KategoriPrestasi::count(),
            'jenisPelanggaranCount' => JenisPelanggaran::count(),
            'jenisPrestasiCount' => JenisPrestasi::count(),
            'userCount' => User::count(),
        ];

        return view('admin.data-master.index', $data);
    }
}