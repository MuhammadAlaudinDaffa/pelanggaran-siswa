<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TahunAjaranSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tahun_ajaran')->insert([
            'tahun_ajaran_id' => 1,
            'kode_tahun' => '2024-2025-1',
            'tahun_ajaran' => '2024/2025',
            'semester' => 'Ganjil',
            'tanggal_mulai' => '2024-07-15',
            'tanggal_selesai' => '2025-01-15',
            'status_aktif' => 1,
            'created_at' => now(),
        ]);
    }
}