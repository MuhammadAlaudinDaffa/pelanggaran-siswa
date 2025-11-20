<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InfoKelas extends Model
{
    
    protected $table = 'pembinaan_wali_kelas';
    protected $primaryKey = 'pembinaan_wali_kelas_id';
    public $timestamps = false;
    
    protected $fillable = [
        'kelas_id',
        'guru_id',
        'prioritas_pesan',
        'pesan'
    ];
    
    protected $casts = [
        'created_at' => 'datetime',
    ];
    
    public function getRouteKeyName()
    {
        return 'pembinaan_wali_kelas_id';
    }
    
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'kelas_id');
    }
    
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id', 'guru_id');
    }
}