<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriPrestasi extends Model
{
    protected $table = "kategori_prestasi";
    protected $primaryKey = 'kategori_prestasi_id';
    public $timestamps = false;
    protected $fillable = [
        "nama_kategori",
        "deskripsi",
    ];

    public function getRouteKeyName()
    {
        return 'kategori_prestasi_id';
    }

    public function jenisPrestasi()
    {
        return $this->hasMany(JenisPrestasi::class, 'kategori_prestasi_id');
    }
}