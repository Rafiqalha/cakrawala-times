@extends('frontend.layout')

@section('title', __('Anda Sedang Offline') . ' - Cakrawala Times')

@push('styles')
<style>
    .offline-container {
        min-height: 70vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 2rem;
    }
    .offline-icon {
        font-size: 80px;
        color: var(--text-muted);
        margin-bottom: 24px;
        animation: float 3s ease-in-out infinite;
    }
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-15px); }
        100% { transform: translateY(0px); }
    }
    .offline-title {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--text-main);
        margin-bottom: 16px;
    }
    .offline-desc {
        font-size: 1.15rem;
        color: var(--text-muted);
        max-width: 500px;
        margin-bottom: 32px;
        line-height: 1.6;
    }
    .btn-read-offline {
        background: linear-gradient(135deg, #1a73e8, #0b57d0);
        color: white;
        border: none;
        padding: 12px 32px;
        border-radius: 100px;
        font-weight: 600;
        font-size: 1.1rem;
        display: inline-flex;
        align-items: center;
        text-decoration: none;
        box-shadow: 0 8px 16px rgba(26, 115, 232, 0.2);
        transition: all 0.3s ease;
    }
    .btn-read-offline:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 20px rgba(26, 115, 232, 0.3);
        color: white;
    }
    .btn-reload {
        background-color: var(--input-bg);
        color: var(--text-main);
        border: none;
        padding: 12px 32px;
        border-radius: 100px;
        font-weight: 600;
        font-size: 1.1rem;
        display: inline-flex;
        align-items: center;
        text-decoration: none;
        margin-top: 16px;
        transition: all 0.3s ease;
    }
    .btn-reload:hover {
        background-color: var(--border-color);
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="offline-container">
        <span class="material-icons-outlined offline-icon">wifi_off</span>
        <h1 class="offline-title">{{ __('Koneksi Terputus') }}</h1>
        <p class="offline-desc">
            {{ __('Sepertinya Anda sedang tidak terhubung ke internet. Tapi tenang saja, Anda masih bisa membaca berita yang sudah Anda simpan sebelumnya.') }}
        </p>
        
        <button class="btn-read-offline" onclick="openBookmarkModal()">
            <span class="material-icons-outlined me-2">menu_book</span>
            {{ __('Buka Artikel Tersimpan') }}
        </button>
        
        <button class="btn-reload" onclick="window.location.reload()">
            <span class="material-icons-outlined me-2">refresh</span>
            {{ __('Coba Muat Ulang') }}
        </button>
    </div>
</div>

<script>
    function openBookmarkModal() {
        const modal = new bootstrap.Modal(document.getElementById('bookmarkModal'));
        modal.show();
    }
</script>
@endsection
