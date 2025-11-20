<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\JenisPelanggaran;
use App\Models\JenisPrestasi;

class CascadingController extends Controller
{
    public function getSiswaByKelas($kelasId)
    {
        $siswa = Siswa::where('kelas_id', $kelasId)
                     ->select('siswa_id', 'nama_siswa', 'nis')
                     ->orderBy('nama_siswa')
                     ->get();
        
        return response()->json($siswa);
    }

    public function getJenisPelanggaranByKategori($kategoriId)
    {
        $jenisPelanggaran = JenisPelanggaran::where('kategori_pelanggaran_id', $kategoriId)
                                          ->select('jenis_pelanggaran_id', 'nama_pelanggaran', 'poin')
                                          ->orderBy('nama_pelanggaran')
                                          ->get();
        
        return response()->json($jenisPelanggaran);
    }

    public function getJenisPrestasiByKategori($kategoriId)
    {
        $jenisPrestasi = JenisPrestasi::where('kategori_prestasi_id', $kategoriId)
                                    ->select('jenis_prestasi_id', 'nama_prestasi', 'poin')
                                    ->orderBy('nama_prestasi')
                                    ->get();
        
        return response()->json($jenisPrestasi);
    }
}