<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisPelanggaran extends Model
{
    protected $table = 'jenis_pelanggaran';
    protected $primaryKey = 'jenis_pelanggaran_id';
    public $timestamps = false;
    
    protected $dates = ['created_at'];

    protected $fillable = [
        'nama_pelanggaran',
        'poin',
        'kategori_pelanggaran_id',
        'deskripsi',
        'sanksi_rekomendasi'
    ];

    public function getRouteKeyName()
    {
        return 'jenis_pelanggaran_id';
    }

    public function kategoriPelanggaran()
    {
        return $this->belongsTo(KategoriPelanggaran::class, 'kategori_pelanggaran_id');
    }

    public function pelanggaran()
    {
        return $this->hasMany(Pelanggaran::class, 'jenis_pelanggaran_id');
    }
}
