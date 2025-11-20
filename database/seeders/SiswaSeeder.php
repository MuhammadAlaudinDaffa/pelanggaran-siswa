<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('siswa')->insert([
            'siswa_id' => 2,
            'user_id' => 7,
            'nis' => '2024001',
            'nisn' => '1234567890',
            'nama_siswa' => 'Alaudin',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '2006-01-15',
            'jenis_kelamin' => 'laki-laki',
            'alamat' => 'Jl. Contoh No. 123',
            'no_telp' => '081234567890',
            'kelas_id' => 1,
            'created_at' => now(),
        ]);
    }
}