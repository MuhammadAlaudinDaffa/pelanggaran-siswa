<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class AdminJurusan extends Controller
{
    public function index(Request $request)
    {
        $query = Jurusan::query();
        
        if ($request->has('search') && $request->search) {
            $query->where('nama_jurusan', 'like', '%' . $request->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->search . '%');
        }
        
        $perPage = $request->get('per_page', 10);
        $jurusan = $query->paginate($perPage)->appends($request->query());
        
        return view('admin.data-master.jurusan.index', compact('jurusan'));
    }

    public function create()
    {
        return view('admin.data-master.jurusan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jurusan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        Jurusan::create($request->all());

        return redirect()->route('admin.data-master.jurusan.index')
                        ->with('success', 'Jurusan berhasil ditambahkan.');
    }

    public function show(Jurusan $jurusan)
    {
        return view('admin.data-master.jurusan.show', compact('jurusan'));
    }

    public function edit(Jurusan $jurusan)
    {
        return view('admin.data-master.jurusan.edit', compact('jurusan'));
    }

    public function update(Request $request, Jurusan $jurusan)
    {
        $request->validate([
            'nama_jurusan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        $jurusan->update($request->all());

        return redirect()->route('admin.data-master.jurusan.index')
                        ->with('success', 'Jurusan berhasil diperbarui.');
    }

    public function destroy(Jurusan $jurusan)
    {
        $jurusan->delete();

        return redirect()->route('admin.data-master.jurusan.index')
                        ->with('success', 'Jurusan berhasil dihapus.');
    }
}