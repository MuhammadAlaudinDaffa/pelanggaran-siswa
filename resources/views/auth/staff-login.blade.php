@extends('auth.auth-layout.main')
@section('title', 'Login Staff Sekolah')
@section('form')
    <p class="text-center mb-4">Login Staff Sekolah</p>
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif
    <form action="{{ route('auth.staff.login') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-4">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="form-check">
                <input class="form-check-input primary" type="checkbox" name="remember" id="remember">
                <label class="form-check-label text-dark" for="remember">
                    Remember this Device
                </label>
            </div>
        </div>
        <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Sign In</button>
        <div class="text-center">
            <a href="{{ route('role.selection') }}" class="text-muted">← Kembali ke Pilihan Role</a>
        </div>
    </form>
@endsection