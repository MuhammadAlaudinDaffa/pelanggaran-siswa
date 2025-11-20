<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $table = 'guru';
    protected $primaryKey = 'guru_id';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'nip',
        'nama_guru',
        'jenis_kelamin',
        'bidang_studi',
        'email',
        'no_telp',
        'status'
    ];

    public function getRouteKeyName()
    {
        return 'guru_id';
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kelasWali()
    {
        return $this->hasMany(Kelas::class, 'wali_kelas_id');
    }

    public function pelanggaranDicatat()
    {
        return $this->hasMany(Pelanggaran::class, 'guru_pencatat');
    }

    public function pelanggaranDiverifikasi()
    {
        return $this->hasMany(Pelanggaran::class, 'guru_verifikator');
    }

    public function prestasiDicatat()
    {
        return $this->hasMany(Prestasi::class, 'guru_pencatat');
    }

    public function prestasiDiverifikasi()
    {
        return $this->hasMany(Prestasi::class, 'guru_verifikator');
    }

    public function bimbingan()
    {
        return $this->hasMany(BimbinganKonseling::class, 'guru_konselor');
    }

    public function monitoring()
    {
        return $this->hasMany(MonitoringPelanggaran::class, 'guru_kepsek_id');
    }

    public function sanksiTanggungjawab()
    {
        return $this->hasMany(Sanksi::class, 'guru_penanggungjawab');
    }

    public function pengawasSanksi()
    {
        return $this->hasMany(PelaksanaanSanksi::class, 'guru_pengawas');
    }
}
