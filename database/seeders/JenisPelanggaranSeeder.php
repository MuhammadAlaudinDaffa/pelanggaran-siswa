<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisPelanggaranSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('jenis_pelanggaran')->insert([
            [
                'jenis_pelanggaran_id' => 1,
                'nama_pelanggaran' => 'Terlambat Masuk Sekolah',
                'poin' => 10,
                'kategori_pelanggaran_id' => 1,
                'deskripsi' => 'Siswa datang terlambat ke sekolah',
                'sanksi_rekomendasi' => 'Teguran lisan',
                'created_at' => now(),
            ],
            [
                'jenis_pelanggaran_id' => 2,
                'nama_pelanggaran' => 'Tidak Mengerjakan Tugas',
                'poin' => 25,
                'kategori_pelanggaran_id' => 1,
                'deskripsi' => 'Siswa tidak mengerjakan tugas yang diberikan',
                'sanksi_rekomendasi' => 'Teguran tertulis',
                'created_at' => now(),
            ],
            [
                'jenis_pelanggaran_id' => 3,
                'nama_pelanggaran' => 'Tidak Memakai Seragam Lengkap',
                'poin' => 15,
                'kategori_pelanggaran_id' => 1,
                'deskripsi' => 'Siswa tidak memakai seragam sesuai ketentuan',
                'sanksi_rekomendasi' => 'Peringatan',
                'created_at' => now(),
            ],
        ]);
    }
}