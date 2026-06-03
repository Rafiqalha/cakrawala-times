@extends('layouts.app')

@section('title', 'Manajemen Artikel')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Manajemen Artikel</h4>
        <a href="{{ route('artikel.create') }}" class="btn btn-primary">+ Tambah Artikel</a>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-custom table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Kategori</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($artikel as $index => $a)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if($a->gambar)
                                    <img src="{{ asset('storage/gambar/' . $a->gambar) }}"
                                         alt="{{ $a->judul }}" width="60" height="40" style="object-fit:cover; border-radius: 6px;">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $a->judul }}</td>
                            <td>{{ $a->penulis->nama_lengkap ?? '-' }}</td>
                            <td>{{ $a->kategori->nama_kategori ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($a->tanggal)->isoFormat('D MMM YYYY') }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <a href="{{ route('artikel.edit', $a->id) }}" class="btn-action edit" title="Edit">
                                        <span class="material-icons-outlined" style="font-size: 20px;">edit</span>
                                    </a>
                                    <form action="{{ route('artikel.destroy', $a->id) }}" method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus artikel ini?')"
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
                            <td colspan="7" class="text-center">Belum ada artikel.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
