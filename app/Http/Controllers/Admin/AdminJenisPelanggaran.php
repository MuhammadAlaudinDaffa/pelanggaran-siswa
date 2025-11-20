<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisPelanggaran;
use App\Models\KategoriPelanggaran;
use Illuminate\Http\Request;

class AdminJenisPelanggaran extends Controller
{
    public function index(Request $request)
    {
        $query = JenisPelanggaran::with('kategoriPelanggaran');
        
        if ($request->has('search') && $request->search) {
            $query->where('nama_pelanggaran', 'like', '%' . $request->search . '%')
                  ->orWhereHas('kategoriPelanggaran', function($q) use ($request) {
                      $q->where('nama_kategori', 'like', '%' . $request->search . '%');
                  });
        }
        
        $perPage = $request->get('per_page', 10);
        $j_pelanggaran = $query->paginate($perPage)->appends($request->query());
        
        return view('admin.data-master.jenis-pelanggaran.index', compact('j_pelanggaran'));
    }
    
    public function create()
    {
        $kategoriPelanggaran = KategoriPelanggaran::all();
        return view('admin.data-master.jenis-pelanggaran.create', compact('kategoriPelanggaran'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pelanggaran' => 'required|string|max:255',
            'kategori_pelanggaran_id' => 'required|exists:kategori_pelanggaran,kategori_pelanggaran_id',
            'poin' => 'required|integer|min:1',
            'deskripsi' => 'nullable|string',
            'sanksi_rekomendasi' => 'nullable|string',
        ]);

        JenisPelanggaran::create($request->all());

        return redirect()->route('admin.data-master.jenis-pelanggaran.index')
                        ->with('success', 'Jenis pelanggaran berhasil ditambahkan.');
    }

    public function show(JenisPelanggaran $jenisPelanggaran)
    {
        $pelanggaran = $jenisPelanggaran->load('kategoriPelanggaran');
        return view('admin.data-master.jenis-pelanggaran.show', compact('pelanggaran'));
    }

    public function edit(JenisPelanggaran $jenisPelanggaran)
    {
        $pelanggaran = $jenisPelanggaran;
        $kategoriPelanggaran = KategoriPelanggaran::all();
        return view('admin.data-master.jenis-pelanggaran.edit', compact('pelanggaran', 'kategoriPelanggaran'));
    }

    public function update(Request $request, JenisPelanggaran $jenisPelanggaran)
    {
        $request->validate([
            'nama_pelanggaran' => 'required|string|max:255',
            'kategori_pelanggaran_id' => 'required|exists:kategori_pelanggaran,kategori_pelanggaran_id',
            'poin' => 'required|integer|min:1',
            'deskripsi' => 'nullable|string',
            'sanksi_rekomendasi' => 'nullable|string',
        ]);

        $jenisPelanggaran->update($request->all());

        return redirect()->route('admin.data-master.jenis-pelanggaran.index')
                        ->with('success', 'Jenis pelanggaran berhasil diperbarui.');
    }

    public function destroy(JenisPelanggaran $jenisPelanggaran)
    {
        $jenisPelanggaran->delete();

        return redirect()->route('admin.data-master.jenis-pelanggaran.index')
                        ->with('success', 'Jenis pelanggaran berhasil dihapus.');
    }
}