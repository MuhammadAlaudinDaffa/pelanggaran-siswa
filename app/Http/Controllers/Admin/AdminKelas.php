<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\Guru;
use Illuminate\Http\Request;

class AdminKelas extends Controller
{
    public function index(Request $request)
    {
        $query = Kelas::with(['jurusan', 'waliKelas']);
        
        if ($request->has('search') && $request->search) {
            $query->where('nama_kelas', 'like', '%' . $request->search . '%')
                  ->orWhereHas('jurusan', function($q) use ($request) {
                      $q->where('nama_jurusan', 'like', '%' . $request->search . '%');
                  })
                  ->orWhereHas('waliKelas', function($q) use ($request) {
                      $q->where('nama_guru', 'like', '%' . $request->search . '%');
                  });
        }
        
        $perPage = $request->get('per_page', 10);
        $kelas = $query->paginate($perPage)->appends($request->query());
        
        return view('admin.data-master.kelas.index', compact('kelas'));
    }

    public function create()
    {
        $jurusan = Jurusan::all();
        $guru = Guru::where('status', 'aktif')->get();
        return view('admin.data-master.kelas.create', compact('jurusan', 'guru'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required',
            'jurusan_id' => 'required|exists:jurusan,jurusan_id',
            'kapasitas' => 'required|integer|min:1',
            'wali_kelas_id' => 'nullable|exists:guru,guru_id'
        ]);

        Kelas::create($request->all());

        return redirect()->route('admin.data-master.kelas.index')->with('success', 'Kelas berhasil ditambahkan');
    }

    public function show($id)
    {
        $kelas = Kelas::findOrFail($id);
        return view('admin.data-master.kelas.show', compact('kelas'));
    }

    public function edit($id)
    {
        $kelas = Kelas::findOrFail($id);
        $jurusan = Jurusan::all();
        $guru = Guru::where('status', 'aktif')->get();
        return view('admin.data-master.kelas.edit', compact('kelas', 'jurusan', 'guru'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kelas' => 'required',
            'jurusan_id' => 'required|exists:jurusan,jurusan_id',
            'kapasitas' => 'required|integer|min:1',
            'wali_kelas_id' => 'nullable|exists:guru,guru_id'
        ]);

        $kelas = Kelas::findOrFail($id);
        $kelas->update($request->all());

        return redirect()->route('admin.data-master.kelas.index')->with('success', 'Kelas berhasil diupdate');
    }

    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();
        return redirect()->route('admin.data-master.kelas.index')->with('success', 'Kelas berhasil dihapus');
    }
}