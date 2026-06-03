@extends('frontend.layout')

@section('title', 'Profil Jurnalis: ' . $penulis->nama_lengkap . ' - Cakrawala Times')

@push('styles')
<style>
    /* Premium Author Profile Styling */
    .author-header {
        position: relative;
        margin-bottom: 80px;
        border-radius: 24px;
        background: linear-gradient(135deg, #1a73e8 0%, #0b57d0 100%);
        padding: 80px 40px;
        color: white;
        text-align: center;
        box-shadow: 0 10px 30px rgba(26, 115, 232, 0.2);
    }
    .author-avatar-wrapper {
        position: absolute;
        bottom: -60px;
        left: 50%;
        transform: translateX(-50%);
        width: 140px;
        height: 140px;
        border-radius: 50%;
        padding: 6px;
        background-color: var(--bg-main);
        box-shadow: 0 8px 24px rgba(0,0,0,0.1);
    }
    .author-avatar-profile {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }
    .author-name {
        font-size: 2.2rem;
        font-weight: 800;
        margin-top: 10px;
        color: var(--text-main);
        letter-spacing: -0.5px;
    }
    .author-badge {
        display: inline-flex;
        align-items: center;
        background-color: rgba(26, 115, 232, 0.1);
        color: #1a73e8;
        padding: 8px 20px;
        border-radius: 100px;
        font-size: 0.95rem;
        font-weight: 700;
        margin-bottom: 24px;
        border: 1px solid rgba(26, 115, 232, 0.2);
    }
    html[data-bs-theme="dark"] .author-badge {
        background-color: rgba(26, 115, 232, 0.2);
        border: 1px solid rgba(26, 115, 232, 0.4);
        color: #4285f4;
    }
    .author-bio {
        max-width: 700px;
        margin: 0 auto 32px auto;
        color: var(--text-muted);
        font-size: 1.15rem;
        line-height: 1.7;
    }
    .author-social {
        display: flex;
        justify-content: center;
        gap: 16px;
        margin-bottom: 20px;
    }
    .social-icon {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background-color: var(--input-bg);
        color: var(--text-main);
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    .social-icon:hover {
        background-color: #1a73e8;
        color: white;
        transform: translateY(-4px);
        box-shadow: 0 4px 12px rgba(26, 115, 232, 0.3);
    }

    /* M3 Article Card for Grid */
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
</style>
@endpush

@section('content')

@php
    $fotoPenulis = $penulis->foto ? $penulis->foto : 'default.png';
@endphp

<!-- Header Profil Penulis -->
<div class="author-header">
    <h1 style="font-weight: 800; font-size: 3rem; margin: 0; opacity: 0.2; letter-spacing: 10px; text-transform: uppercase;">CAKRAWALA</h1>
    <div class="author-avatar-wrapper">
        <img src="{{ asset('storage/foto/' . $fotoPenulis) }}" alt="{{ $penulis->nama_lengkap }}" class="author-avatar-profile">
    </div>
</div>

<div class="text-center mb-5 pb-4" style="border-bottom: 1px solid var(--border-color);">
    <h2 class="author-name">{{ $penulis->nama_lengkap }}</h2>
    
    <div class="author-badge">
        <span class="material-icons-outlined me-2" style="font-size: 20px;">verified</span>
        Jurnalis Independen Terverifikasi
    </div>
    
    <p class="author-bio">
        Jurnalis profesional yang berdedikasi menyajikan reportase faktual, tajam, dan mendalam. Fokus pada peliputan berita global, inovasi teknologi, dan dinamika bisnis dengan standar jurnalisme kelas dunia.
    </p>
    
    <div class="author-social">
        <a href="#" class="social-icon" title="Twitter / X">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
              <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865l8.875 11.633Z"/>
            </svg>
        </a>
        <a href="#" class="social-icon" title="LinkedIn">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
              <path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854V1.146zm4.943 12.248V6.169H2.542v7.225h2.401zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248-.822 0-1.359.54-1.359 1.248 0 .694.521 1.248 1.327 1.248h.016zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016a5.54 5.54 0 0 1 .016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225h2.4z"/>
            </svg>
        </a>
    </div>
</div>

<!-- Portofolio Berita Penulis -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold m-0" style="color: var(--text-main);">Portofolio Berita ({{ $artikel->total() }})</h4>
</div>

<div class="row g-4" id="artikel-grid-container">
    @if($artikel->isEmpty())
        <div class="col-12 text-center py-5">
            <span class="material-icons-outlined mb-2" style="font-size: 48px; color: var(--text-muted);">article</span>
            <h5 style="color: var(--text-muted);">Belum ada artikel yang ditulis.</h5>
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
