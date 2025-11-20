<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            JurusanSeeder::class,
            TahunAjaranSeeder::class,
            KategoriPelanggaranSeeder::class,
            KategoriPrestasiSeeder::class,
            JenisPelanggaranSeeder::class,
            JenisPrestasiSeeder::class,
            GuruSeeder::class,
            KelasSeeder::class,
            SiswaSeeder::class,
            PelanggaranSeeder::class,
            PrestasiSeeder::class,
            BimbinganKonselingSeeder::class,
        ]);
    }
}