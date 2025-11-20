<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminSiswa extends Controller
{
    public function index(Request $request)
    {
        $query = Siswa::with(['kelas.jurusan']);
        
        if ($request->has('search') && $request->search) {
            $query->where('nama_siswa', 'like', '%' . $request->search . '%')
                  ->orWhere('nis', 'like', '%' . $request->search . '%')
                  ->orWhere('nisn', 'like', '%' . $request->search . '%')
                  ->orWhereHas('kelas', function($q) use ($request) {
                      $q->where('nama_kelas', 'like', '%' . $request->search . '%');
                  });
        }
        
        $perPage = $request->get('per_page', 10);
        $siswa = $query->paginate($perPage)->appends($request->query());
        
        return view('admin.data-master.siswa.index', compact('siswa'));
    }

    public function create()
    {
        $kelas = Kelas::with('jurusan')->get();
        $users = User::where('level', 'siswa')->whereDoesntHave('siswa')->get();
        return view('admin.data-master.siswa.create', compact('kelas', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'nis' => 'required|unique:siswa,nis',
            'nisn' => 'nullable|unique:siswa,nisn',
            'nama_siswa' => 'required',
            'tempat_lahir' => 'nullable',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:laki-laki,perempuan',
            'alamat' => 'nullable',
            'no_telp' => 'nullable',
            'kelas_id' => 'nullable|exists:kelas,kelas_id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->all();
        
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('siswa', 'public');
        }
        
        Siswa::create($data);

        return redirect()->route('admin.data-master.siswa.index')->with('success', 'Siswa berhasil ditambahkan');
    }

    public function show($id)
    {
        $siswa = Siswa::with(['kelas.jurusan', 'user'])->findOrFail($id);
        return view('admin.data-master.siswa.show', compact('siswa'));
    }

    public function edit($id)
    {
        $siswa = Siswa::findOrFail($id);
        $kelas = Kelas::with('jurusan')->get();
        $users = User::where('level', 'siswa')
                    ->where(function($query) use ($siswa) {
                        $query->whereDoesntHave('siswa')
                              ->orWhere('user_id', $siswa->user_id);
                    })->get();
        return view('admin.data-master.siswa.edit', compact('siswa', 'kelas', 'users'));
    }

    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);
        $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'nis' => 'required|unique:siswa,nis,' . $siswa->siswa_id . ',siswa_id',
            'nisn' => 'nullable|unique:siswa,nisn,' . $siswa->siswa_id . ',siswa_id',
            'nama_siswa' => 'required',
            'tempat_lahir' => 'nullable',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:laki-laki,perempuan',
            'alamat' => 'nullable',
            'no_telp' => 'nullable',
            'kelas_id' => 'nullable|exists:kelas,kelas_id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->except(['foto']);
        
        if ($request->hasFile('foto')) {
            if ($siswa->foto && Storage::disk('public')->exists($siswa->foto)) {
                Storage::disk('public')->delete($siswa->foto);
            }
            $data['foto'] = $request->file('foto')->store('siswa', 'public');
        }
        
        $siswa->update($data);

        return redirect()->route('admin.data-master.siswa.index')->with('success', 'Siswa berhasil diupdate');
    }

    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        if ($siswa->foto && Storage::disk('public')->exists($siswa->foto)) {
            Storage::disk('public')->delete($siswa->foto);
        }
        
        $siswa->delete();
        return redirect()->route('admin.data-master.siswa.index')->with('success', 'Siswa berhasil dihapus');
    }
}