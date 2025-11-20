<?php

namespace App\Http\Controllers\Kesiswaan;

use App\Http\Controllers\Controller;
use App\Models\Sanksi;
use App\Models\Pelanggaran;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KesiswaanSanksi extends Controller
{
    public function index(Request $request)
    {
        $query = Sanksi::with([
            'pelanggaran.siswa.kelas.jurusan',
            'pelanggaran.jenisPelanggaran',
            'guruPenanggungjawab'
        ]);

        // Search filter
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->whereHas('pelanggaran.siswa', function($siswaQuery) use ($request) {
                    $siswaQuery->where('nama_siswa', 'like', '%' . $request->search . '%')
                               ->orWhere('nis', 'like', '%' . $request->search . '%');
                })
                ->orWhere('jenis_sanksi', 'like', '%' . $request->search . '%');
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
        $sanksi = $query->paginate($perPage)->appends($request->query());

        return view('kesiswaan.sanksi.index', compact('sanksi'));
    }

    public function create(Request $request)
    {
        $pelanggaran_id = $request->get('pelanggaran_id');
        $pelanggaran = null;
        
        if ($pelanggaran_id) {
            $pelanggaran = Pelanggaran::with([
                'siswa.kelas.jurusan',
                'jenisPelanggaran'
            ])->where('pelanggaran_id', $pelanggaran_id)
              ->where('status_verifikasi', 'diverifikasi')
              ->first();
              
            if (!$pelanggaran) {
                return redirect()->route('kesiswaan.sanksi.index')
                    ->with('error', 'Pelanggaran tidak ditemukan atau belum diverifikasi');
            }
        }
        
        $guru = Guru::all();
        
        return view('kesiswaan.sanksi.create', compact('pelanggaran', 'guru'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pelanggaran_id' => 'required|exists:pelanggaran,pelanggaran_id',
            'jenis_sanksi' => 'required|string|max:255',
            'deskripsi_sanksi' => 'nullable|string',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date',
            'status' => 'required|in:direncanakan,berjalan,selesai,ditunda,dibatalkan',
            'guru_penanggungjawab' => 'nullable|exists:guru,guru_id',
            'catatan_pelaksanaan' => 'nullable|string'
        ]);

        // Verify pelanggaran is verified
        $pelanggaran = Pelanggaran::where('pelanggaran_id', $request->pelanggaran_id)
                                  ->where('status_verifikasi', 'diverifikasi')
                                  ->first();
        
        if (!$pelanggaran) {
            return redirect()->back()->with('error', 'Pelanggaran tidak ditemukan atau belum diverifikasi');
        }

        $data = $request->all();
        
        // Auto-fill tanggal_mulai if empty and status is selesai or dibatalkan
        if (empty($data['tanggal_mulai']) && in_array($data['status'], ['selesai', 'dibatalkan'])) {
            $data['tanggal_mulai'] = date('Y-m-d');
        }

        $sanksi = Sanksi::create($data);

        return redirect()->to(\App\Helpers\RouteHelper::route('kesiswaan.sanksi.show', ['sanksi' => $sanksi->sanksi_id]))
            ->with('success', 'Sanksi berhasil ditambahkan');
    }

    public function show(Sanksi $sanksi)
    {
        $sanksi->load([
            'pelanggaran.siswa.kelas.jurusan',
            'pelanggaran.jenisPelanggaran',
            'guruPenanggungjawab'
        ]);

        return view('kesiswaan.sanksi.show', compact('sanksi'));
    }

    public function edit(Sanksi $sanksi)
    {
        $guru = Guru::all();
        
        return view('kesiswaan.sanksi.edit', compact('sanksi', 'guru'));
    }

    public function update(Request $request, Sanksi $sanksi)
    {
        $request->validate([
            'jenis_sanksi' => 'required|string|max:255',
            'deskripsi_sanksi' => 'nullable|string',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date',
            'status' => 'required|in:direncanakan,berjalan,selesai,ditunda,dibatalkan',
            'guru_penanggungjawab' => 'nullable|exists:guru,guru_id',
            'catatan_pelaksanaan' => 'nullable|string'
        ]);

        $data = $request->except(['pelanggaran_id']);
        
        // Auto-fill tanggal_mulai if empty and status is selesai or dibatalkan
        if (empty($data['tanggal_mulai']) && in_array($data['status'], ['selesai', 'dibatalkan'])) {
            $data['tanggal_mulai'] = date('Y-m-d');
        }

        $sanksi->update($data);

        return redirect()->to(\App\Helpers\RouteHelper::route('kesiswaan.sanksi.index'))
            ->with('success', 'Sanksi berhasil diperbarui');
    }

    public function destroy(Sanksi $sanksi)
    {
        $sanksi->delete();
        
        return redirect()->to(\App\Helpers\RouteHelper::route('kesiswaan.sanksi.index'))
            ->with('success', 'Sanksi berhasil dihapus');
    }
}
