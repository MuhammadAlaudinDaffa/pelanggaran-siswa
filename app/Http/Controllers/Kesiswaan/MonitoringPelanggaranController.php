<?php

namespace App\Http\Controllers\Kesiswaan;

use App\Http\Controllers\Controller;
use App\Models\MonitoringPelanggaran;
use App\Models\Pelanggaran;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MonitoringPelanggaranController extends Controller
{
    public function index()
    {
        $monitoring = MonitoringPelanggaran::with(['pelanggaran.siswa.kelas', 'pelanggaran.jenisPelanggaran', 'guruKepsek'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('kesiswaan.monitoring_pelanggaran.index', compact('monitoring'));
    }

    public function show($id)
    {
        $monitoring = MonitoringPelanggaran::with(['pelanggaran.siswa.kelas', 'pelanggaran.jenisPelanggaran', 'guruKepsek'])
            ->findOrFail($id);

        return view('kesiswaan.monitoring_pelanggaran.show', compact('monitoring'));
    }

    public function create(Request $request)
    {
        $query = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran'])
            ->where('status_verifikasi', 'diverifikasi')
            ->whereNotExists(function($q) {
                $q->select('*')
                  ->from('monitoring_pelanggaran')
                  ->whereColumn('monitoring_pelanggaran.pelanggaran_id', 'pelanggaran.pelanggaran_id');
            });

        // Search filter
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->whereHas('siswa', function($siswaQuery) use ($request) {
                    $siswaQuery->where('nama_siswa', 'like', '%' . $request->search . '%')
                               ->orWhere('nis', 'like', '%' . $request->search . '%');
                })
                ->orWhereHas('jenisPelanggaran', function($jenisQuery) use ($request) {
                    $jenisQuery->where('nama_pelanggaran', 'like', '%' . $request->search . '%');
                });
            });
        }

        $availablePelanggaran = $query->get();

        return view('kesiswaan.monitoring_pelanggaran.create', compact('availablePelanggaran'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pelanggaran_id' => 'required|exists:pelanggaran,pelanggaran_id'
        ]);

        // Check if monitoring already exists for this pelanggaran
        $existingMonitoring = MonitoringPelanggaran::where('pelanggaran_id', $request->pelanggaran_id)->first();
        if ($existingMonitoring) {
            return back()->with('error', 'Monitoring untuk pelanggaran ini sudah ada.');
        }

        // Get kepala sekolah guru or use current user if admin/kesiswaan
        $guruKepsek = null;
        $kepsekUser = User::where('level', 'kepala_sekolah')->first();
        if ($kepsekUser) {
            $guruKepsek = Guru::where('user_id', $kepsekUser->user_id)->first();
        }
        
        // If no kepala_sekolah found, use current user if they are admin/kesiswaan
        if (!$guruKepsek && in_array(Auth::user()->level, ['admin', 'kesiswaan'])) {
            $guruKepsek = Guru::where('user_id', Auth::id())->first();
        }

        if (!$guruKepsek) {
            return back()->with('error', 'Tidak dapat menentukan penanggung jawab monitoring.');
        }

        $currentTime = now()->format('d/m/Y H:i');
        $userName = Auth::user()->nama_lengkap;
        
        $monitoring = MonitoringPelanggaran::create([
            'pelanggaran_id' => $request->pelanggaran_id,
            'guru_kepsek_id' => $guruKepsek->guru_id,
            'status_monitoring' => 'dipantau',
            'catatan_monitoring' => "Monitoring dimulai secara otomatis\n\n[Dibuat oleh: {$userName} pada {$currentTime}]",
            'tanggal_monitoring' => date('Y-m-d'),
            'tindak_lanjut' => null
        ]);

        return redirect()->to(\App\Helpers\RouteHelper::route('kesiswaan.monitoring_pelanggaran.show', $monitoring->monitoring_id))
            ->with('success', 'Monitoring pelanggaran berhasil dibuat.');
    }

    public function edit($id)
    {
        $monitoring = MonitoringPelanggaran::with(['pelanggaran.siswa.kelas', 'pelanggaran.jenisPelanggaran'])
            ->findOrFail($id);

        return view('kesiswaan.monitoring_pelanggaran.edit', compact('monitoring'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status_monitoring' => 'required|in:dipantau,tindak_lanjut,progres_baik,selesai,eskalasi',
            'tanggal_monitoring' => 'required|date',
            'catatan_monitoring' => 'nullable|string',
            'tindak_lanjut' => 'nullable|string'
        ]);

        $monitoring = MonitoringPelanggaran::findOrFail($id);
        
        $currentTime = now()->format('d/m/Y H:i');
        $userName = Auth::user()->nama_lengkap;
        
        $data = $request->only([
            'status_monitoring',
            'tanggal_monitoring',
            'catatan_monitoring',
            'tindak_lanjut'
        ]);
        
        // Append edit log to catatan_monitoring
        if ($data['catatan_monitoring']) {
            $data['catatan_monitoring'] .= "\n\n[Diedit oleh: {$userName} pada {$currentTime}]";
        } else {
            $data['catatan_monitoring'] = "[Diedit oleh: {$userName} pada {$currentTime}]";
        }
        
        $monitoring->update($data);

        return redirect()->to(\App\Helpers\RouteHelper::route('kesiswaan.monitoring_pelanggaran.show', $monitoring->monitoring_id))
            ->with('success', 'Monitoring pelanggaran berhasil diperbarui.');
    }
}