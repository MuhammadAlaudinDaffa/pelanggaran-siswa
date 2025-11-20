<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriPelanggaranSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('kategori_pelanggaran')->insert([
            'kategori_pelanggaran_id' => 1,
            'nama_kategori' => 'Pelanggaran Ringan',
            'deskripsi' => 'Pelanggaran yang bersifat ringan dan tidak mengganggu ketertiban sekolah secara signifikan',
            'created_at' => now(),
        ]);
    }
}