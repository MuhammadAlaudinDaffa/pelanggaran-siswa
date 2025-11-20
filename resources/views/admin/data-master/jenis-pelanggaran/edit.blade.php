@extends('layout.main')
@section('title', 'Edit Pelanggaran')
@section('content')
    <div class="row">
        <div class="col-12 d-flex align-items-strecth">
            <div class="card w-100">
                <div class="card-body p-4">
                    <div class="d-flex mb-4">
                        <h5 class="card-title fw-semibold mb-0">Edit Jenis Pelanggaran</h5>
                    </div>
                    <form action="{{ route('admin.data-master.jenis-pelanggaran.update', $pelanggaran->jenis_pelanggaran_id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="nama_pelanggaran" class="form-label">Nama Jenis Pelanggaran</label>
                            <input type="text" class="form-control @error('nama_pelanggaran') is-invalid @enderror" id="nama_pelanggaran" name="nama_pelanggaran" value="{{ old('nama_pelanggaran', $pelanggaran->nama_pelanggaran) }}" required>
                            @error('nama_pelanggaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="poin" class="form-label">Poin</label>
                            <input type="number" class="form-control @error('poin') is-invalid @enderror" id="poin" name="poin" value="{{ old('poin', $pelanggaran->poin) }}" required>
                            @error('poin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori</label>
                            <select class="form-select @error('kategori_pelanggaran_id') is-invalid @enderror" 
                                    name="kategori_pelanggaran_id" id="kategori" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($kategoriPelanggaran as $kategori)
                                    <option value="{{ $kategori->kategori_pelanggaran_id }}" {{ $pelanggaran->kategori_pelanggaran_id == $kategori->kategori_pelanggaran_id ? 'selected' : '' }}>
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_pelanggaran_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $pelanggaran->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="sanksi_rekomendasi" class="form-label">Sanksi Rekomendasi</label>
                            <input type="text" class="form-control @error('sanksi_rekomendasi') is-invalid @enderror" id="sanksi_rekomendasi" name="sanksi_rekomendasi" value="{{ old('sanksi_rekomendasi', $pelanggaran->sanksi_rekomendasi) }}">
                            @error('sanksi_rekomendasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-device-floppy"></i>
                                Update
                            </button>
                            <a href="{{ route('admin.data-master.jenis-pelanggaran.show', $pelanggaran->jenis_pelanggaran_id) }}" class="btn btn-outline-secondary">
                                <i class="ti ti-arrow-left"></i>
                                Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection