<?php

namespace App\Http\Controllers\Kesiswaan;

use App\Http\Controllers\Controller;
use App\Models\Pelanggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KesiswaanPelanggaran extends Controller
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
                return view('kesiswaan.pelanggaran.index', ['noGuruData' => true]);
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
        
        $query = Pelanggaran::with([
            'siswa.kelas.jurusan',
            'guruPencatat',
            'guruVerifikator.user',
            'jenisPelanggaran.kategoriPelanggaran',
            'tahunAjaran'
        ]);

        // Filter logic based on user level and guru status
        if ($user->level === 'kepala_sekolah') {
            // Kepala sekolah can only see verified pelanggaran
            $query->where('status_verifikasi', 'diverifikasi');
            
            // If kepala sekolah has my_reports filter and is a guru, show only their reports
            if ($request->has('my_reports') && $request->my_reports) {
                $guru = \App\Models\Guru::where('user_id', $user->user_id)->first();
                if ($guru) {
                    $query->where('guru_pencatat', $guru->guru_id);
                } else {
                    $query->where('guru_pencatat', 0); // No results if not a guru
                }
            }
        } elseif (in_array($user->level, ['admin', 'kesiswaan'])) {
            // Admin and kesiswaan can see all data or filter to their own reports
            if ($request->has('my_reports') && $request->my_reports) {
                $guru = \App\Models\Guru::where('user_id', $user->user_id)->first();
                if ($guru) {
                    $query->where('guru_pencatat', $guru->guru_id);
                } else {
                    $query->where('guru_pencatat', 0); // No results if not a guru
                }
            }
            // Otherwise show all data (no additional filter)
        } else {
            // Other users can only see their own reports if they are guru
            $guru = \App\Models\Guru::where('user_id', $user->user_id)->first();
            if ($guru) {
                $query->where('guru_pencatat', $guru->guru_id);
            } else {
                $query->where('guru_pencatat', 0); // No results if not a guru
            }
        }

        // Search filter
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->whereHas('siswa', function($siswaQuery) use ($request) {
                    $siswaQuery->where('nama_siswa', 'like', '%' . $request->search . '%')
                               ->orWhere('nis', 'like', '%' . $request->search . '%');
                })
                ->orWhereHas('jenisPelanggaran', function($jenisQuery) use ($request) {
                    $jenisQuery->where('nama_pelanggaran', 'like', '%' . $request->search . '%');
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
        $pelanggaran = $query->paginate($perPage)->appends($request->query());

        return view('kesiswaan.pelanggaran.index', compact('pelanggaran'));
    }

    public function verifikasi(Request $request, Pelanggaran $pelanggaran)
    {
        $user = Auth::user();
        
        if (!in_array($user->level, ['admin', 'kesiswaan'])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'status_verifikasi' => 'required|in:diverifikasi,tolak,revisi',
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
        
        $pelanggaran->update($updateData);

        return response()->json(['success' => true]);
    }

    public function show(Pelanggaran $pelanggaran)
    {
        // Student access control - only own data
        if (Auth::user()->level === 'siswa') {
            $siswa = \App\Models\Siswa::where('user_id', Auth::id())->first();
            if (!$siswa || $pelanggaran->siswa_id != $siswa->siswa_id) {
                return redirect()->to(\App\Helpers\RouteHelper::route('kesiswaan.siswa_overview.show', Auth::id()));
            }
        } elseif (Auth::user()->level === 'guru') {
            // Guru can only access pelanggaran from their class students
            $guru = \App\Models\Guru::where('user_id', Auth::id())->first();
            if (!$guru) {
                return redirect()->to(\App\Helpers\RouteHelper::route('kesiswaan.pelanggaran.index'));
            }
            
            $kelas = \App\Models\Kelas::where('wali_kelas', $guru->guru_id)->first();
            if (!$kelas || $pelanggaran->siswa->kelas_id != $kelas->kelas_id) {
                return redirect()->to(\App\Helpers\RouteHelper::route('kesiswaan.pelanggaran.index'));
            }
        }
        
        $pelanggaran->load([
            'siswa.kelas.jurusan',
            'guruPencatat',
            'guruVerifikator',
            'jenisPelanggaran.kategoriPelanggaran',
            'tahunAjaran'
        ]);

        return view('kesiswaan.pelanggaran.show', compact('pelanggaran'));
    }

    public function create()
    {
        $kelas = \App\Models\Kelas::with('jurusan')->get();
        $kategoriPelanggaran = \App\Models\KategoriPelanggaran::all();
        $tahunAjaran = \App\Models\TahunAjaran::where('status_aktif', 1)
                                              ->orderBy('tanggal_mulai', 'asc')
                                              ->first();
        
        return view('kesiswaan.pelanggaran.create', compact('kelas', 'kategoriPelanggaran', 'tahunAjaran'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,siswa_id',
            'jenis_pelanggaran_id' => 'required|exists:jenis_pelanggaran,jenis_pelanggaran_id',
            'keterangan' => 'nullable|string',
            'bukti_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $guru = \App\Models\Guru::where('user_id', Auth::id())->first();
        if (!$guru) {
            return redirect()->back()->withErrors(['error' => 'Hanya guru yang dapat membuat pelanggaran'])->withInput();
        }
        
        $tahunAjaran = \App\Models\TahunAjaran::where('status_aktif', 1)
                                              ->orderBy('tanggal_mulai', 'asc')
                                              ->first();
        
        if (!$tahunAjaran) {
            return redirect()->back()->withErrors(['error' => 'Tidak ada tahun ajaran aktif'])->withInput();
        }
        
        $jenisPelanggaran = \App\Models\JenisPelanggaran::find($request->jenis_pelanggaran_id);
        
        $data = [
            'siswa_id' => $request->siswa_id,
            'jenis_pelanggaran_id' => $request->jenis_pelanggaran_id,
            'keterangan' => $request->keterangan,
            'tanggal' => date('Y-m-d'),
            'guru_pencatat' => $guru->guru_id,
            'tahun_ajaran_id' => $tahunAjaran->tahun_ajaran_id,
            'poin' => $jenisPelanggaran->poin,
            'status_verifikasi' => 'menunggu'
        ];

        if ($request->hasFile('bukti_foto')) {
            $data['bukti_foto'] = $request->file('bukti_foto')->store('pelanggaran', 'public');
        }

        try {
            Pelanggaran::create($data);
            return redirect()->to(\App\Helpers\RouteHelper::route('kesiswaan.pelanggaran.index'))->with('success', 'Pelanggaran berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal menyimpan data: ' . $e->getMessage()])->withInput();
        }
    }

    public function edit(Pelanggaran $pelanggaran)
    {
        if (!in_array($pelanggaran->status_verifikasi, ['menunggu', 'revisi'])) {
            return redirect()->to(\App\Helpers\RouteHelper::route('kesiswaan.pelanggaran.index'))->with('error', 'Pelanggaran yang sudah diverifikasi atau ditolak tidak dapat diedit');
        }
        
        // Check if current user is the creator (unless admin/kesiswaan)
        if (!in_array(Auth::user()->level, ['admin', 'kesiswaan'])) {
            $currentGuru = \App\Models\Guru::where('user_id', Auth::id())->first();
            if (!$currentGuru || $currentGuru->guru_id != $pelanggaran->guru_pencatat) {
                return redirect()->to(\App\Helpers\RouteHelper::route('kesiswaan.pelanggaran.index'))->with('error', 'Anda hanya dapat mengedit pelanggaran yang Anda buat sendiri');
            }
        }

        $kelas = \App\Models\Kelas::with('jurusan')->get();
        $kategoriPelanggaran = \App\Models\KategoriPelanggaran::all();
        
        return view('kesiswaan.pelanggaran.edit', compact('pelanggaran', 'kelas', 'kategoriPelanggaran'));
    }

    public function update(Request $request, Pelanggaran $pelanggaran)
    {
        if (!in_array($pelanggaran->status_verifikasi, ['menunggu', 'revisi'])) {
            return redirect()->to(\App\Helpers\RouteHelper::route('kesiswaan.pelanggaran.index'))->with('error', 'Pelanggaran yang sudah diverifikasi atau ditolak tidak dapat diedit');
        }
        
        // Check if current user is the creator (unless admin/kesiswaan)
        if (!in_array(Auth::user()->level, ['admin', 'kesiswaan'])) {
            $currentGuru = \App\Models\Guru::where('user_id', Auth::id())->first();
            if (!$currentGuru || $currentGuru->guru_id != $pelanggaran->guru_pencatat) {
                return redirect()->to(\App\Helpers\RouteHelper::route('kesiswaan.pelanggaran.index'))->with('error', 'Anda hanya dapat mengedit pelanggaran yang Anda buat sendiri');
            }
        }

        $request->validate([
            'siswa_id' => 'required|exists:siswa,siswa_id',
            'jenis_pelanggaran_id' => 'required|exists:jenis_pelanggaran,jenis_pelanggaran_id',
            'keterangan' => 'nullable|string',
            'bukti_foto' => 'nullable|image|max:2048'
        ]);

        $data = $request->except(['bukti_foto']);
        
        $jenisPelanggaran = \App\Models\JenisPelanggaran::find($request->jenis_pelanggaran_id);
        $data['poin'] = $jenisPelanggaran->poin;
        
        // Reset status to menunggu if current status is revisi
        if ($pelanggaran->status_verifikasi === 'revisi') {
            $data['status_verifikasi'] = 'menunggu';
            $data['guru_verifikator'] = null;
            $data['verifikator_tim'] = null;
            $data['catatan_verifikasi'] = null;
        }

        if ($request->hasFile('bukti_foto')) {
            if ($pelanggaran->bukti_foto && Storage::disk('public')->exists($pelanggaran->bukti_foto)) {
                Storage::disk('public')->delete($pelanggaran->bukti_foto);
            }
            $data['bukti_foto'] = $request->file('bukti_foto')->store('pelanggaran', 'public');
        }

        $pelanggaran->update($data);

        return redirect()->to(\App\Helpers\RouteHelper::route('kesiswaan.pelanggaran.index'))->with('success', 'Pelanggaran berhasil diperbarui');
    }
}
