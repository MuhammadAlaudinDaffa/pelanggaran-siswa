<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriPelanggaran extends Model
{
    protected $table = "kategori_pelanggaran";
    protected $primaryKey = 'kategori_pelanggaran_id';
    public $timestamps = false;
    protected $fillable = [
        "nama_kategori",
        "deskripsi",
    ];

    public function getRouteKeyName()
    {
        return 'kategori_pelanggaran_id';
    }

    public function jenisPelanggaran()
    {
        return $this->hasMany(JenisPelanggaran::class, 'kategori_pelanggaran_id');
    }
}
