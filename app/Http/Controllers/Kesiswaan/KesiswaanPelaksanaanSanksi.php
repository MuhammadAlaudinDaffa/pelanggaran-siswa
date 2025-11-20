<?php

namespace App\Http\Controllers\Kesiswaan;

use App\Http\Controllers\Controller;
use App\Models\PelaksanaanSanksi;
use App\Models\Sanksi;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class KesiswaanPelaksanaanSanksi extends Controller
{
    public function index(Request $request)
    {
        $query = PelaksanaanSanksi::with([
            'sanksi.pelanggaran.siswa.kelas.jurusan',
            'sanksi.pelanggaran.jenisPelanggaran',
            'guruPengawas'
        ]);

        // Auto update overdue statuses
        $this->updateOverdueStatuses();

        // Search filter
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->whereHas('sanksi.pelanggaran.siswa', function($siswaQuery) use ($request) {
                    $siswaQuery->where('nama_siswa', 'like', '%' . $request->search . '%')
                               ->orWhere('nis', 'like', '%' . $request->search . '%');
                })
                ->orWhere('deskripsi_pelaksanaan', 'like', '%' . $request->search . '%');
            });
        }

        // Status filter
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Sorting
        $sort = $request->get('sort', 'desc');
        $query->orderBy('created_at', $sort);

        // Pagination
        $perPage = $request->get('per_page', 10);
        $pelaksanaan = $query->paginate($perPage)->appends($request->query());

        return view('kesiswaan.pelaksanaan_sanksi.index', compact('pelaksanaan'));
    }

    public function show(PelaksanaanSanksi $pelaksanaanSanksi)
    {
        $pelaksanaanSanksi->load([
            'sanksi.pelanggaran.siswa.kelas.jurusan',
            'sanksi.pelanggaran.jenisPelanggaran',
            'guruPengawas'
        ]);

        return view('kesiswaan.pelaksanaan_sanksi.show', compact('pelaksanaanSanksi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sanksi_id' => 'required|exists:sanksi,sanksi_id',
            'tanggal_pelaksanaan' => 'required|date',
            'deskripsi_pelaksanaan' => 'nullable|string',
            'status' => 'required|in:terjadwal,dikerjakan,tuntas,terlambat,perpanjangan',
            'guru_pengawas' => 'nullable|exists:guru,guru_id',
            'catatan' => 'nullable|string',
            'bukti_pelaksanaan' => 'nullable|file|max:2048'
        ]);

        // Verify sanksi is not cancelled
        $sanksi = Sanksi::where('sanksi_id', $request->sanksi_id)
                        ->where('status', '!=', 'dibatalkan')
                        ->first();
        
        if (!$sanksi) {
            return redirect()->back()->with('error', 'Sanksi tidak ditemukan atau sudah dibatalkan');
        }

        $data = $request->except(['bukti_pelaksanaan']);
        
        if ($request->hasFile('bukti_pelaksanaan')) {
            $data['bukti_pelaksanaan'] = $request->file('bukti_pelaksanaan')->store('pelaksanaan_sanksi', 'public');
        }

        PelaksanaanSanksi::create($data);

        return redirect()->to(\App\Helpers\RouteHelper::route('kesiswaan.sanksi.show', ['sanksi' => $request->sanksi_id]))
            ->with('success', 'Pelaksanaan sanksi berhasil ditambahkan');
    }

    public function update(Request $request, PelaksanaanSanksi $pelaksanaanSanksi)
    {
        $request->validate([
            'tanggal_pelaksanaan' => 'required|date',
            'deskripsi_pelaksanaan' => 'nullable|string',
            'status' => 'required|in:terjadwal,dikerjakan,tuntas,terlambat,perpanjangan',
            'guru_pengawas' => 'nullable|exists:guru,guru_id',
            'catatan' => 'nullable|string',
            'bukti_pelaksanaan' => 'nullable|file|max:2048'
        ]);

        $data = $request->except(['bukti_pelaksanaan']);
        
        if ($request->hasFile('bukti_pelaksanaan')) {
            if ($pelaksanaanSanksi->bukti_pelaksanaan && \Storage::disk('public')->exists($pelaksanaanSanksi->bukti_pelaksanaan)) {
                \Storage::disk('public')->delete($pelaksanaanSanksi->bukti_pelaksanaan);
            }
            $data['bukti_pelaksanaan'] = $request->file('bukti_pelaksanaan')->store('pelaksanaan_sanksi', 'public');
        }

        $pelaksanaanSanksi->update($data);

        return redirect()->to(\App\Helpers\RouteHelper::route('kesiswaan.pelaksanaan_sanksi.show', $pelaksanaanSanksi->pelaksanaan_id))
            ->with('success', 'Pelaksanaan sanksi berhasil diperbarui');
    }

    public function destroy(PelaksanaanSanksi $pelaksanaanSanksi)
    {
        if ($pelaksanaanSanksi->bukti_pelaksanaan && \Storage::disk('public')->exists($pelaksanaanSanksi->bukti_pelaksanaan)) {
            \Storage::disk('public')->delete($pelaksanaanSanksi->bukti_pelaksanaan);
        }
        
        $pelaksanaanSanksi->delete();
        
        return redirect()->to(\App\Helpers\RouteHelper::route('kesiswaan.pelaksanaan_sanksi.index'))
            ->with('success', 'Pelaksanaan sanksi berhasil dihapus');
    }

    private function updateOverdueStatuses()
    {
        $now = Carbon::now('Asia/Jakarta');
        
        PelaksanaanSanksi::where('status', '!=', 'tuntas')
            ->where('status', '!=', 'terlambat')
            ->whereDate('tanggal_pelaksanaan', '<', $now->toDateString())
            ->update(['status' => 'terlambat']);
    }
}