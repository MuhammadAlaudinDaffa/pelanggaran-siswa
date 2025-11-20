<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanKesiswaan extends Model
{
    protected $table = 'laporan_kesiswaan';
    protected $primaryKey = 'laporan_id';
    public $timestamps = false;
    
    protected $fillable = [
        'jenis_data',
        'tabel_terkait',
        'id_data_terkait',
        'siswa_id',
        'tabel_jenis',
        'id_data_jenis',
        'tahun_ajaran_id',
        'poin',
        'keterangan',
        'jenis_bukti',
        'file_bukti',
        'tanggal'
    ];
    
    protected $casts = [
        'tanggal' => 'date',
        'created_at' => 'datetime'
    ];
    
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id', 'siswa_id');
    }
    
    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id', 'tahun_ajaran_id');
    }
}
