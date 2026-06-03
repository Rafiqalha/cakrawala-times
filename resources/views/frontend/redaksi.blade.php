@extends('frontend.layout')

@section('title', 'Susunan Redaksi - Cakrawala Times')

@section('content')
<div class="container py-5">
    <div class="mb-5 text-center">
        <h1 class="fw-bold" style="color: var(--text-main); letter-spacing: -0.5px;">Susunan Redaksi</h1>
        <p class="text-muted fs-5 mt-2" style="max-width: 600px; margin: 0 auto;">
            Mengenal lebih dekat para jurnalis independen di balik layar Cakrawala Times.
        </p>
    </div>

    <div class="row g-4 justify-content-center">
        @forelse($penulis as $p)
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card border-0 text-center p-4" style="border-radius: 16px; background-color: var(--bg-surface); box-shadow: var(--card-shadow); transition: transform 0.2s; height: 100%;">
                    @php
                        $foto = $p->foto ? $p->foto : 'default.png';
                    @endphp
                    <img src="{{ asset('storage/foto/' . $foto) }}" alt="{{ $p->nama_lengkap }}" class="rounded-circle mx-auto mb-3" style="width: 100px; height: 100px; object-fit: cover; border: 3px solid var(--border-color);">
                    <h5 class="fw-bold mb-1" style="color: var(--text-main);">
                        <a href="{{ route('penulis.show', $p->user_name) }}" class="text-decoration-none text-reset stretched-link">
                            {{ $p->nama_lengkap }}
                        </a>
                    </h5>
                    <p class="text-muted small mb-0">Jurnalis Independen</p>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p class="text-muted">Belum ada penulis yang terdaftar.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
