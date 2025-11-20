<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrestasiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('prestasi')->insert([
            [
                'siswa_id' => 2,
                'guru_pencatat' => 1,
                'jenis_prestasi_id' => 1,
                'tahun_ajaran_id' => 1,
                'poin' => 50,
                'keterangan' => 'Juara 1 Olimpiade Matematika Tingkat Sekolah',
                'tingkat' => 'kecamatan',
                'penghargaan' => 'Medali Emas dan Sertifikat',
                'bukti_dokumen' => null,
                'status_verifikasi' => 'diverifikasi',
                'guru_verifikator' => 1,
                'verifikator_tim' => null,
                'catatan_verifikasi' => null,
                'tanggal' => '2024-02-15',
                'created_at' => now(),
            ],
            [
                'siswa_id' => 2,
                'guru_pencatat' => 2,
                'jenis_prestasi_id' => 2,
                'tahun_ajaran_id' => 1,
                'poin' => 75,
                'keterangan' => 'Juara 2 Lomba Karya Tulis Ilmiah',
                'tingkat' => 'provinsi',
                'penghargaan' => 'Piala dan Piagam',
                'bukti_dokumen' => null,
                'status_verifikasi' => 'menunggu',
                'guru_verifikator' => null,
                'verifikator_tim' => null,
                'catatan_verifikasi' => null,
                'tanggal' => '2024-02-20',
                'created_at' => now(),
            ],
        ]);
    }
}