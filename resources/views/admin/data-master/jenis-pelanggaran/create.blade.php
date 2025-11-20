@extends('layout.main')
@section('title', 'Tambah Pelanggaran')
@section('content')
    <div class="row">
        <div class="col-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-semibold mb-4">Tambah Pelanggaran</h5>
                    <form action="{{ route('admin.data-master.jenis-pelanggaran.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="namaInput" class="form-label">Nama Pelanggaran</label>
                            <input type="text" class="form-control @error('nama_pelanggaran') is-invalid @enderror" 
                                   name="nama_pelanggaran" id="namaInput" value="{{ old('nama_pelanggaran') }}" required>
                            @error('nama_pelanggaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="poinInput" class="form-label">Poin</label>
                            <input type="number" class="form-control @error('poin') is-invalid @enderror" 
                                   name="poin" id="poinInput" value="{{ old('poin') }}" required>
                            @error('poin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="kategoriInput" class="form-label">Kategori</label>
                            <select class="form-select @error('kategori_pelanggaran_id') is-invalid @enderror" 
                                    name="kategori_pelanggaran_id" id="kategoriInput" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($kategoriPelanggaran as $kategori)
                                    <option value="{{ $kategori->kategori_pelanggaran_id }}" {{ old('kategori_pelanggaran_id') == $kategori->kategori_pelanggaran_id ? 'selected' : '' }}>
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_pelanggaran_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="deskripsiInput" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                      name="deskripsi" id="deskripsiInput" rows="3">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="sanksiRekomendasiInput" class="form-label">Sanksi Rekomendasi</label>
                            <input type="text" class="form-control @error('sanksi_rekomendasi') is-invalid @enderror" 
                                   name="sanksi_rekomendasi" id="sanksiRekomendasiInput" value="{{ old('sanksi_rekomendasi') }}">
                            @error('sanksi_rekomendasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-device-floppy"></i>
                                Simpan
                            </button>
                            <a href="{{ route('admin.data-master.jenis-pelanggaran.index') }}" class="btn btn-outline-secondary">
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