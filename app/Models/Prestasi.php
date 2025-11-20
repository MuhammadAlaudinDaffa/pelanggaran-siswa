<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prestasi extends Model
{
    protected $table = 'prestasi';
    protected $primaryKey = 'prestasi_id';
    public $timestamps = false;

    protected $fillable = [
        'siswa_id',
        'guru_pencatat',
        'jenis_prestasi_id',
        'tahun_ajaran_id',
        'poin',
        'keterangan',
        'tingkat',
        'penghargaan',
        'bukti_dokumen',
        'status_verifikasi',
        'guru_verifikator',
        'verifikator_tim',
        'catatan_verifikasi',
        'tanggal'
    ];

    public function getRouteKeyName()
    {
        return 'prestasi_id';
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function guruPencatat()
    {
        return $this->belongsTo(Guru::class, 'guru_pencatat');
    }

    public function guruVerifikator()
    {
        return $this->belongsTo(Guru::class, 'guru_verifikator');
    }

    public function jenisPrestasi()
    {
        return $this->belongsTo(JenisPrestasi::class, 'jenis_prestasi_id');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id');
    }
}
