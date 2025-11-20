<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriPrestasiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('kategori_prestasi')->insert([
            'kategori_prestasi_id' => 1,
            'nama_kategori' => 'Prestasi Akademik',
            'deskripsi' => 'Prestasi yang berkaitan dengan pencapaian akademik siswa',
            'created_at' => now(),
        ]);
    }
}