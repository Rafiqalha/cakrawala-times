@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')
    <h4 class="mb-3">Edit Kategori</h4>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('kategori.update', $kategori->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="nama_kategori" class="form-label">Nama Kategori</label>
                    <input type="text" class="form-control @error('nama_kategori') is-invalid @enderror"
                           id="nama_kategori" name="nama_kategori"
                           value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                           placeholder="Masukkan nama kategori">
                    @error('nama_kategori')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection
