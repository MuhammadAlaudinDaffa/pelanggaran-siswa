<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    public $timestamps = false;

    protected $fillable = [
        'username',
        'password',
        'nama_lengkap',
        'level',
        'can_verify',
        'is_active',
        'last_login'
    ];

    public function getRouteKeyName()
    {
        return 'user_id';
    }

    public function guru()
    {
        return $this->hasOne(Guru::class, 'user_id');
    }

    public function siswa()
    {
        return $this->hasOne(Siswa::class, 'user_id');
    }

    public function orangtua()
    {
        return $this->hasOne(Orangtua::class, 'user_id');
    }
}
