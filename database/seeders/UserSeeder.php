<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'user_id' => 1,
                'username' => 'admin',
                'password' => Hash::make('password'),
                'nama_lengkap' => 'Administrator',
                'level' => 'admin',
                'can_verify' => 1,
                'is_active' => 1,
                'created_at' => now(),
            ],
            [
                'user_id' => 2,
                'username' => 'kesiswaan',
                'password' => Hash::make('password'),
                'nama_lengkap' => 'Staff Kesiswaan',
                'level' => 'kesiswaan',
                'can_verify' => 1,
                'is_active' => 1,
                'created_at' => now(),
            ],
            [
                'user_id' => 3,
                'username' => 'kepala_sekolah',
                'password' => Hash::make('password'),
                'nama_lengkap' => 'Kepala Sekolah',
                'level' => 'kepala_sekolah',
                'can_verify' => 0,
                'is_active' => 1,
                'created_at' => now(),
            ],
            [
                'user_id' => 4,
                'username' => 'bk001',
                'password' => Hash::make('password'),
                'nama_lengkap' => 'Guru BK',
                'level' => 'bimbingan_konseling',
                'can_verify' => 0,
                'is_active' => 1,
                'created_at' => now(),
            ],
            [
                'user_id' => 5,
                'username' => 'guru001',
                'password' => Hash::make('password'),
                'nama_lengkap' => 'Guru Matematika',
                'level' => 'guru',
                'can_verify' => 0,
                'is_active' => 1,
                'created_at' => now(),
            ],
            [
                'user_id' => 6,
                'username' => 'ortu001',
                'password' => Hash::make('password'),
                'nama_lengkap' => 'Orang Tua Siswa',
                'level' => 'orang_tua',
                'can_verify' => 0,
                'is_active' => 1,
                'created_at' => now(),
            ],
            [
                'user_id' => 7,
                'username' => 'siswa001',
                'password' => Hash::make('password'),
                'nama_lengkap' => 'Alaudin Siswa',
                'level' => 'siswa',
                'can_verify' => 0,
                'is_active' => 1,
                'created_at' => now(),
            ],
        ]);
    }
}