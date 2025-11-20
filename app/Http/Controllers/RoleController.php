<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Orangtua;
use App\Models\Siswa;

class RoleController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function register($role)
    {
        $roleNames = [
            'orang_tua' => 'Orang Tua',
            'siswa' => 'Siswa'
        ];
        
        if (!array_key_exists($role, $roleNames)) {
            return redirect()->route('role.selection')->with('error','Anda dilarang melakukan register sebagai akun bersifat privasi. Hubungi admin untuk detail lebih lanjut.');
        }
        
        $roleName = $roleNames[$role];
        
        return view('auth.register', compact('role', 'roleName'));
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('username', $credentials['username'])->first();
        
        if ($user && Hash::check($credentials['password'], $user->password)) {
            // Update last_login
            $user->update(['last_login' => now()]);
            
            Auth::login($user, $request->boolean('remember'));
            $request->session()->regenerate();
            return redirect()->route($user->level . '.index');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function handleRegister(Request $request)
    {
        if ($request->level === 'orang_tua') {
            $request->validate([
                'username' => 'required|unique:users',
                'password' => 'required|min:6',
                'nama_lengkap' => 'required',
                'nisn_siswa' => 'required|exists:siswa,nisn',
                'hubungan' => 'required|in:ayah,ibu,wali',
                'pekerjaan' => 'required',
                'alamat' => 'required'
            ]);

            // Find siswa by NISN
            $siswa = Siswa::where('nisn', $request->nisn_siswa)->first();

            // Check if siswa already has 3 parent accounts
            $parentCount = Orangtua::where('siswa_id', $siswa->siswa_id)->count();
            if ($parentCount >= 3) {
                return back()->withErrors([
                    'nisn_siswa' => 'Siswa ini sudah memiliki 3 akun orang tua. Maksimal 3 akun per siswa.'
                ])->withInput();
            }

            // Create User with last_login as null initially
            $user = User::create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'nama_lengkap' => $request->nama_lengkap,
                'level' => 'orang_tua',
                'can_verify' => 0,
                'is_active' => 1,
                'last_login' => null
            ]);

            // Create Orangtua
            Orangtua::create([
                'user_id' => $user->user_id,
                'siswa_id' => $siswa->siswa_id,
                'hubungan' => $request->hubungan,
                'nama_orangtua' => $request->nama_lengkap,
                'pekerjaan' => $request->pekerjaan,
                'alamat' => $request->alamat
            ]);

            return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
        }

        return redirect()->route('login')->with('error', 'Registrasi gagal');
    }

    public function staffLogin()
    {
        return view('auth.staff-login');
    }

    public function staffAuthenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        // Cari user berdasarkan username dan level staff
        $user = User::where('username', $credentials['username'])
                   ->whereIn('level', ['admin', 'kepala_sekolah', 'kesiswaan', 'bimbingan_konseling', 'guru'])
                   ->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            // Update last_login with current timestamp
            $user->update(['last_login' => now()]);
            
            Auth::login($user, $request->boolean('remember'));
            $request->session()->regenerate();
            return redirect()->route($user->level . '.index');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah, atau Anda bukan staff sekolah.',
        ])->onlyInput('username');
    }
}