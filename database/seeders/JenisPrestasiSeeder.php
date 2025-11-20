<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisPrestasiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('jenis_prestasi')->insert([
            [
                'jenis_prestasi_id' => 1,
                'nama_prestasi' => 'Juara Olimpiade Matematika',
                'poin' => 50,
                'kategori_prestasi_id' => 1,
                'deskripsi' => 'Prestasi dalam bidang olimpiade matematika',
                'reward' => 'Sertifikat dan piagam',
                'created_at' => now(),
            ],
            [
                'jenis_prestasi_id' => 2,
                'nama_prestasi' => 'Juara Karya Tulis Ilmiah',
                'poin' => 75,
                'kategori_prestasi_id' => 1,
                'deskripsi' => 'Prestasi dalam lomba karya tulis ilmiah',
                'reward' => 'Piala dan piagam',
                'created_at' => now(),
            ],
        ]);
    }
}