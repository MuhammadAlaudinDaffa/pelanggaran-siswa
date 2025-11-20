<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class AdminTahunAjaran extends Controller
{
    public function index(Request $request)
    {
        $query = TahunAjaran::withCount(['pelanggaran', 'prestasi', 'bimbinganKonseling']);
        
        if ($request->has('search') && $request->search) {
            $query->where('tahun_ajaran', 'like', '%' . $request->search . '%')
                  ->orWhere('kode_tahun', 'like', '%' . $request->search . '%');
        }
        
        $perPage = $request->get('per_page', 10);
        $tahunAjaran = $query->paginate($perPage)->appends($request->query());
        
        return view('admin.data-master.tahun-ajaran.index', compact('tahunAjaran'));
    }

    public function create()
    {
        return view('admin.data-master.tahun-ajaran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_tahun' => 'required|unique:tahun_ajaran,kode_tahun',
            'tahun_ajaran' => 'required',
            'semester' => 'required|in:1,2',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai'
        ]);

        $statusAktif = $request->has('status_aktif') ? 1 : 0;
        
        // Jika status aktif, nonaktifkan tahun ajaran lain
        if ($statusAktif) {
            TahunAjaran::where('status_aktif', 1)->update(['status_aktif' => 0]);
        }
        
        TahunAjaran::create([
            'kode_tahun' => $request->kode_tahun,
            'tahun_ajaran' => $request->tahun_ajaran,
            'semester' => $request->semester,
            'status_aktif' => $statusAktif,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai
        ]);

        return redirect()->route('admin.data-master.tahun-ajaran.index')->with('success', 'Tahun Ajaran berhasil ditambahkan');
    }

    public function show($tahun_ajaran_id)
    {
        $tahunAjaran = TahunAjaran::findOrFail($tahun_ajaran_id);
        return view('admin.data-master.tahun-ajaran.show', compact('tahunAjaran'));
    }

    public function edit($tahun_ajaran_id)
    {
        $tahunAjaran = TahunAjaran::findOrFail($tahun_ajaran_id);
        return view('admin.data-master.tahun-ajaran.edit', compact('tahunAjaran'));
    }

    public function update(Request $request, $tahun_ajaran_id)
    {
        $request->validate([
            'kode_tahun' => 'required|unique:tahun_ajaran,kode_tahun,' . $tahun_ajaran_id . ',tahun_ajaran_id',
            'tahun_ajaran' => 'required',
            'semester' => 'required|in:1,2',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai'
        ]);

        $statusAktif = $request->has('status_aktif') ? 1 : 0;
        
        // Jika status aktif, nonaktifkan tahun ajaran lain
        if ($statusAktif) {
            TahunAjaran::where('status_aktif', 1)
                      ->where('tahun_ajaran_id', '!=', $tahun_ajaran_id)
                      ->update(['status_aktif' => 0]);
        }
        
        $tahunAjaran = TahunAjaran::findOrFail($tahun_ajaran_id);
        $tahunAjaran->update([
            'kode_tahun' => $request->kode_tahun,
            'tahun_ajaran' => $request->tahun_ajaran,
            'semester' => $request->semester,
            'status_aktif' => $statusAktif,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai
        ]);

        return redirect()->route('admin.data-master.tahun-ajaran.index')->with('success', 'Tahun Ajaran berhasil diupdate');
    }

    public function destroy($tahun_ajaran_id)
    {
        $tahunAjaran = TahunAjaran::withCount(['pelanggaran', 'prestasi', 'bimbinganKonseling'])->findOrFail($tahun_ajaran_id);
        
        // Cek apakah masih ada data terkait
        $totalData = $tahunAjaran->pelanggaran_count + $tahunAjaran->prestasi_count + $tahunAjaran->bimbingan_konseling_count;
        
        if ($totalData > 0) {
            return redirect()->route('admin.data-master.tahun-ajaran.index')
                           ->with('error', 'Tidak dapat menghapus tahun ajaran karena masih memiliki data terkait (' . $totalData . ' data)');
        }
        
        $tahunAjaran->delete();
        return redirect()->route('admin.data-master.tahun-ajaran.index')->with('success', 'Tahun Ajaran berhasil dihapus');
    }
}