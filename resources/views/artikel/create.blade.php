@extends('layouts.app')

@section('title', 'Tambah Artikel')

@section('content')
    <h4 class="mb-3">Tambah Artikel</h4>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('artikel.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="judul" class="form-label">Judul Artikel</label>
                    <input type="text" class="form-control @error('judul') is-invalid @enderror"
                           id="judul" name="judul" value="{{ old('judul') }}"
                           placeholder="Masukkan judul artikel">
                    @error('judul')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="id_kategori" class="form-label">Kategori</label>
                    <select name="id_kategori" id="id_kategori"
                            class="form-select @error('id_kategori') is-invalid @enderror">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategori as $kat)
                            <option value="{{ $kat->id }}" {{ old('id_kategori') == $kat->id ? 'selected' : '' }}>
                                {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_kategori')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="isi_artikel" class="form-label">Isi Artikel</label>
                    <textarea class="form-control @error('isi_artikel') is-invalid @enderror"
                              id="isi_artikel" name="isi_artikel" rows="8"
                              placeholder="Tulis isi artikel...">{{ old('isi_artikel') }}</textarea>
                    @error('isi_artikel')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="gambar" class="form-label">Gambar Thumbnail</label>
                    <input type="file" class="form-control @error('gambar') is-invalid @enderror"
                           id="gambar" name="gambar">
                    @error('gambar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('artikel.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<!-- CKEditor 5 Classic -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#isi_artikel'), {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|', 'undo', 'redo']
        })
        .catch(error => {
            console.error(error);
        });
</script>
<style>
    .ck-editor__editable {
        min-height: 300px; /* Membuat editor lebih lega */
    }
</style>
@endpush
