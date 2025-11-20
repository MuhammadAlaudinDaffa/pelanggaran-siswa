<?php

namespace App\Http\Controllers\Kesiswaan;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Pelanggaran;
use App\Models\Prestasi;
use Illuminate\Http\Request;

class SiswaOverviewController extends Controller
{
    public function index(Request $request)
    {
        // Guru access control - only show students from their class
        if (auth()->user()->level === 'guru') {
            $guru = \App\Models\Guru::where('user_id', auth()->id())->first();
            if (!$guru) {
                return view('kesiswaan.siswa_overview.index', ['noGuruData' => true]);
            }
            
            $kelas = \App\Models\Kelas::where('wali_kelas_id', $guru->guru_id)->first();
            if (!$kelas) {
                return view('kesiswaan.siswa_overview.index', ['siswa' => collect(), 'isGuru' => true]);
            }
        }
        
        $query = Siswa::with(['kelas.jurusan'])
            ->withCount([
                'pelanggaran as total_pelanggaran' => function($q) {
                    $q->where('status_verifikasi', 'diverifikasi');
                },
                'prestasi as total_prestasi' => function($q) {
                    $q->where('status_verifikasi', 'diverifikasi');
                }
            ])
            ->withSum([
                'pelanggaran as total_poin_pelanggaran' => function($q) {
                    $q->where('status_verifikasi', 'diverifikasi');
                }
            ], 'poin')
            ->withSum([
                'prestasi as total_poin_prestasi' => function($q) {
                    $q->where('status_verifikasi', 'diverifikasi');
                }
            ], 'poin');

        // Filter for guru - only their class students
        if (auth()->user()->level === 'guru' && isset($kelas)) {
            $query->where('kelas_id', $kelas->kelas_id);
            
            // Calculate class statistics for guru
            $classStats = [
                'total_siswa' => \App\Models\Siswa::where('kelas_id', $kelas->kelas_id)->count(),
                'siswa_melanggar' => \App\Models\Siswa::where('kelas_id', $kelas->kelas_id)
                    ->whereHas('pelanggaran', function($q) {
                        $q->where('status_verifikasi', 'diverifikasi');
                    })->count(),
                'total_poin_pelanggaran' => \App\Models\Pelanggaran::whereHas('siswa', function($q) use ($kelas) {
                        $q->where('kelas_id', $kelas->kelas_id);
                    })->where('status_verifikasi', 'diverifikasi')->sum('poin'),
                'total_poin_prestasi' => \App\Models\Prestasi::whereHas('siswa', function($q) use ($kelas) {
                        $q->where('kelas_id', $kelas->kelas_id);
                    })->where('status_verifikasi', 'diverifikasi')->sum('poin')
            ];
        }

        // Search filter
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('nama_siswa', 'like', '%' . $request->search . '%')
                  ->orWhere('nis', 'like', '%' . $request->search . '%');
            });
        }

        $siswa = $query->paginate(10)->appends($request->query());

        $data = compact('siswa');
        if (isset($classStats)) {
            $data['classStats'] = $classStats;
            $data['kelas'] = $kelas;
        }

        return view('kesiswaan.siswa_overview.index', $data);
    }

    public function show($id)
    {
        // If student, only allow access to own data
        if (auth()->user()->level === 'siswa') {
            $siswa = Siswa::with(['kelas.jurusan'])->where('user_id', auth()->id())->firstOrFail();
            $id = $siswa->siswa_id;
        } elseif (auth()->user()->level === 'guru') {
            // Guru can only access students from their class
            $guru = \App\Models\Guru::where('user_id', auth()->id())->first();
            if (!$guru) {
                return redirect()->to(\App\Helpers\RouteHelper::route('kesiswaan.siswa_overview.index'));
            }
            
            $kelas = \App\Models\Kelas::where('wali_kelas_id', $guru->guru_id)->first();
            $siswa = Siswa::with(['kelas.jurusan'])->findOrFail($id);
            
            if (!$kelas || $siswa->kelas_id != $kelas->kelas_id) {
                return redirect()->to(\App\Helpers\RouteHelper::route('kesiswaan.siswa_overview.index'));
            }
        } else {
            $siswa = Siswa::with(['kelas.jurusan'])->findOrFail($id);
        }
        
        $pelanggaran = Pelanggaran::with(['jenisPelanggaran.kategoriPelanggaran', 'guruPencatat', 'guruVerifikator.user'])
            ->where('siswa_id', $id)
            ->where('status_verifikasi', 'diverifikasi')
            ->orderBy('tanggal', 'desc')
            ->get();

        $prestasi = Prestasi::with(['jenisPrestasi.kategoriPrestasi', 'guruPencatat', 'guruVerifikator.user'])
            ->where('siswa_id', $id)
            ->where('status_verifikasi', 'diverifikasi')
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('kesiswaan.siswa_overview.show', compact('siswa', 'pelanggaran', 'prestasi'));
    }
}