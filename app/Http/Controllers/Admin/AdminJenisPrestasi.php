<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisPrestasi;
use App\Models\KategoriPrestasi;
use Illuminate\Http\Request;

class AdminJenisPrestasi extends Controller
{
    public function index(Request $request)
    {
        $query = JenisPrestasi::with('kategoriPrestasi');
        
        if ($request->has('search') && $request->search) {
            $query->where('nama_prestasi', 'like', '%' . $request->search . '%')
                  ->orWhereHas('kategoriPrestasi', function($q) use ($request) {
                      $q->where('nama_kategori', 'like', '%' . $request->search . '%');
                  });
        }
        
        $perPage = $request->get('per_page', 10);
        $j_prestasi = $query->paginate($perPage)->appends($request->query());
        
        return view('admin.data-master.jenis-prestasi.index', compact('j_prestasi'));
    }

    public function create()
    {
        $kategoriPrestasi = KategoriPrestasi::all();
        return view('admin.data-master.jenis-prestasi.create', compact('kategoriPrestasi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_prestasi' => 'required|string|max:255',
            'kategori_prestasi_id' => 'required|exists:kategori_prestasi,kategori_prestasi_id',
            'poin' => 'required|integer|min:1',
            'deskripsi' => 'nullable|string',
            'reward' => 'nullable|string',
        ]);

        JenisPrestasi::create($request->all());

        return redirect()->route('admin.data-master.jenis-prestasi.index')
                        ->with('success', 'Jenis prestasi berhasil ditambahkan.');
    }

    public function show(JenisPrestasi $jenisPrestasi)
    {
        $prestasi = $jenisPrestasi->load('kategoriPrestasi');
        return view('admin.data-master.jenis-prestasi.show', compact('prestasi'));
    }

    public function edit(JenisPrestasi $jenisPrestasi)
    {
        $prestasi = $jenisPrestasi;
        $kategoriPrestasi = KategoriPrestasi::all();
        return view('admin.data-master.jenis-prestasi.edit', compact('prestasi', 'kategoriPrestasi'));
    }

    public function update(Request $request, JenisPrestasi $jenisPrestasi)
    {
        $request->validate([
            'nama_prestasi' => 'required|string|max:255',
            'kategori_prestasi_id' => 'required|exists:kategori_prestasi,kategori_prestasi_id',
            'poin' => 'required|integer|min:1',
            'deskripsi' => 'nullable|string',
            'reward' => 'nullable|string',
        ]);

        $jenisPrestasi->update($request->all());

        return redirect()->route('admin.data-master.jenis-prestasi.index')
                        ->with('success', 'Jenis prestasi berhasil diperbarui.');
    }

    public function destroy(JenisPrestasi $jenisPrestasi)
    {
        $jenisPrestasi->delete();

        return redirect()->route('admin.data-master.jenis-prestasi.index')
                        ->with('success', 'Jenis prestasi berhasil dihapus.');
    }
}