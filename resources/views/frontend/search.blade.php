@extends('frontend.layout')

@section('title', 'Hasil Pencarian: ' . $keyword . ' - Cakrawala Times')

@push('styles')
<style>
    /* Styling sama seperti di beranda (home) */
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
        font-weight: 500;
        color: var(--text-main);
        margin-bottom: 8px;
        line-height: 1.4;
        text-decoration: none;
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
    .artikel-meta-icon {
        font-size: 16px;
        margin-right: 4px;
        color: var(--text-muted);
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

<!-- Header Section -->
<div class="mb-5 text-center">
    <h2 class="fw-bold" style="color: var(--text-main); letter-spacing: -0.5px;">
        Hasil Pencarian untuk: "{{ $keyword }}"
    </h2>
    <p class="text-muted fs-5 mt-2">Ditemukan {{ $artikel->count() }} artikel yang relevan.</p>
</div>

<!-- Articles Grid -->
<div class="row g-4" id="artikel-grid-container">
    @if($artikel->isEmpty())
        <div class="col-12 text-center py-5">
            <span class="material-icons-outlined mb-3" style="font-size: 64px; color: var(--text-muted);">search_off</span>
            <h4 style="color: var(--text-main);">{{ __('Tidak Ada Hasil Ditemukan') }}</h4>
            <p style="color: var(--text-muted);">{{ __('Maaf, kami tidak dapat menemukan berita yang cocok dengan pencarian Anda. Silakan coba kata kunci lain.') }}</p>
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
