<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PelaksanaanSanksi extends Model
{
    protected $table = 'pelaksanaan_sanksi';
    protected $primaryKey = 'pelaksanaan_id';
    public $timestamps = false;

    protected $fillable = [
        'sanksi_id',
        'tanggal_pelaksanaan',
        'deskripsi_pelaksanaan',
        'bukti_pelaksanaan',
        'status',
        'catatan',
        'guru_pengawas'
    ];

    protected $dates = ['tanggal_pelaksanaan'];

    public function getRouteKeyName()
    {
        return 'pelaksanaan_id';
    }

    public function sanksi()
    {
        return $this->belongsTo(Sanksi::class, 'sanksi_id');
    }

    public function guruPengawas()
    {
        return $this->belongsTo(Guru::class, 'guru_pengawas');
    }

    // Auto update status based on date
    public function updateStatusBasedOnDate()
    {
        $now = Carbon::now('Asia/Jakarta');
        $pelaksanaanDate = Carbon::parse($this->tanggal_pelaksanaan)->setTimezone('Asia/Jakarta');
        
        if ($this->status !== 'tuntas' && $pelaksanaanDate->isPast() && $this->status !== 'terlambat') {
            $this->update(['status' => 'terlambat']);
        }
    }
}