<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriPrestasi;
use Illuminate\Http\Request;

class AdminKategoriPrestasi extends Controller
{
    public function index(Request $request)
    {
        $query = KategoriPrestasi::query();
        
        if ($request->has('search') && $request->search) {
            $query->where('nama_kategori', 'like', '%' . $request->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->search . '%');
        }
        
        $perPage = $request->get('per_page', 10);
        $kategori = $query->paginate($perPage)->appends($request->query());
        
        return view('admin.data-master.kategori-prestasi.index', compact('kategori'));
    }

    public function create()
    {
        return view('admin.data-master.kategori-prestasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        KategoriPrestasi::create($request->all());

        return redirect()->route('admin.data-master.kategori-prestasi.index')
                        ->with('success', 'Kategori prestasi berhasil ditambahkan.');
    }

    public function show(KategoriPrestasi $kategoriPrestasi)
    {
        return view('admin.data-master.kategori-prestasi.show', compact('kategoriPrestasi'));
    }

    public function edit(KategoriPrestasi $kategoriPrestasi)
    {
        return view('admin.data-master.kategori-prestasi.edit', compact('kategoriPrestasi'));
    }

    public function update(Request $request, KategoriPrestasi $kategoriPrestasi)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        $kategoriPrestasi->update($request->all());

        return redirect()->route('admin.data-master.kategori-prestasi.index')
                        ->with('success', 'Kategori prestasi berhasil diperbarui.');
    }

    public function destroy(KategoriPrestasi $kategoriPrestasi)
    {
        $kategoriPrestasi->delete();

        return redirect()->route('admin.data-master.kategori-prestasi.index')
                        ->with('success', 'Kategori prestasi berhasil dihapus.');
    }
}