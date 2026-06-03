@extends('layouts.app')

@section('title', 'Edit Penulis')

@section('content')
    <h4 class="mb-3">Edit Penulis</h4>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('penulis.update', $penulis->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror"
                           id="nama_lengkap" name="nama_lengkap"
                           value="{{ old('nama_lengkap', $penulis->nama_lengkap) }}"
                           placeholder="Masukkan nama lengkap">
                    @error('nama_lengkap')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="user_name" class="form-label">Username</label>
                    <input type="text" class="form-control @error('user_name') is-invalid @enderror"
                           id="user_name" name="user_name"
                           value="{{ old('user_name', $penulis->user_name) }}"
                           placeholder="Masukkan username">
                    @error('user_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password <small class="text-muted">(kosongkan jika tidak diubah)</small></label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                           id="password" name="password" placeholder="Masukkan password baru">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="foto" class="form-label">Foto Profil</label>
                    <br>
                    @if($penulis->foto && $penulis->foto !== 'default.png')
                        <img src="{{ asset('storage/foto/' . $penulis->foto) }}" width="80" class="rounded-circle mb-2" alt="Foto">
                    @endif
                    <input type="file" class="form-control @error('foto') is-invalid @enderror"
                           id="foto" name="foto">
                    @error('foto')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('penulis.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection
