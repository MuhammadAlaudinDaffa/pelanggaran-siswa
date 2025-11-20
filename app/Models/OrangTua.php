<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orangtua extends Model
{
    protected $table = 'orangtua';
    protected $primaryKey = 'orangtua_id';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'siswa_id',
        'hubungan',
        'nama_orangtua',
        'pekerjaan',
        'pendidikan',
        'no_telp',
        'alamat'
    ];

    public function getRouteKeyName()
    {
        return 'orangtua_id';
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
}
