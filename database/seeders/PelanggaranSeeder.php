<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PelanggaranSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pelanggaran')->insert([
            [
                'siswa_id' => 2,
                'guru_pencatat' => 1,
                'jenis_pelanggaran_id' => 1,
                'tahun_ajaran_id' => 1,
                'poin' => 10,
                'keterangan' => 'Terlambat masuk kelas pagi',
                'bukti_foto' => null,
                'status_verifikasi' => 'menunggu',
                'guru_verifikator' => null,
                'verifikator_tim' => null,
                'catatan_verifikasi' => null,
                'tanggal' => '2024-01-15',
                'created_at' => now(),
            ],
            [
                'siswa_id' => 2,
                'guru_pencatat' => 2,
                'jenis_pelanggaran_id' => 2,
                'tahun_ajaran_id' => 1,
                'poin' => 25,
                'keterangan' => 'Tidak mengerjakan tugas matematika',
                'bukti_foto' => null,
                'status_verifikasi' => 'diverifikasi',
                'guru_verifikator' => 1,
                'verifikator_tim' => null,
                'catatan_verifikasi' => 'Sudah dikonfirmasi dengan wali kelas',
                'tanggal' => '2024-01-20',
                'created_at' => now(),
            ],
            [
                'siswa_id' => 2,
                'guru_pencatat' => 1,
                'jenis_pelanggaran_id' => 3,
                'tahun_ajaran_id' => 1,
                'poin' => 15,
                'keterangan' => 'Tidak memakai seragam lengkap',
                'bukti_foto' => null,
                'status_verifikasi' => 'revisi',
                'guru_verifikator' => 1,
                'verifikator_tim' => null,
                'catatan_verifikasi' => 'Perlu konfirmasi ulang dengan siswa',
                'tanggal' => '2024-01-25',
                'created_at' => now(),
            ],
            [
                'siswa_id' => 2,
                'guru_pencatat' => 2,
                'jenis_pelanggaran_id' => 1,
                'tahun_ajaran_id' => 1,
                'poin' => 10,
                'keterangan' => 'Terlambat masuk kelas siang',
                'bukti_foto' => null,
                'status_verifikasi' => 'tolak',
                'guru_verifikator' => null,
                'verifikator_tim' => 'Tim Admin',
                'catatan_verifikasi' => 'Tidak ada bukti yang cukup',
                'tanggal' => '2024-01-30',
                'created_at' => now(),
            ],
        ]);
    }
}