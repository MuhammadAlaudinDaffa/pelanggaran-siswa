<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    protected $table = 'tahun_ajaran';
    protected $primaryKey = 'tahun_ajaran_id';
    public $timestamps = false;

    protected $fillable = [
        'kode_tahun',
        'tahun_ajaran',
        'semester',
        'status_aktif',
        'tanggal_mulai',
        'tanggal_selesai'
    ];

    public function getRouteKeyName()
    {
        return 'tahun_ajaran_id';
    }

    public function pelanggaran()
    {
        return $this->hasMany(Pelanggaran::class, 'tahun_ajaran_id');
    }

    public function prestasi()
    {
        return $this->hasMany(Prestasi::class, 'tahun_ajaran_id');
    }

    public function bimbinganKonseling()
    {
        return $this->hasMany(BimbinganKonseling::class, 'tahun_ajaran_id');
    }

    public function getFormattedTanggalMulaiAttribute()
    {
        return date('d F Y', strtotime($this->tanggal_mulai));
    }

    public function getFormattedTanggalSelesaiAttribute()
    {
        return date('d F Y', strtotime($this->tanggal_selesai));
    }

    public function getStatusTextAttribute()
    {
        return $this->status_aktif ? 'Aktif' : 'Tidak Aktif';
    }
}
