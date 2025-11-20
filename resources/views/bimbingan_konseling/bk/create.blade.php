@extends('layout.main')
@section('title', 'Buat Keluhan Bimbingan Konseling')
@section('content')
    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-semibold mb-4">Buat Keluhan Bimbingan Konseling</h5>
                    
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>{{ session('error') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ \App\Helpers\RouteHelper::route('bimbingan_konseling.bk.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="jenis_layanan" class="form-label">Jenis Layanan <span class="text-danger">*</span></label>
                                    <select class="form-select" id="jenis_layanan" name="jenis_layanan" required>
                                        <option value="">Pilih Jenis Layanan</option>
                                        <option value="pribadi" {{ old('jenis_layanan') == 'pribadi' ? 'selected' : '' }}>Pribadi</option>
                                        <option value="sosial" {{ old('jenis_layanan') == 'sosial' ? 'selected' : '' }}>Sosial</option>
                                        <option value="belajar" {{ old('jenis_layanan') == 'belajar' ? 'selected' : '' }}>Belajar</option>
                                        <option value="karir" {{ old('jenis_layanan') == 'karir' ? 'selected' : '' }}>Karir</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="topik" class="form-label">Topik <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="topik" name="topik" 
                                           value="{{ old('topik') }}" required placeholder="Masukkan topik keluhan">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="keluhan_masalah" class="form-label">Keluhan/Masalah <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="keluhan_masalah" name="keluhan_masalah" 
                                      rows="6" required placeholder="Jelaskan keluhan atau masalah Anda secara detail">{{ old('keluhan_masalah') }}</textarea>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-device-floppy me-2"></i>Simpan
                            </button>
                            <a href="{{ \App\Helpers\RouteHelper::route('bimbingan_konseling.bk.index') }}" class="btn btn-secondary">
                                <i class="ti ti-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection