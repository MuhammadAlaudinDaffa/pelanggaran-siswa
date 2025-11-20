@extends('layout.main')
@section('title', 'Detail Prestasi')
@section('content')
        <div class="row">
            <div class="col-12 d-flex align-items-stretch">
                <div class="card w-100">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-semibold mb-4">Detail Prestasi</h5>
                        <!-- Bukti Dokumen -->
                        @if($prestasi->bukti_dokumen)
                        <div class="text-center mb-4">
                            @php
                                $extension = pathinfo($prestasi->bukti_dokumen, PATHINFO_EXTENSION);
                                $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']);
                            @endphp
                            
                            @if($isImage)
                                <img src="{{ asset('storage/' . $prestasi->bukti_dokumen) }}" alt="Bukti Dokumen" 
                                     class="img-thumbnail" style="width: 300px; height: 200px; object-fit: cover; border-radius: 12px;">
                            @else
                                <div class="text-center p-4 border rounded" style="width: 300px; margin: 0 auto;">
                                    <i class="ti ti-file-text fs-1 text-muted"></i>
                                    <p class="mt-2 mb-0">{{ strtoupper($extension) }} File</p>
                                </div>
                            @endif
                            <div class="mt-2">
                                <a href="{{ asset('storage/' . $prestasi->bukti_dokumen) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                    <i class="ti ti-download fs-4"></i> Unduh Bukti Dokumen
                                </a>
                            </div>
                        </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="fw-semibold">ID:</td>
                                        <td>{{ $prestasi->prestasi_id }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">Siswa:</td>
                                        <td>
                                            @if(in_array(Auth::user()->level, ['admin', 'kesiswaan', 'kepala_sekolah']))
                                                {{ $prestasi->siswa->nama_siswa }} ({{ $prestasi->siswa->nis }})
                                            @else
                                                {{ $prestasi->siswa->nama_siswa }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">Kelas:</td>
                                        <td>
                                            <span class="badge bg-primary">{{ $prestasi->siswa->kelas->nama_kelas }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">Jenis Prestasi:</td>
                                        <td>{{ $prestasi->jenisPrestasi->nama_prestasi }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">Kategori:</td>
                                        <td>{{ $prestasi->jenisPrestasi->kategoriPrestasi->nama_kategori ?? 'Tidak ada kategori' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">Tingkat:</td>
                                        <td>
                                            @if($prestasi->tingkat)
                                                <span class="badge bg-info rounded-3 fw-semibold">{{ ucfirst($prestasi->tingkat) }}</span>
                                            @else
                                                <span class="text-muted">Tidak ditentukan</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">Poin:</td>
                                        <td>
                                            <span class="badge bg-success rounded-3 fw-semibold">+{{ $prestasi->poin }}</span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="fw-semibold">Tanggal:</td>
                                        <td>{{ \Carbon\Carbon::parse($prestasi->tanggal)->format('d F Y') }}</td>
                                    </tr>
                                    @if(in_array(Auth::user()->level, ['admin', 'kesiswaan', 'kepala_sekolah']))
                                    <tr>
                                        <td class="fw-semibold">Guru Pencatat:</td>
                                        <td>{{ $prestasi->guruPencatat->nama_guru ?? 'Tidak diketahui'}}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td class="fw-semibold">Status:</td>
                                        <td>
                                            @if($prestasi->status_verifikasi === 'menunggu')
                                                <span class="badge bg-warning rounded-3 fw-semibold">Menunggu</span>
                                            @elseif($prestasi->status_verifikasi === 'diverifikasi')
                                                <span class="badge bg-success rounded-3 fw-semibold">Diverifikasi</span>
                                            @elseif($prestasi->status_verifikasi === 'ditolak')
                                                <span class="badge bg-danger rounded-3 fw-semibold">Ditolak</span>
                                            @else
                                                <span class="badge bg-info rounded-3 fw-semibold">Revisi</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @if($prestasi->guruVerifikator || $prestasi->verifikator_tim)
                                    <tr>
                                        <td class="fw-semibold">Verifikator:</td>
                                        <td>
                                            @if($prestasi->guruVerifikator)
                                                {{ $prestasi->guruVerifikator->nama_guru }}
                                                @if($prestasi->guruVerifikator->user)
                                                    <span class="badge bg-secondary ms-1">{{ ucfirst($prestasi->guruVerifikator->user->level) }}</span>
                                                @endif
                                            @else
                                                {{ $prestasi->verifikator_tim }}
                                            @endif
                                        </td>
                                    </tr>
                                    @elseif($prestasi->status_verifikasi !== 'menunggu')
                                        <tr>
                                            <td class="fw-semibold">Verifikator:</td>
                                            <td>Tidak diketahui</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td class="fw-semibold">Tahun Ajaran:</td>
                                        <td>{{ $prestasi->tahunAjaran->tahun_ajaran ?? 'Tidak ada' }}</td>
                                    </tr>
                                    @if($prestasi->penghargaan)
                                    <tr>
                                        <td class="fw-semibold">Penghargaan:</td>
                                        <td>{{ $prestasi->penghargaan }}</td>
                                    </tr>
                                    @endif
                                </table>
                            </div>
                        </div>

                        @if($prestasi->keterangan)
                        <div class="row mt-3">
                            <div class="col-12">
                                <h6 class="fw-semibold">Keterangan:</h6>
                                <p class="text-muted">{{ $prestasi->keterangan }}</p>
                            </div>
                        </div>
                        @endif

                        @if($prestasi->catatan_verifikasi)
                        <div class="row mt-3">
                            <div class="col-12">
                                <h6 class="fw-semibold">Catatan Verifikasi:</h6>
                                <p class="text-muted">{{ $prestasi->catatan_verifikasi }}</p>
                            </div>
                        </div>
                        @endif
                    
                    <div class="mt-4">
                        <!-- Verification Actions -->
                        @if(in_array(Auth::user()->level, ['admin', 'kesiswaan', 'kepala_sekolah']) && $prestasi->status_verifikasi === 'menunggu')
                            <div class="border rounded p-3 mb-3 bg-light">
                                <h6 class="fw-semibold mb-3"><i class="ti ti-shield-check me-2"></i>Aksi Verifikasi</h6>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-success" onclick="verifikasi({{ $prestasi->prestasi_id }}, 'diverifikasi')">
                                        <i class="ti ti-check"></i> Verifikasi
                                    </button>
                                    <button class="btn btn-warning" onclick="verifikasi({{ $prestasi->prestasi_id }}, 'revisi')">
                                        <i class="ti ti-edit"></i> Revisi
                                    </button>
                                    <button class="btn btn-danger" onclick="verifikasi({{ $prestasi->prestasi_id }}, 'ditolak')">
                                        <i class="ti ti-x"></i> Tolak
                                    </button>
                                </div>
                            </div>
                        @endif
                        
                        <!-- Navigation Actions -->
                        <div class="d-flex gap-2">
                            @php
                                $currentGuru = \App\Models\Guru::where('user_id', Auth::id())->first();
                                $canEdit = in_array($prestasi->status_verifikasi, ['menunggu', 'revisi']) && 
                                          ($currentGuru && $currentGuru->guru_id == $prestasi->guru_pencatat || 
                                           in_array(Auth::user()->level, ['admin', 'kesiswaan']));
                            @endphp
                            @if($canEdit)
                                <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.prestasi.edit', $prestasi->prestasi_id) }}" class="btn btn-warning">
                                    <i class="ti ti-pencil"></i> Edit
                                </a>
                            @endif
                            @if(Auth::user()->level === 'siswa')
                                <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.siswa_overview.show', Auth::id()) }}" class="btn btn-secondary">
                                    <i class="ti ti-arrow-left"></i> Kembali ke Data Siswa
                                </a>
                            @elseif(Auth::user()->level === 'orang_tua')
                                @if(request('from') === 'siswa_overview' && request('siswa_id'))
                                    <a href="{{ route('orang_tua.kesiswaan.siswa_overview.show', Auth::id()) }}" class="btn btn-secondary">
                                        <i class="ti ti-arrow-left"></i> Kembali ke Overview Siswa
                                    </a>
                                @else
                                    <a href="{{ route('orang_tua.kesiswaan.prestasi.index') }}" class="btn btn-secondary">
                                        <i class="ti ti-arrow-left"></i> Kembali ke Data Prestasi
                                    </a>
                                @endif
                            @elseif(request('from') === 'siswa_overview' && request('siswa_id'))
                                <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.siswa_overview.show', request('siswa_id')) }}" class="btn btn-secondary">
                                    <i class="ti ti-arrow-left"></i> Kembali ke Overview Siswa
                                </a>
                            @else
                                <a href="{{ \App\Helpers\RouteHelper::route('kesiswaan.prestasi.index') }}" class="btn btn-secondary">
                                    <i class="ti ti-arrow-left"></i> Kembali
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <!-- Modal Verifikasi -->
    <div class="modal fade" id="verifikasiModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verifikasiTitle">Verifikasi Prestasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="verifikasiForm">
                    <div class="modal-body">
                        <input type="hidden" id="prestasiId">
                        <input type="hidden" id="statusVerifikasi">
                        
                        <div class="mb-3">
                            <label class="form-label">Catatan Verifikasi</label>
                            <textarea class="form-control" id="catatanVerifikasi" rows="3" placeholder="Masukkan catatan verifikasi (opsional)"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="submitVerifikasi">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    function verifikasi(id, status) {
        document.getElementById('prestasiId').value = id;
        document.getElementById('statusVerifikasi').value = status;
        
        let title, btnClass;
        if (status === 'diverifikasi') {
            title = 'Verifikasi Prestasi';
            btnClass = 'btn btn-success';
        } else if (status === 'revisi') {
            title = 'Minta Revisi Prestasi';
            btnClass = 'btn btn-warning';
        } else {
            title = 'Tolak Prestasi';
            btnClass = 'btn btn-danger';
        }
        
        document.getElementById('verifikasiTitle').textContent = title;
        document.getElementById('submitVerifikasi').className = btnClass;
        
        const modal = new bootstrap.Modal(document.getElementById('verifikasiModal'));
        modal.show();
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('verifikasiForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const id = document.getElementById('prestasiId').value;
            const status = document.getElementById('statusVerifikasi').value;
            const catatan = document.getElementById('catatanVerifikasi').value;
            
            @if(in_array(Auth::user()->level, ['admin', 'kesiswaan']))
                const url = `{{ \App\Helpers\RouteHelper::route('kesiswaan.prestasi.verifikasi', ':id') }}`.replace(':id', id);
            @else
                console.error('Unauthorized access attempt');
                alert('Anda tidak memiliki akses untuk melakukan verifikasi');
                return;
            @endif
            const data = {
                _token: '{{ csrf_token() }}',
                status_verifikasi: status,
                catatan_verifikasi: catatan
            };
            
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                const modal = bootstrap.Modal.getInstance(document.getElementById('verifikasiModal'));
                modal.hide();
                location.reload();
            })
            .catch(error => {
                console.log('Error:', error);
                alert('Terjadi kesalahan saat memverifikasi data');
            });
        });
    });
    </script>
@endsection