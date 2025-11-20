<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\JenisPelanggaran;
use App\Models\JenisPrestasi;
use App\Models\Sanksi;
use App\Models\User;
use App\Models\Pelanggaran;
use App\Models\Prestasi;
use App\Models\BimbinganKonseling;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminDashboard extends Controller
{
    public function index(Request $request)
    {
        $data = [
            'siswa' => Siswa::count(),
            'kelas' => Kelas::count(),
            'jurusan' => Jurusan::count(),
            'users' => User::count(),
            'jenis_pelanggaran' => JenisPelanggaran::count(),
            'jenis_prestasi' => JenisPrestasi::count(),
            'pelanggaran' => Pelanggaran::count(),
            'prestasi' => Prestasi::count(),
            'sanksi' => Sanksi::count(),
            'bimbingan_konseling' => BimbinganKonseling::count()
        ];
        
        // Get tahun ajaran for dropdown
        $tahunAjaran = TahunAjaran::orderBy('tanggal_mulai', 'desc')->get();
        $selectedTahun = $request->get('tahun_ajaran', $tahunAjaran->first()->tahun_ajaran_id ?? null);
        
        // Get chart data
        $chartData = $this->getChartData($selectedTahun);
        
        return view('admin.index', compact('data', 'tahunAjaran', 'selectedTahun', 'chartData'));
    }
    
    private function getChartData($tahunAjaranId)
    {
        if (!$tahunAjaranId) {
            return ['months' => [], 'pelanggaran' => [], 'prestasi' => []];
        }
        
        $tahunAjaran = TahunAjaran::find($tahunAjaranId);
        if (!$tahunAjaran) {
            return ['months' => [], 'pelanggaran' => [], 'prestasi' => []];
        }
        
        $startDate = Carbon::parse($tahunAjaran->tanggal_mulai);
        $endDate = Carbon::parse($tahunAjaran->tanggal_selesai);
        
        $months = [];
        $pelanggaranData = [];
        $prestasiData = [];
        
        $current = $startDate->copy();
        while ($current->lte($endDate)) {
            $monthYear = $current->format('Y-m');
            $monthName = $current->format('M Y');
            
            $months[] = $monthName;
            
            // Count pelanggaran with status 'diverifikasi'
            $pelanggaranCount = Pelanggaran::where('status_verifikasi', 'diverifikasi')
                ->whereYear('created_at', $current->year)
                ->whereMonth('created_at', $current->month)
                ->count();
            
            // Count prestasi with status 'diverifikasi'
            $prestasiCount = Prestasi::where('status_verifikasi', 'diverifikasi')
                ->whereYear('created_at', $current->year)
                ->whereMonth('created_at', $current->month)
                ->count();
            
            $pelanggaranData[] = $pelanggaranCount;
            $prestasiData[] = $prestasiCount;
            
            $current->addMonth();
        }
        
        return [
            'months' => $months,
            'pelanggaran' => $pelanggaranData,
            'prestasi' => $prestasiData
        ];
    }
}
