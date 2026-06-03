@extends('layouts.app')

@section('title', 'Manajemen Kategori')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Manajemen Kategori</h4>
        <a href="{{ route('kategori.create') }}" class="btn btn-primary">+ Tambah Kategori</a>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-custom table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategori as $index => $kat)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $kat->nama_kategori }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <a href="{{ route('kategori.edit', $kat->id) }}" class="btn-action edit" title="Edit">
                                        <span class="material-icons-outlined" style="font-size: 20px;">edit</span>
                                    </a>
                                    <form action="{{ route('kategori.destroy', $kat->id) }}" method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus kategori ini?')"
                                          class="m-0 p-0 ms-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action delete" title="Hapus">
                                            <span class="material-icons-outlined" style="font-size: 20px;">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Belum ada kategori.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
