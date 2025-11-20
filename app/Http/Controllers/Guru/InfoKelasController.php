<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\InfoKelas;
use App\Models\Kelas;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InfoKelasController extends Controller
{
    public function index()
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return view('guru.info-kelas.index', ['noGuruData' => true]);
        }
        
        // Get teacher's class (wali kelas)
        $kelas = Kelas::where('wali_kelas_id', $guru->guru_id)->first();
        
        if (!$kelas) {
            return view('guru.info-kelas.index', ['messages' => collect(), 'kelas' => null, 'isWaliKelas' => false]);
        }
        
        // Get all messages for this class
        $messages = InfoKelas::with(['guru', 'kelas'])
            ->where('kelas_id', $kelas->kelas_id)
            ->orderBy('created_at', 'desc')
            ->get();
        
        $isWaliKelas = $kelas->wali_kelas_id == $guru->guru_id;
        
        return view('guru.info-kelas.index', compact('messages', 'kelas', 'isWaliKelas'));
    }
    
    public function store(Request $request)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return redirect()->back()->with('error', 'Data guru tidak ditemukan');
        }
        
        $kelas = Kelas::where('wali_kelas_id', $guru->guru_id)->first();
        
        if (!$kelas) {
            return redirect()->back()->with('error', 'Anda bukan wali kelas');
        }
        
        $request->validate([
            'pesan' => 'required|string',
            'prioritas_pesan' => 'required|in:rendah,sedang,tinggi,penting,darurat'
        ]);
        
        $data = [
            'kelas_id' => $kelas->kelas_id,
            'guru_id' => $guru->guru_id,
            'pesan' => $request->pesan,
            'prioritas_pesan' => $request->prioritas_pesan
        ];
        
        InfoKelas::create($data);
        
        return redirect()->back()->with('success', 'Pesan berhasil dikirim');
    }
}