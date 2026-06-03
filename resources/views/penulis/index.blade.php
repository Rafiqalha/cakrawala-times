@extends('layouts.app')

@section('title', 'Manajemen Penulis')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Manajemen Penulis</h4>
        <a href="{{ route('penulis.create') }}" class="btn btn-primary">+ Tambah Penulis</a>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-custom table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Nama Lengkap</th>
                        <th>Username</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($penulis as $index => $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <img src="{{ asset('storage/foto/' . ($p->foto ?? 'default.png')) }}"
                                     alt="Foto" width="40" height="40" class="rounded-circle">
                            </td>
                            <td>{{ $p->nama_lengkap }}</td>
                            <td>{{ $p->user_name }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <a href="{{ route('penulis.edit', $p->id) }}" class="btn-action edit" title="Edit">
                                        <span class="material-icons-outlined" style="font-size: 20px;">edit</span>
                                    </a>
                                    <form action="{{ route('penulis.destroy', $p->id) }}" method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus penulis ini?')"
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
                            <td colspan="5" class="text-center">Belum ada penulis.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
