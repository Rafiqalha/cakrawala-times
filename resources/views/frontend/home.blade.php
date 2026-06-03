@extends('frontend.layout')

@section('title', isset($kategoriAktif) ? 'Kategori: ' . $kategoriAktif->nama_kategori : 'Beranda - Cakrawala Times')

@push('styles')
<style>
    /* Chips Category (M3) */
    .chip-kategori {
        display: inline-block;
        padding: 6px 16px;
        margin: 4px;
        border-radius: 8px;
        background-color: var(--bg-surface);
        color: var(--text-main);
        text-decoration: none;
        font-weight: 500;
        font-size: 0.9rem;
        border: 1px solid var(--border-color);
        transition: all 0.2s;
    }
    .chip-kategori:hover {
        background-color: var(--input-bg);
    }
    .chip-kategori.active {
        background-color: #0b57d0;
        color: #ffffff;
        border-color: #0b57d0;
    }

    /* M3 Article Card */
    .artikel-card {
        border: none;
        border-radius: 16px;
        background-color: var(--bg-surface);
        box-shadow: var(--card-shadow);
        transition: box-shadow 0.3s ease, transform 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }
    .artikel-card:hover {
        box-shadow: var(--card-shadow-hover);
        transform: translateY(-2px);
    }
    .artikel-img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .artikel-card:hover .artikel-img {
        transform: scale(1.08);
    }
    .artikel-body {
        padding: 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .artikel-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-main);
        margin-bottom: 8px;
        line-height: 1.4;
        text-decoration: none;
        letter-spacing: -0.2px;
    }
    .artikel-title:hover {
        color: #1a73e8;
    }
    .artikel-excerpt {
        color: var(--text-muted);
        font-size: 0.95rem;
        line-height: 1.5;
        margin-bottom: 16px;
        flex: 1;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;  
        overflow: hidden;
    }
    .artikel-meta {
        display: flex;
        align-items: center;
        font-size: 0.85rem;
        color: var(--text-muted);
        border-top: 1px solid var(--border-color);
        padding-top: 16px;
    }
    .penulis-avatar {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        margin-right: 8px;
        object-fit: cover;
    }

    /* Hero Headline */
    .hero-card {
        position: relative;
        border-radius: 24px;
        overflow: hidden;
        margin-bottom: 48px;
        box-shadow: var(--card-shadow-hover);
    }
    .hero-img {
        width: 100%;
        height: 500px;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .hero-card:hover .hero-img {
        transform: scale(1.05);
    }
    .hero-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0) 100%);
        padding: 40px;
        color: #ffffff;
    }
    .hero-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: #ffffff;
        text-decoration: none;
        margin-bottom: 12px;
        display: block;
        line-height: 1.2;
        letter-spacing: -0.5px;
    }
    .hero-title:hover {
        text-decoration: underline;
    }
    
    /* Sidebar */
    .sidebar-widget {
        background-color: var(--bg-surface);
        border-radius: 16px;
        padding: 24px;
        box-shadow: var(--card-shadow);
        margin-bottom: 24px;
    }
    .sidebar-title {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 16px;
        color: var(--text-main);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #1a73e8;
        padding-bottom: 8px;
        display: inline-block;
    }
    .terkini-item {
        display: flex;
        margin-bottom: 16px;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 16px;
    }
    .terkini-item:last-child {
        margin-bottom: 0;
        border-bottom: none;
        padding-bottom: 0;
    }
    .terkini-img {
        width: 80px;
        height: 80px;
        border-radius: 8px;
        object-fit: cover;
        margin-right: 16px;
        transition: transform 0.3s ease;
    }
    .terkini-item:hover .terkini-img {
        transform: scale(1.1);
    }
    .terkini-title {
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--text-main);
        text-decoration: none;
        line-height: 1.4;
    }
    .terkini-title:hover {
        color: #1a73e8;
    }
</style>
@endpush

@section('content')

