<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    protected $table = 'jurusan';
    protected $primaryKey = 'jurusan_id';
    public $timestamps = false;

    protected $fillable = [
        'nama_jurusan',
        'deskripsi'
    ];

    public function getRouteKeyName()
    {
        return 'jurusan_id';
    }

    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'jurusan_id');
    }
}
