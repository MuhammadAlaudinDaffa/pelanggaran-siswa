<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PembinaanWaliKelas extends Model
{
    use SoftDeletes;
    
    protected $table = 'pembinaan_wali_kelas';
    protected $primaryKey = 'pembinaan_id';
    public $timestamps = false;
    
    protected $fillable = [
        'siswa_id',
        'guru_wali_kelas',
        'tahun_ajaran_id',
        'jenis_pembinaan',
        'topik_pembinaan',
        'deskripsi_masalah',
        'tindakan_pembinaan',
        'hasil_pembinaan',
        'status',
        'tanggal_pembinaan',
        'tanggal_tindak_lanjut'
    ];
    
    protected $casts = [
        'tanggal_pembinaan' => 'date',
        'tanggal_tindak_lanjut' => 'date',
        'created_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];
    
    public function getRouteKeyName()
    {
        return 'pembinaan_id';
    }
    
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id', 'siswa_id');
    }
    
    public function guruWaliKelas()
    {
        return $this->belongsTo(Guru::class, 'guru_wali_kelas', 'guru_id');
    }
    
    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id', 'tahun_ajaran_id');
    }
}