<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;

class AdminGuru extends Controller
{
    public function index(Request $request)
    {
        $query = Guru::with('user');
        
        if ($request->has('search') && $request->search) {
            $query->where('nama_guru', 'like', '%' . $request->search . '%')
                  ->orWhere('nip', 'like', '%' . $request->search . '%')
                  ->orWhere('bidang_studi', 'like', '%' . $request->search . '%');
        }
        
        $perPage = $request->get('per_page', 10);
        $guru = $query->paginate($perPage)->appends($request->query());
        
        return view('admin.data-master.guru.index', compact('guru'));
    }

    public function create()
    {
        $users = User::whereNotIn('level', ['orang_tua', 'siswa'])->get();
        return view('admin.data-master.guru.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'nip' => 'nullable|string',
            'nama_guru' => 'required|string',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'bidang_studi' => 'nullable|string',
            'email' => 'nullable|email',
            'no_telp' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif'
        ]);

        Guru::create($request->all());

        return redirect()->route('admin.data-master.guru-management.index')->with('success', 'Guru berhasil ditambahkan');
    }

    public function show($id)
    {
        $guru = Guru::with('user')->findOrFail($id);
        return view('admin.data-master.guru.show', compact('guru'));
    }

    public function edit($id)
    {
        $guru = Guru::with('user')->findOrFail($id);
        $users = User::whereNotIn('level', ['orang_tua', 'siswa'])->get();
        return view('admin.data-master.guru.edit', compact('guru', 'users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'nip' => 'nullable|string',
            'nama_guru' => 'required|string',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'bidang_studi' => 'nullable|string',
            'email' => 'nullable|email',
            'no_telp' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif'
        ]);

        $guru = Guru::findOrFail($id);
        $guru->update($request->all());

        return redirect()->route('admin.data-master.guru-management.index')->with('success', 'Guru berhasil diupdate');
    }

    public function destroy($id)
    {
        $guru = Guru::findOrFail($id);
        $guru->delete();
        return redirect()->route('admin.data-master.guru-management.index')->with('success', 'Guru berhasil dihapus');
    }
}