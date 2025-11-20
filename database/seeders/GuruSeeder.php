<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GuruSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('guru')->insert([
            [
                'guru_id' => 1,
                'user_id' => 1, // Admin
                'nip' => '123456789',
                'nama_guru' => 'Administrator',
                'jenis_kelamin' => 'laki-laki',
                'bidang_studi' => 'Administrasi',
                'email' => 'admin@sekolah.com',
                'no_telp' => '081234567890',
                'status' => 'aktif',
                'created_at' => now(),
            ],
            [
                'guru_id' => 2,
                'user_id' => 5, // Guru
                'nip' => '987654321',
                'nama_guru' => 'Guru Matematika',
                'jenis_kelamin' => 'perempuan',
                'bidang_studi' => 'Matematika',
                'email' => 'guru@sekolah.com',
                'no_telp' => '081234567891',
                'status' => 'aktif',
                'created_at' => now(),
            ],
        ]);
    }
}