@if(isset($headline) && !isset($kategoriAktif))
<!-- Hero Headline Section (Hanya tampil di beranda utama) -->
<div class="hero-card">
    <a href="{{ route('baca', $headline->id) }}">
        @if($headline->gambar && $headline->gambar !== 'default.png')
            <img src="{{ asset('storage/gambar/' . $headline->gambar) }}" class="hero-img" alt="{{ $headline->judul }}">
        @else
            <div class="hero-img d-flex align-items-center justify-content-center" style="background-color: #444746;">
                <span class="material-icons-outlined" style="font-size: 64px; color: #ffffff;">image</span>
            </div>
        @endif
    </a>
    <div class="hero-overlay">
        <span class="badge mb-3" style="background-color: #1a73e8; font-size: 0.9rem; padding: 6px 12px; border-radius: 6px;">
            {{ $headline->kategori->nama_kategori ?? 'Berita Utama' }}
        </span>
        <a href="{{ route('baca', $headline->id) }}" class="hero-title">
            {{ $headline->judul }}
        </a>
        <div class="d-flex align-items-center mt-2" style="font-size: 0.9rem; opacity: 0.9;">
            <a href="{{ route('penulis.show', $headline->penulis->user_name ?? '#') }}" class="d-flex align-items-center text-white text-decoration-none me-3">
                <span class="material-icons-outlined me-1" style="font-size: 16px;">person</span>
                <span>{{ $headline->penulis->nama_lengkap ?? 'Admin' }}</span>
            </a>
            <span class="material-icons-outlined me-1" style="font-size: 16px;">calendar_today</span>
            <span>{{ \Carbon\Carbon::parse($headline->tanggal)->translatedFormat('d F Y') }}</span>
        </div>
    </div>
</div>
@endif

@if(isset($kategoriAktif))
<div class="mb-5 text-center">
    <h2 class="fw-bold" style="color: #1f1f1f; letter-spacing: -0.5px;">Kategori: {{ $kategoriAktif->nama_kategori }}</h2>
</div>
@endif

<!-- Layout 2 Kolom -->
<div class="row g-5">
    
    <!-- Kolom Kiri: Daftar Berita (Grid) -->
    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold m-0" style="color: var(--text-main);">Berita Terbaru</h4>
        </div>
        
        <div class="row g-4" id="artikel-grid-container">
            @if($artikel->isEmpty())
                <div class="col-12 text-center py-5">
                    <span class="material-icons-outlined mb-2" style="font-size: 48px; color: var(--text-muted);">article</span>
                    <h5 style="color: var(--text-muted);">{{ __('Belum ada artikel.') }}</h5>
                </div>
            @else
                @include('frontend.partials.artikel_grid')
            @endif
        </div>

        @if($artikel->hasMorePages())
            <div class="text-center mt-5" id="load-more-wrapper">
                <button id="btn-load-more" class="btn btn-outline-primary rounded-pill px-4 py-2" data-url="{{ $artikel->nextPageUrl() }}" style="font-weight: 600;">
                    <span class="material-icons-outlined align-middle me-1">autorenew</span> {{ __('Muat Lebih Banyak') }}
                </button>
            </div>
        @endif
    </div>

    <!-- Kolom Kanan: Sidebar -->
    <div class="col-lg-4">
        @include('frontend.partials.sidebar')
    </div>

</div>

@endsection

@push('scripts')
<script>
    // --- Load More Logic ---
    const btnLoadMore = document.getElementById('btn-load-more');
    const loadMoreWrapper = document.getElementById('load-more-wrapper');
    const gridContainer = document.getElementById('artikel-grid-container');

    if (btnLoadMore) {
        btnLoadMore.addEventListener('click', function() {
            const url = this.getAttribute('data-url');
            if (!url) return;

            const originalText = this.innerHTML;
            this.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Loading...';
            this.disabled = true;

            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                gridContainer.insertAdjacentHTML('beforeend', data.html);
                if (data.next_page) {
                    this.setAttribute('data-url', data.next_page);
                    this.innerHTML = originalText;
                    this.disabled = false;
                } else {
                    loadMoreWrapper.remove(); // No more pages
                }
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                this.innerHTML = originalText;
                this.disabled = false;
            });
        });
    }
</script>
@endpush
