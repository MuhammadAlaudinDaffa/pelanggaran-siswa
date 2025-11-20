<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisPrestasi extends Model
{
    protected $table = 'jenis_prestasi';
    protected $primaryKey = 'jenis_prestasi_id';
    public $timestamps = false;
    
    protected $dates = ['created_at'];

    protected $fillable = [
        'nama_prestasi',
        'poin',
        'kategori_prestasi_id',
        'deskripsi',
        'reward'
    ];

    public function getRouteKeyName()
    {
        return 'jenis_prestasi_id';
    }

    public function kategoriPrestasi()
    {
        return $this->belongsTo(KategoriPrestasi::class, 'kategori_prestasi_id');
    }

    public function prestasi()
    {
        return $this->hasMany(Prestasi::class, 'jenis_prestasi_id');
    }
}
