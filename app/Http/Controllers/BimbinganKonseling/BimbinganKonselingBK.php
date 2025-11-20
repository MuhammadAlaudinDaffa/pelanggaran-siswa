<?php

namespace App\Http\Controllers\BimbinganKonseling;

use App\Http\Controllers\Controller;
use App\Models\BimbinganKonseling;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BimbinganKonselingBK extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $query = BimbinganKonseling::with([
            'siswa.kelas',
            'guruKonselor',
            'tahunAjaran'
        ])->whereNull('bk_parent_id'); // Only show parent posts
        
        // Filter based on user level
        if ($user->level === 'siswa') {
            $siswa = Siswa::where('user_id', $user->user_id)->first();
            if ($siswa) {
                $query->where('siswa_id', $siswa->siswa_id);
            } else {
                $query->where('siswa_id', 0);
            }
        } elseif ($user->level === 'orang_tua') {
            $orangTua = \App\Models\Orangtua::where('user_id', $user->user_id)->first();
            if ($orangTua) {
                $query->where('siswa_id', $orangTua->siswa_id);
            } else {
                $query->where('siswa_id', 0);
            }
        } elseif (in_array($user->level, ['admin', 'bimbingan_konseling'])) {
            $guru = \App\Models\Guru::where('user_id', $user->user_id)->first();
            $query->where(function($q) use ($guru, $user) {
                // Show own cases
                if ($guru) {
                    $q->where('guru_konselor', $guru->guru_id);
                } else {
                    $q->where('konselor_user_id', $user->user_id);
                }
                // OR show unassigned cases with menunggu status
                $q->orWhere(function($subQ) {
                    $subQ->where('status', 'menunggu')
                         ->whereNull('guru_konselor')
                         ->whereNull('konselor_user_id');
                });
            });
        }
        
        // Search filter
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('topik', 'like', '%' . $request->search . '%')
                  ->orWhere('keluhan_masalah', 'like', '%' . $request->search . '%');
            });
        }
        
        // Status filter
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        $query->orderBy('created_at', 'desc');
        $bimbinganKonseling = $query->paginate(10)->appends($request->query());
        
        return view('bimbingan_konseling.bk.index', compact('bimbinganKonseling'));
    }
    
    public function create()
    {
        if (Auth::user()->level !== 'siswa') {
            return redirect()->to(\App\Helpers\RouteHelper::route('bimbingan_konseling.bk.index'))->with('error', 'Hanya siswa yang dapat membuat keluhan');
        }
        
        return view('bimbingan_konseling.bk.create');
    }
    
    public function store(Request $request)
    {
        if (Auth::user()->level !== 'siswa') {
            return redirect()->to(\App\Helpers\RouteHelper::route('bimbingan_konseling.bk.index'))->with('error', 'Hanya siswa yang dapat membuat keluhan');
        }
        
        $request->validate([
            'jenis_layanan' => 'required|in:pribadi,sosial,belajar,karir',
            'topik' => 'required|string|max:255',
            'keluhan_masalah' => 'required|string'
        ]);
        
        $siswa = Siswa::where('user_id', Auth::id())->first();
        if (!$siswa) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan ' . $siswa->siswa_id);
        }
        
        $tahunAjaran = TahunAjaran::where('status_aktif', 1)->first();
        
        BimbinganKonseling::create([
            'siswa_id' => $siswa->siswa_id,
            'tahun_ajaran_id' => $tahunAjaran ? $tahunAjaran->tahun_ajaran_id : null,
            'jenis_layanan' => $request->jenis_layanan,
            'topik' => $request->topik,
            'keluhan_masalah' => $request->keluhan_masalah,
            'status' => 'menunggu',
            'child_count' => 0,
            'child_order' => 0
        ]);
        
        return redirect()->to(\App\Helpers\RouteHelper::route('bimbingan_konseling.bk.index'))->with('success', 'Keluhan berhasil diajukan');
    }
    
    public function show($bk_id)
    {
        $bimbinganKonseling = BimbinganKonseling::with([
            'siswa.kelas',
            'guruKonselor',
            'konselorUser',
            'tahunAjaran',
            'children.siswa',
            'children.guruKonselor',
            'children.konselorUser'
        ])->findOrFail($bk_id);
        
        // Check access permissions
        if (Auth::user()->level === 'siswa') {
            $siswa = Siswa::where('user_id', Auth::id())->first();
            if (!$siswa || $bimbinganKonseling->siswa_id != $siswa->siswa_id) {
                return redirect()->to(\App\Helpers\RouteHelper::route('bimbingan_konseling.bk.index'));
            }
        } elseif (Auth::user()->level === 'orang_tua') {
            $orangTua = \App\Models\Orangtua::where('user_id', Auth::id())->first();
            if (!$orangTua || $bimbinganKonseling->siswa_id != $orangTua->siswa_id) {
                return redirect()->to(\App\Helpers\RouteHelper::route('orang_tua.bimbingan_konseling.bk.index'));
            }
        } elseif (in_array(Auth::user()->level, ['admin', 'bimbingan_konseling'])) {
            $guru = \App\Models\Guru::where('user_id', Auth::id())->first();
            $hasAccess = false;
            
            // Check if user has access to this BK case
            if ($guru && $bimbinganKonseling->guru_konselor == $guru->guru_id) {
                $hasAccess = true;
            } elseif (!$guru && $bimbinganKonseling->konselor_user_id == Auth::id()) {
                $hasAccess = true;
            } elseif ($bimbinganKonseling->status === 'menunggu' && !$bimbinganKonseling->guru_konselor && !$bimbinganKonseling->konselor_user_id) {
                $hasAccess = true; // Unassigned case
            }
            
            if (!$hasAccess) {
                return redirect()->to(\App\Helpers\RouteHelper::route('bimbingan_konseling.bk.index'));
            }
        }
        
        return view('bimbingan_konseling.bk.show', compact('bimbinganKonseling'));
    }
    
    public function edit($bk_id)
    {
        $bimbinganKonseling = BimbinganKonseling::findOrFail($bk_id);
        
        if (Auth::user()->level !== 'siswa') {
            return redirect()->to(\App\Helpers\RouteHelper::route('bimbingan_konseling.bk.index'))->with('error', 'Hanya siswa yang dapat mengedit keluhan');
        }
        
        $siswa = Siswa::where('user_id', Auth::id())->first();
        if (!$siswa || $bimbinganKonseling->siswa_id != $siswa->siswa_id) {
            return redirect()->to(\App\Helpers\RouteHelper::route('bimbingan_konseling.bk.index'))->with('error', 'Akses ditolak');
        }
        
        if ($bimbinganKonseling->status !== 'menunggu') {
            return redirect()->to(\App\Helpers\RouteHelper::route('bimbingan_konseling.bk.show', $bk_id))->with('error', 'Keluhan yang sudah diproses tidak dapat diedit');
        }
        
        return view('bimbingan_konseling.bk.edit', compact('bimbinganKonseling'));
    }
    
    public function update(Request $request, $bk_id)
    {
        $bimbinganKonseling = BimbinganKonseling::findOrFail($bk_id);
        
        if (Auth::user()->level === 'siswa') {
            $siswa = Siswa::where('user_id', Auth::id())->first();
            if (!$siswa || $bimbinganKonseling->siswa_id != $siswa->siswa_id) {
                return redirect()->to(\App\Helpers\RouteHelper::route('bimbingan_konseling.bk.index'))->with('error', 'Akses ditolak');
            }
            
            if ($bimbinganKonseling->status !== 'menunggu') {
                return redirect()->to(\App\Helpers\RouteHelper::route('bimbingan_konseling.bk.show', $bk_id))->with('error', 'Keluhan yang sudah diproses tidak dapat diedit');
            }
            
            $request->validate([
                'jenis_layanan' => 'required|in:pribadi,sosial,belajar,karir',
                'topik' => 'required|string|max:255',
                'keluhan_masalah' => 'required|string'
            ]);
            
            $bimbinganKonseling->update([
                'jenis_layanan' => $request->jenis_layanan,
                'topik' => $request->topik,
                'keluhan_masalah' => $request->keluhan_masalah
            ]);
        } elseif (in_array(Auth::user()->level, ['admin', 'bimbingan_konseling'])) {
            $request->validate([
                'tindakan_solusi' => 'required|string',
                'status' => 'required|in:berkelanjutan,tindak_lanjut,selesai,ditolak',
                'tanggal_konseling' => 'nullable|date',
                'hasil_evaluasi' => 'nullable|string'
            ]);
            
            DB::transaction(function() use ($request, $bimbinganKonseling) {
                $updateData = [
                    'tindakan_solusi' => $request->tindakan_solusi,
                    'status' => $request->status,
                    'tanggal_konseling' => $request->tanggal_konseling,
                    'hasil_evaluasi' => $request->hasil_evaluasi
                ];
                
                // Set tanggal_tindak_lanjut if status is tindak_lanjut
                if ($request->status === 'tindak_lanjut') {
                    $updateData['tanggal_tindak_lanjut'] = date('Y-m-d');
                }
                
                // Assign konselor if not assigned yet
                if (!$bimbinganKonseling->guru_konselor && !$bimbinganKonseling->konselor_user_id) {
                    $guru = \App\Models\Guru::where('user_id', Auth::id())->first();
                    if ($guru) {
                        $updateData['guru_konselor'] = $guru->guru_id;
                    } else {
                        $updateData['konselor_user_id'] = Auth::id();
                        $updateData['konselor_tim'] = Auth::user()->level === 'bimbingan_konseling' ? 'Tim BK' : 'Tim Admin';
                    }
                }
                
                $bimbinganKonseling->update($updateData);
                
                // Create follow-up child record if status is tindak_lanjut
                if ($request->status === 'tindak_lanjut') {
                    $parent = $bimbinganKonseling->bk_parent_id ? BimbinganKonseling::find($bimbinganKonseling->bk_parent_id) : $bimbinganKonseling;
                    $childOrder = $parent->child_count + 1;
                    
                    BimbinganKonseling::create([
                        'siswa_id' => $parent->siswa_id,
                        'guru_konselor' => $bimbinganKonseling->guru_konselor,
                        'konselor_user_id' => $bimbinganKonseling->konselor_user_id,
                        'konselor_tim' => $bimbinganKonseling->konselor_tim,
                        'bk_parent_id' => $parent->bk_id,
                        'child_order' => $childOrder,
                        'tahun_ajaran_id' => $parent->tahun_ajaran_id,
                        'jenis_layanan' => $parent->jenis_layanan,
                        'topik' => $parent->topik,
                        'tanggal_tindak_lanjut' => date('Y-m-d'),
                        'status' => 'tindak_lanjut'
                    ]);
                    
                    $parent->update(['child_count' => $childOrder]);
                }
                
                // Update parent thread status if this is a child
                if ($bimbinganKonseling->bk_parent_id) {
                    $parent = BimbinganKonseling::find($bimbinganKonseling->bk_parent_id);
                    if ($parent) {
                        $parent->update(['status' => $request->status]);
                    }
                }
            });
        }
        
        $parentId = $bimbinganKonseling->bk_parent_id ?? $bk_id;
        return redirect()->to(\App\Helpers\RouteHelper::route('bimbingan_konseling.bk.show', $parentId))->with('success', 'Data berhasil diperbarui');
    }
    
    public function ambil(Request $request, $bk_id)
    {
        if (!in_array(Auth::user()->level, ['admin', 'bimbingan_konseling'])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $bimbinganKonseling = BimbinganKonseling::findOrFail($bk_id);
        
        if ($bimbinganKonseling->guru_konselor || $bimbinganKonseling->konselor_user_id) {
            return response()->json(['error' => 'Kasus sudah diambil'], 400);
        }
        
        $updateData = [];
        
        $guru = \App\Models\Guru::where('user_id', Auth::id())->first();
        if ($guru) {
            $updateData['guru_konselor'] = $guru->guru_id;
        } else {
            $updateData['konselor_user_id'] = Auth::id();
            $updateData['konselor_tim'] = Auth::user()->level === 'bimbingan_konseling' ? 'Tim BK' : 'Tim Admin';
        }
        
        $bimbinganKonseling->update($updateData);
        
        return response()->json(['success' => true]);
    }
    
    public function reply(Request $request, $bk_id)
    {
        $parent = BimbinganKonseling::findOrFail($bk_id);
        
        if (Auth::user()->level !== 'siswa') {
            return redirect()->back()->with('error', 'Akses ditolak');
        }
        
        $siswa = Siswa::where('user_id', Auth::id())->first();
        if (!$siswa || $parent->siswa_id != $siswa->siswa_id) {
            return redirect()->back()->with('error', 'Akses ditolak');
        }
        
        // Check if last response allows continuation
        $lastChild = $parent->children()->orderBy('child_order', 'desc')->first();
        
        // If last child is tindak_lanjut without tindakan_solusi, student cannot reply yet
        if ($lastChild && $lastChild->status === 'tindak_lanjut' && !$lastChild->tindakan_solusi) {
            return redirect()->back()->with('error', 'Menunggu tindak lanjut dari konselor');
        }
        
        $canReply = ($lastChild && in_array($lastChild->status, ['berkelanjutan', 'tindak_lanjut']) && $lastChild->tindakan_solusi) || 
                   (!$lastChild && in_array($parent->status, ['berkelanjutan', 'tindak_lanjut']) && $parent->tindakan_solusi);
        
        if (!$canReply) {
            return redirect()->back()->with('error', 'Tidak dapat membalas saat ini');
        }
        
        $request->validate(['keluhan_masalah' => 'required|string']);
        
        DB::transaction(function() use ($request, $parent, $siswa) {
            $childOrder = $parent->child_count + 1;
            
            BimbinganKonseling::create([
                'siswa_id' => $parent->siswa_id,
                'guru_konselor' => $parent->guru_konselor,
                'konselor_user_id' => $parent->konselor_user_id,
                'konselor_tim' => $parent->konselor_tim,
                'bk_parent_id' => $parent->bk_id,
                'child_order' => $childOrder,
                'tahun_ajaran_id' => $parent->tahun_ajaran_id,
                'jenis_layanan' => $parent->jenis_layanan,
                'topik' => $parent->topik,
                'keluhan_masalah' => $request->keluhan_masalah,
                'status' => 'menunggu'
            ]);
            
            $parent->update(['child_count' => $childOrder]);
        });
        
        return redirect()->to(\App\Helpers\RouteHelper::route('bimbingan_konseling.bk.show', $bk_id))->with('success', 'Balasan berhasil dikirim');
    }
    
    public function destroy($bk_id)
    {
        $bimbinganKonseling = BimbinganKonseling::withTrashed()->findOrFail($bk_id);
        
        // If it's a parent post, soft delete all children
        if (!$bimbinganKonseling->bk_parent_id) {
            BimbinganKonseling::where('bk_parent_id', $bk_id)->delete();
        }
        
        $bimbinganKonseling->delete();
        
        return response()->json(['success' => true]);
    }
}