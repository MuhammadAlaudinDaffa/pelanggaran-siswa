<?php

namespace App\Http\Controllers\Kesiswaan;

use App\Http\Controllers\Controller;
use App\Models\Prestasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KesiswaanPrestasi extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Block student access to index
        if ($user->level === 'siswa') {
            return redirect()->to(\App\Helpers\RouteHelper::route('kesiswaan.siswa_overview.show', $user->user_id));
        }
        
        // Guru access control - only show students from their class
        if ($user->level === 'guru') {
            $guru = \App\Models\Guru::where('user_id', $user->user_id)->first();
            if (!$guru) {
                return view('kesiswaan.prestasi.index', ['noGuruData' => true]);
            }
            
            $kelas = \App\Models\Kelas::where('wali_kelas', $guru->guru_id)->first();
            if ($kelas) {
                $query->whereHas('siswa', function($q) use ($kelas) {
                    $q->where('kelas_id', $kelas->kelas_id);
                });
            } else {
                $query->where('siswa_id', 0); // No results if not wali kelas
            }
        }
        
        $query = Prestasi::with([
            'siswa.kelas.jurusan',
            'guruPencatat',
            'guruVerifikator',
            'jenisPrestasi.kategoriPrestasi',
            'tahunAjaran'
        ]);

        // Filter untuk guru berdasarkan user_id di tabel guru
        // Admin dan kesiswaan dapat melihat semua data atau filter laporan mereka sendiri
        if (!in_array($user->level, ['admin', 'kesiswaan'])) {
            $guru = \App\Models\Guru::where('user_id', $user->user_id)->first();
            if ($guru) {
                $query->where('guru_pencatat', $guru->guru_id);
            } else {
                $query->where('guru_pencatat', 0);
            }
        } elseif ($request->has('my_reports') && $request->my_reports) {
            $guru = \App\Models\Guru::where('user_id', $user->user_id)->first();
            if ($guru) {
                $query->where('guru_pencatat', $guru->guru_id);
            }
        }

        // Search filter
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->whereHas('siswa', function($siswaQuery) use ($request) {
                    $siswaQuery->where('nama_siswa', 'like', '%' . $request->search . '%')
                               ->orWhere('nis', 'like', '%' . $request->search . '%');
                })
                ->orWhereHas('jenisPrestasi', function($jenisQuery) use ($request) {
                    $jenisQuery->where('nama_prestasi', 'like', '%' . $request->search . '%');
                });
            });
        }

        // Status filter
        if ($request->has('status') && $request->status) {
            $query->where('status_verifikasi', $request->status);
        }

        // Sorting
        $sort = $request->get('sort', 'desc');
        $query->orderBy('tanggal', $sort);

        // Pagination
        $perPage = $request->get('per_page', 10);
        $prestasi = $query->paginate($perPage)->appends($request->query());

        return view('kesiswaan.prestasi.index', compact('prestasi'));
    }

    public function verifikasi(Request $request, $prestasi_id)
    {
        $prestasi = Prestasi::findOrFail($prestasi_id);
        $user = Auth::user();
        
        if (!in_array($user->level, ['admin', 'kesiswaan'])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'status_verifikasi' => 'required|in:diverifikasi,ditolak,revisi',
            'catatan_verifikasi' => 'nullable|string'
        ]);

        $guru = \App\Models\Guru::where('user_id', $user->user_id)->first();
        
        $updateData = [
            'status_verifikasi' => $request->status_verifikasi,
            'catatan_verifikasi' => $request->catatan_verifikasi
        ];
        
        if ($guru) {
            $updateData['guru_verifikator'] = $guru->guru_id;
        } else {
            $updateData['guru_verifikator'] = null;
            $updateData['verifikator_tim'] = 'Tim ' . ucfirst($user->level);
        }
        
        $prestasi->update($updateData);

        return response()->json(['success' => true]);
    }

    public function show(Prestasi $prestasi)
    {
        // Student access control - only own data
        if (Auth::user()->level === 'siswa') {
            $siswa = \App\Models\Siswa::where('user_id', Auth::id())->first();
            if (!$siswa || $prestasi->siswa_id != $siswa->siswa_id) {
                return redirect()->to(\App\Helpers\RouteHelper::route('kesiswaan.siswa_overview.show', Auth::id()));
            }
        } elseif (Auth::user()->level === 'guru') {
            // Guru can only access prestasi from their class students
            $guru = \App\Models\Guru::where('user_id', Auth::id())->first();
            if (!$guru) {
                return redirect()->to(\App\Helpers\RouteHelper::route('kesiswaan.prestasi.index'));
            }
            
            $kelas = \App\Models\Kelas::where('wali_kelas', $guru->guru_id)->first();
            if (!$kelas || $prestasi->siswa->kelas_id != $kelas->kelas_id) {
                return redirect()->to(\App\Helpers\RouteHelper::route('kesiswaan.prestasi.index'));
            }
        }
        
        $prestasi->load([
            'siswa.kelas.jurusan',
            'guruPencatat',
            'guruVerifikator',
            'jenisPrestasi.kategoriPrestasi',
            'tahunAjaran'
        ]);

        return view('kesiswaan.prestasi.show', compact('prestasi'));
    }

    public function create()
    {
        $kelas = \App\Models\Kelas::with('jurusan')->get();
        $kategoriPrestasi = \App\Models\KategoriPrestasi::all();
        $tahunAjaran = \App\Models\TahunAjaran::where('status_aktif', 1)
                                              ->orderBy('tanggal_mulai', 'asc')
                                              ->first();
        
        return view('kesiswaan.prestasi.create', compact('kelas', 'kategoriPrestasi', 'tahunAjaran'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,siswa_id',
            'jenis_prestasi_id' => 'required|exists:jenis_prestasi,jenis_prestasi_id',
            'keterangan' => 'nullable|string',
            'tingkat' => 'nullable|in:kecamatan,provinsi,nasional',
            'penghargaan' => 'nullable|string',
            'bukti_dokumen' => 'nullable|file|max:2048'
        ]);

        $guru = \App\Models\Guru::where('user_id', Auth::id())->first();
        if (!$guru) {
            return redirect()->back()->with('error', 'Hanya guru yang dapat membuat prestasi');
        }
        
        $tahunAjaran = \App\Models\TahunAjaran::where('status_aktif', 1)
                                              ->orderBy('tanggal_mulai', 'asc')
                                              ->first();
        $jenisPrestasi = \App\Models\JenisPrestasi::find($request->jenis_prestasi_id);
        
        $data = [
            'siswa_id' => $request->siswa_id,
            'jenis_prestasi_id' => $request->jenis_prestasi_id,
            'keterangan' => $request->keterangan,
            'tingkat' => $request->tingkat,
            'penghargaan' => $request->penghargaan,
            'tanggal' => date('Y-m-d'),
            'guru_pencatat' => $guru->guru_id,
            'tahun_ajaran_id' => $tahunAjaran ? $tahunAjaran->tahun_ajaran_id : null,
            'poin' => $jenisPrestasi->poin,
            'status_verifikasi' => 'menunggu'
        ];

        if ($request->hasFile('bukti_dokumen')) {
            $data['bukti_dokumen'] = $request->file('bukti_dokumen')->store('prestasi', 'public');
        }

        Prestasi::create($data);

        return redirect()->to(\App\Helpers\RouteHelper::route('kesiswaan.prestasi.index'))->with('success', 'Prestasi berhasil ditambahkan');
    }

    public function edit(Prestasi $prestasi)
    {
        if (!in_array($prestasi->status_verifikasi, ['menunggu', 'revisi'])) {
            return redirect()->to(\App\Helpers\RouteHelper::route('kesiswaan.prestasi.index'))->with('error', 'Prestasi yang sudah diverifikasi atau ditolak tidak dapat diedit');
        }
        
        // Check if current user is the creator (unless admin/kesiswaan)
        if (!in_array(Auth::user()->level, ['admin', 'kesiswaan'])) {
            $currentGuru = \App\Models\Guru::where('user_id', Auth::id())->first();
            if (!$currentGuru || $currentGuru->guru_id != $prestasi->guru_pencatat) {
                return redirect()->to(\App\Helpers\RouteHelper::route('kesiswaan.prestasi.index'))->with('error', 'Anda hanya dapat mengedit prestasi yang Anda buat sendiri');
            }
        }

        $kelas = \App\Models\Kelas::with('jurusan')->get();
        $kategoriPrestasi = \App\Models\KategoriPrestasi::all();
        
        return view('kesiswaan.prestasi.edit', compact('prestasi', 'kelas', 'kategoriPrestasi'));
    }

    public function update(Request $request, Prestasi $prestasi)
    {
        if (!in_array($prestasi->status_verifikasi, ['menunggu', 'revisi'])) {
            return redirect()->to(\App\Helpers\RouteHelper::route('kesiswaan.prestasi.index'))->with('error', 'Prestasi yang sudah diverifikasi atau ditolak tidak dapat diedit');
        }
        
        // Check if current user is the creator (unless admin/kesiswaan)
        if (!in_array(Auth::user()->level, ['admin', 'kesiswaan'])) {
            $currentGuru = \App\Models\Guru::where('user_id', Auth::id())->first();
            if (!$currentGuru || $currentGuru->guru_id != $prestasi->guru_pencatat) {
                return redirect()->to(\App\Helpers\RouteHelper::route('kesiswaan.prestasi.index'))->with('error', 'Anda hanya dapat mengedit prestasi yang Anda buat sendiri');
            }
        }

        $request->validate([
            'siswa_id' => 'required|exists:siswa,siswa_id',
            'jenis_prestasi_id' => 'required|exists:jenis_prestasi,jenis_prestasi_id',
            'keterangan' => 'nullable|string',
            'tingkat' => 'nullable|in:kecamatan,provinsi,nasional',
            'penghargaan' => 'nullable|string',
            'bukti_dokumen' => 'nullable|file|max:2048'
        ]);

        $data = $request->except(['bukti_dokumen']);
        
        $jenisPrestasi = \App\Models\JenisPrestasi::find($request->jenis_prestasi_id);
        $data['poin'] = $jenisPrestasi->poin;
        
        // Reset status to menunggu if current status is revisi
        if ($prestasi->status_verifikasi === 'revisi') {
            $data['status_verifikasi'] = 'menunggu';
            $data['guru_verifikator'] = null;
            $data['verifikator_tim'] = null;
            $data['catatan_verifikasi'] = null;
        }

        if ($request->hasFile('bukti_dokumen')) {
            if ($prestasi->bukti_dokumen && Storage::disk('public')->exists($prestasi->bukti_dokumen)) {
                Storage::disk('public')->delete($prestasi->bukti_dokumen);
            }
            $data['bukti_dokumen'] = $request->file('bukti_dokumen')->store('prestasi', 'public');
        }

        $prestasi->update($data);

        return redirect()->to(\App\Helpers\RouteHelper::route('kesiswaan.prestasi.index'))->with('success', 'Prestasi berhasil diperbarui');
    }
}
