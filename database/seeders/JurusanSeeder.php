<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JurusanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('jurusan')->insert([
            'jurusan_id' => 1,
            'nama_jurusan' => 'Pengembangan Perangkat Lunak dan Gim',
            'deskripsi' => 'Jurusan yang mempelajari pengembangan perangkat lunak dan game',
            'created_at' => now(),
        ]);
    }
}