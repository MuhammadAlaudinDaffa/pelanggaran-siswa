<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonitoringPelanggaran extends Model
{
    use HasFactory;

    protected $table = 'monitoring_pelanggaran';
    protected $primaryKey = 'monitoring_id';
    public $timestamps = false;

    protected $fillable = [
        'pelanggaran_id',
        'guru_kepsek_id',
        'status_monitoring',
        'catatan_monitoring',
        'tanggal_monitoring',
        'tindak_lanjut'
    ];

    protected $casts = [
        'tanggal_monitoring' => 'date'
    ];

    public function pelanggaran()
    {
        return $this->belongsTo(Pelanggaran::class, 'pelanggaran_id', 'pelanggaran_id');
    }

    public function guruKepsek()
    {
        return $this->belongsTo(Guru::class, 'guru_kepsek_id', 'guru_id');
    }
}