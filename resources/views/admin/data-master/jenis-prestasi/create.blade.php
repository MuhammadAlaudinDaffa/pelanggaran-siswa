@extends('layout.main')
@section('title', 'Tambah Prestasi')
@section('content')
    <div class="row">
        <div class="col-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-semibold mb-4">Tambah Jenis Prestasi</h5>
                    <form action="{{ route('admin.data-master.jenis-prestasi.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="namaInput" class="form-label">Nama Jenis Prestasi</label>
                            <input type="text" class="form-control @error('nama_prestasi') is-invalid @enderror" 
                                   name="nama_prestasi" id="namaInput" value="{{ old('nama_prestasi') }}" required>
                            @error('nama_prestasi')
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
                            <select class="form-select @error('kategori_prestasi_id') is-invalid @enderror" 
                                    name="kategori_prestasi_id" id="kategoriInput" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($kategoriPrestasi as $kategori)
                                    <option value="{{ $kategori->kategori_prestasi_id }}" {{ old('kategori_prestasi_id') == $kategori->kategori_prestasi_id ? 'selected' : '' }}>
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_prestasi_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="rewardInput" class="form-label">Reward</label>
                            <input type="text" class="form-control @error('reward') is-invalid @enderror" 
                                   name="reward" id="rewardInput" value="{{ old('reward') }}">
                            @error('reward')
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
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-device-floppy"></i>
                                Simpan
                            </button>
                            <a href="{{ route('admin.data-master.jenis-prestasi.index') }}" class="btn btn-outline-secondary">
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