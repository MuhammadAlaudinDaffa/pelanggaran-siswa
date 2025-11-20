<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggaran extends Model
{
    protected $table = 'pelanggaran';
    protected $primaryKey = 'pelanggaran_id';
    public $timestamps = false;

    protected $fillable = [
        'siswa_id',
        'guru_pencatat',
        'jenis_pelanggaran_id',
        'tahun_ajaran_id',
        'poin',
        'keterangan',
        'bukti_foto',
        'status_verifikasi',
        'guru_verifikator',
        'verifikator_tim',
        'catatan_verifikasi',
        'tanggal'
    ];

    public function getRouteKeyName()
    {
        return 'pelanggaran_id';
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

    public function jenisPelanggaran()
    {
        return $this->belongsTo(JenisPelanggaran::class, 'jenis_pelanggaran_id');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id');
    }

    public function sanksi()
    {
        return $this->hasMany(Sanksi::class, 'pelanggaran_id');
    }

    public function monitoring()
    {
        return $this->hasMany(MonitoringPelanggaran::class, 'pelanggaran_id');
    }
}
