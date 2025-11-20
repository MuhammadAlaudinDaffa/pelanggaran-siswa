<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserManager extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('username', 'like', "%{$search}%")
                  ->orWhere('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('level', 'like', "%{$search}%");
            });
        }
        
        $users = $query->paginate($request->get('per_page', 10))
                      ->appends($request->query());
        
        return view('admin.data-master.user.index', compact('users'));
    }

    public function create()
    {
        $kelas = \App\Models\Kelas::with('jurusan')->get();
        return view('admin.data-master.user.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $rules = [
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
            'nama_lengkap' => 'required',
            'level' => 'required|in:admin,kepala_sekolah,kesiswaan,bimbingan_konseling,guru,orang_tua,siswa',
            'can_verify' => 'boolean'
        ];
        
        // Add validation for siswa fields
        if ($request->level === 'siswa') {
            $rules['nis'] = 'required|unique:siswa,nis';
            $rules['nama_siswa'] = 'required';
        }
        
        // Add validation for guru fields
        if ($request->level === 'guru') {
            $rules['nama_guru'] = 'required';
            $rules['jenis_kelamin_guru'] = 'required|in:laki-laki,perempuan';
            $rules['status'] = 'required|in:aktif,nonaktif';
        }
        
        $request->validate($rules);

        $canVerify = $request->level === 'orang_tua' ? 0 : $request->boolean('can_verify');
        
        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'nama_lengkap' => $request->nama_lengkap,
            'level' => $request->level,
            'can_verify' => $canVerify,
            'is_active' => 1
        ]);
        
        // Create siswa record if level is siswa
        if ($request->level === 'siswa') {
            \App\Models\Siswa::create([
                'user_id' => $user->user_id,
                'nis' => $request->nis,
                'nisn' => $request->nisn,
                'nama_siswa' => $request->nama_siswa,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin_siswa,
                'kelas_id' => $request->kelas_id
            ]);
        }
        
        // Create guru record if level is guru
        if ($request->level === 'guru') {
            \App\Models\Guru::create([
                'user_id' => $user->user_id,
                'nip' => $request->nip,
                'nama_guru' => $request->nama_guru,
                'jenis_kelamin' => $request->jenis_kelamin_guru,
                'bidang_studi' => $request->bidang_studi,
                'email' => $request->email,
                'status' => $request->status
            ]);
        }

        return redirect()->route('admin.data-master.user.index')->with('success', 'User berhasil ditambahkan');
    }

    public function show(User $user)
    {
        return view('admin.data-master.user.show', compact('user'));
    }

    public function edit(User $user)
    {
        if ($user->user_id === 1) {
            return redirect()->route('admin.data-master.user.index')->with('error', 'Admin utama tidak dapat dimodifikasi');
        }
        return view('admin.data-master.user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if ($user->user_id === 1) {
            return redirect()->route('admin.data-master.user.index')->with('error', 'Admin utama tidak dapat dimodifikasi');
        }

        $request->validate([
            'username' => 'required|unique:users,username,' . $user->user_id . ',user_id',
            'password' => 'nullable|min:6',
            'nama_lengkap' => 'required',
            'level' => 'required|in:admin,kepala_sekolah,kesiswaan,bimbingan_konseling,guru,orang_tua,siswa',
            'can_verify' => 'boolean'
        ]);

        $canVerify = $request->level === 'orang_tua' ? 0 : $request->boolean('can_verify');
        
        $data = [
            'username' => $request->username,
            'nama_lengkap' => $request->nama_lengkap,
            'level' => $request->level,
            'can_verify' => $canVerify,
            'is_active' => $request->boolean('is_active')
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.data-master.user.index')->with('success', 'User berhasil diupdate');
    }

    public function destroy(User $user)
    {
        if ($user->user_id === 1) {
            return redirect()->route('admin.data-master.user.index')->with('error', 'Admin utama tidak dapat dihapus');
        }
        $user->delete();
        return redirect()->route('admin.data-master.user.index')->with('success', 'User berhasil dihapus');
    }
}
