@extends('layouts.app')

@section('title', 'Tambah Penulis')

@section('content')
    <h4 class="mb-3">Tambah Penulis</h4>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('penulis.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror"
                           id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}"
                           placeholder="Masukkan nama lengkap">
                    @error('nama_lengkap')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="user_name" class="form-label">Username</label>
                    <input type="text" class="form-control @error('user_name') is-invalid @enderror"
                           id="user_name" name="user_name" value="{{ old('user_name') }}"
                           placeholder="Masukkan username">
                    @error('user_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                           id="password" name="password" placeholder="Masukkan password (min 6 karakter)">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="foto" class="form-label">Foto Profil</label>
                    <input type="file" class="form-control @error('foto') is-invalid @enderror"
                           id="foto" name="foto">
                    @error('foto')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('penulis.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection
