<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BimbinganKonseling extends Model
{
    use SoftDeletes;
    
    protected $table = 'bimbingan_konseling';
    protected $primaryKey = 'bk_id';
    public $timestamps = false;
    
    protected $fillable = [
        'siswa_id',
        'guru_konselor',
        'konselor_user_id',
        'konselor_tim',
        'bk_parent_id',
        'child_count',
        'child_order',
        'tahun_ajaran_id',
        'jenis_layanan',
        'topik',
        'keluhan_masalah',
        'tindakan_solusi',
        'status',
        'tanggal_konseling',
        'tanggal_tindak_lanjut',
        'hasil_evaluasi'
    ];
    
    protected $casts = [
        'tanggal_konseling' => 'date',
        'tanggal_tindak_lanjut' => 'date',
        'created_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];
    
    public function getRouteKeyName()
    {
        return 'bk_id';
    }
    
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id', 'siswa_id');
    }
    
    public function guruKonselor()
    {
        return $this->belongsTo(Guru::class, 'guru_konselor', 'guru_id');
    }
    
    public function konselorUser()
    {
        return $this->belongsTo(\App\Models\User::class, 'konselor_user_id', 'user_id');
    }
    
    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id', 'tahun_ajaran_id');
    }
    
    public function parent()
    {
        return $this->belongsTo(BimbinganKonseling::class, 'bk_parent_id', 'bk_id');
    }
    
    public function children()
    {
        return $this->hasMany(BimbinganKonseling::class, 'bk_parent_id', 'bk_id')->orderBy('child_order');
    }
    
    public function thread()
    {
        return $this->hasMany(BimbinganKonseling::class, 'bk_parent_id', 'bk_id')->withTrashed()->orderBy('child_order');
    }
}