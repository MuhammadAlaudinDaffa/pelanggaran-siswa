<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';
    protected $primaryKey = 'siswa_id';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'nis',
        'nisn',
        'nama_siswa',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'no_telp',
        'kelas_id',
        'foto'
    ];

    public function getRouteKeyName()
    {
        return 'siswa_id';
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function orangtua()
    {
        return $this->hasMany(Orangtua::class, 'siswa_id');
    }

    public function pelanggaran()
    {
        return $this->hasMany(Pelanggaran::class, 'siswa_id');
    }

    public function prestasi()
    {
        return $this->hasMany(Prestasi::class, 'siswa_id');
    }

    public function bimbinganKonseling()
    {
        return $this->hasMany(BimbinganKonseling::class, 'siswa_id');
    }
}
