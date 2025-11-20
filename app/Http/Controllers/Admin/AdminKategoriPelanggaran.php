<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriPelanggaran;
use Illuminate\Http\Request;

class AdminKategoriPelanggaran extends Controller
{
    public function index(Request $request)
    {
        $query = KategoriPelanggaran::query();
        
        if ($request->has('search') && $request->search) {
            $query->where('nama_kategori', 'like', '%' . $request->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->search . '%');
        }
        
        $perPage = $request->get('per_page', 10);
        $kategori = $query->paginate($perPage)->appends($request->query());
        
        return view('admin.data-master.kategori-pelanggaran.index', compact('kategori'));
    }

    public function create()
    {
        return view('admin.data-master.kategori-pelanggaran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        KategoriPelanggaran::create($request->all());

        return redirect()->route('admin.data-master.kategori-pelanggaran.index')
                        ->with('success', 'Kategori pelanggaran berhasil ditambahkan.');
    }

    public function show(KategoriPelanggaran $kategoriPelanggaran)
    {
        return view('admin.data-master.kategori-pelanggaran.show', compact('kategoriPelanggaran'));
    }

    public function edit(KategoriPelanggaran $kategoriPelanggaran)
    {
        return view('admin.data-master.kategori-pelanggaran.edit', compact('kategoriPelanggaran'));
    }

    public function update(Request $request, KategoriPelanggaran $kategoriPelanggaran)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        $kategoriPelanggaran->update($request->all());

        return redirect()->route('admin.data-master.kategori-pelanggaran.index')
                        ->with('success', 'Kategori pelanggaran berhasil diperbarui.');
    }

    public function destroy(KategoriPelanggaran $kategoriPelanggaran)
    {
        $kategoriPelanggaran->delete();

        return redirect()->route('admin.data-master.kategori-pelanggaran.index')
                        ->with('success', 'Kategori pelanggaran berhasil dihapus.');
    }
}
