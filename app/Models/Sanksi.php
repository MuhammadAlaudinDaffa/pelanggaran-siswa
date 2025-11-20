<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sanksi extends Model
{
    protected $table = 'sanksi';
    protected $primaryKey = 'sanksi_id';
    public $timestamps = false;

    protected $fillable = [
        'pelanggaran_id',
        'jenis_sanksi',
        'deskripsi_sanksi',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'catatan_pelaksanaan',
        'guru_penanggungjawab'
    ];

    public function getRouteKeyName()
    {
        return 'sanksi_id';
    }

    public function pelanggaran()
    {
        return $this->belongsTo(Pelanggaran::class, 'pelanggaran_id');
    }

    public function guruPenanggungjawab()
    {
        return $this->belongsTo(Guru::class, 'guru_penanggungjawab');
    }

    public function pelaksanaan()
    {
        return $this->hasMany(PelaksanaanSanksi::class, 'sanksi_id');
    }

    // Auto update pelaksanaan status when sanksi is cancelled
    protected static function booted()
    {
        static::updated(function ($sanksi) {
            if ($sanksi->isDirty('status') && $sanksi->status === 'dibatalkan') {
                $sanksi->pelaksanaan()->update(['status' => 'tuntas']);
            }
        });
    }
}
