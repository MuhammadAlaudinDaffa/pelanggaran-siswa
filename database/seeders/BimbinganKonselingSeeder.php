<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BimbinganKonselingSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('bimbingan_konseling')->insert([
            [
                'siswa_id' => 2,
                'guru_konselor' => null,
                'konselor_user_id' => null,
                'konselor_tim' => null,
                'bk_parent_id' => null,
                'child_count' => 0,
                'child_order' => 0,
                'tahun_ajaran_id' => 1,
                'jenis_layanan' => 'pribadi',
                'topik' => 'Masalah Kepercayaan Diri',
                'keluhan_masalah' => 'Saya merasa kurang percaya diri saat presentasi di depan kelas',
                'tindakan_solusi' => null,
                'status' => 'menunggu',
                'tanggal_konseling' => null,
                'tanggal_tindak_lanjut' => null,
                'hasil_evaluasi' => null,
                'created_at' => now(),
                'deleted_at' => null,
            ],
            [
                'siswa_id' => 2,
                'guru_konselor' => 1,
                'konselor_user_id' => null,
                'konselor_tim' => null,
                'bk_parent_id' => null,
                'child_count' => 0,
                'child_order' => 0,
                'tahun_ajaran_id' => 1,
                'jenis_layanan' => 'belajar',
                'topik' => 'Kesulitan Matematika',
                'keluhan_masalah' => 'Saya kesulitan memahami materi integral dan diferensial',
                'tindakan_solusi' => 'Diberikan bimbingan khusus dan latihan soal tambahan',
                'status' => 'selesai',
                'tanggal_konseling' => '2024-02-10',
                'tanggal_tindak_lanjut' => null,
                'hasil_evaluasi' => 'Siswa sudah menunjukkan peningkatan pemahaman',
                'created_at' => now(),
                'deleted_at' => null,
            ],
        ]);
    }
}