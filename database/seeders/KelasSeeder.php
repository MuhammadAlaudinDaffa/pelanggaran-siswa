<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('kelas')->insert([
            [
            'kelas_id' => 1,
            'nama_kelas' => 'XII PPLG 1',
            'jurusan_id' => 1,
            'kapasitas' => 36,
            'wali_kelas_id' => 1,
            'created_at' => now(),
            ],
            [
            'kelas_id' => 2,
            'nama_kelas' => 'XII DKV',
            'jurusan_id' => 2,
            'kapasitas' => 20,
            'wali_kelas_id' => 2,
            'created_at' => now(),
            ],
        ]);
    }
}