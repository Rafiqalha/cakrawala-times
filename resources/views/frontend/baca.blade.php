@extends('frontend.layout')

@section('title', $artikel->judul . ' - Cakrawala Times')

@section('meta')
@php
    $description = Str::limit(strip_tags($artikel->isi_artikel), 150);
    $imageUrl = $artikel->gambar && $artikel->gambar !== 'default.png' ? asset('storage/gambar/' . $artikel->gambar) : asset('default-cover.jpg');
@endphp
<!-- Open Graph / Facebook -->
<meta property="og:type" content="article">
<meta property="og:url" content="{{ Request::url() }}">
<meta property="og:title" content="{{ $artikel->judul }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:image" content="{{ $imageUrl }}">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="{{ Request::url() }}">
<meta property="twitter:title" content="{{ $artikel->judul }}">
<meta property="twitter:description" content="{{ $description }}">
<meta property="twitter:image" content="{{ $imageUrl }}">

<!-- JSON-LD Schema -->
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "NewsArticle",
  "headline": "{{ $artikel->judul }}",
  "image": [
    "{{ $imageUrl }}"
   ],
  "datePublished": "{{ \Carbon\Carbon::parse($artikel->tanggal)->toIso8601String() }}",
  "author": [{
      "@@type": "Person",
      "name": "{{ $artikel->penulis->nama_lengkap ?? 'Redaksi' }}"
  }]
}
</script>
@endsection

@push('styles')
<style>
    .article-header {
        max-width: 800px;
        margin: 0 auto 32px auto;
        text-align: center;
    }
    .article-title {
        font-weight: 700;
        font-size: 2.5rem;
        line-height: 1.3;
        color: var(--text-main);
        margin-bottom: 24px;
        letter-spacing: -0.5px;
    }
    .article-meta-box {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 16px;
        color: var(--text-muted);
        font-size: 0.95rem;
    }
    .meta-item {
        display: flex;
        align-items: center;
    }
    .meta-icon {
        font-size: 18px;
        margin-right: 6px;
        color: var(--text-muted);
    }
    .author-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 12px;
    }
    .article-cover {
        width: 100%;
        max-width: 900px;
        height: auto;
        max-height: 500px;
        object-fit: cover;
        border-radius: 20px;
        margin: 0 auto 64px auto;
        display: block;
        box-shadow: var(--card-shadow);
        transition: transform 0.5s ease;
    }
    .article-cover:hover {
        transform: scale(1.02);
    }
    .article-content {
        max-width: 760px;
        margin: 0 auto;
        font-family: 'Lora', Georgia, serif;
        font-size: 1.15rem;
        line-height: 1.85;
        color: var(--text-main);
        letter-spacing: 0.2px;
    }
    .article-content p {
        margin-bottom: 24px;
    }
    .article-content img {
        max-width: 100%;
        height: auto;
        border-radius: 12px;
        margin: 48px 0;
    }
    .btn-back {
        display: inline-flex;
        align-items: center;
        padding: 10px 24px;
        border-radius: 100px;
        background-color: var(--input-bg);
        color: #1a73e8;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s;
    }
    .btn-back:hover {
        background-color: #1a73e8;
        color: #ffffff;
    }
    .badge-category {
        background-color: #d3e3fd;
        color: #041e49;
        font-weight: 500;
        padding: 6px 12px;
        border-radius: 6px;
        text-decoration: none;
        transition: background-color 0.2s;
    }
    .badge-category:hover {
        background-color: #c2e7ff;
    }
    
    /* Social Share */
    .share-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 16px;
        margin-top: 32px;
    }
    .share-label {
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 1.5px;
    }
    .share-icons-row {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .share-icon-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 44px;
        height: 44px;
        border-radius: 50%;
        text-decoration: none;
        border: none;
        cursor: pointer;
        color: #fff;
        font-size: 1.1rem;
        transition: all 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .share-icon-btn:hover {
        transform: translateY(-3px) scale(1.08);
        box-shadow: 0 6px 16px rgba(0,0,0,0.15);
        color: #fff;
    }
    .share-icon-btn.wa  { background: #25D366; }
    .share-icon-btn.tw  { background: #000000; }
    .share-icon-btn.fb  { background: #1877F2; }
    .share-icon-btn.li  { background: #0A66C2; }
    .share-icon-btn.cp  { background: var(--input-bg); color: var(--text-main); }
    
    /* Related Articles */
    .related-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 24px;
        border-bottom: 2px solid #1a73e8;
        display: inline-block;
        padding-bottom: 8px;
    }
    .related-card {
        border: none;
        border-radius: 12px;
        background-color: var(--bg-surface);
        box-shadow: var(--card-shadow);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .related-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--card-shadow-hover);
    }
    .related-img {
        width: 100%;
        height: 140px;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .related-card:hover .related-img {
        transform: scale(1.08);
    }
    .related-body {
        padding: 16px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .related-heading {
        font-size: 1.05rem;
        font-weight: 600;
        color: var(--text-main);
        text-decoration: none;
        line-height: 1.4;
        margin-bottom: 8px;
    }
    .related-heading:hover {
        color: #1a73e8;
    }
    
    /* Reaction Styles */
    .btn-reaction {
        background-color: var(--bg-surface);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 12px 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        min-width: 90px;
        transition: all 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);
        cursor: pointer;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    .btn-reaction:hover:not(.reacted) {
        transform: translateY(-4px) scale(1.05);
        border-color: #1a73e8;
        box-shadow: 0 6px 12px rgba(26,115,232,0.15);
    }
    .btn-reaction.reacted {
        background-color: #e8efaa; /* Light Green/Yellow */
        border-color: #4caf50;
        cursor: default;
    }
    .reaction-emoji {
        font-size: 32px;
        margin-bottom: 4px;
        transition: transform 0.2s ease;
    }
    .btn-reaction:hover .reaction-emoji {
        transform: scale(1.15);
    }
    .reaction-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text-main);
    }
    .reaction-count {
        font-size: 0.8rem;
        color: var(--text-muted);
        margin-top: 4px;
        background-color: var(--input-bg);
        padding: 2px 10px;
        padding: 2px 10px;
        border-radius: 100px;
        font-weight: 500;
    }
    
    /* Live Counter Animation */
    .live-counter {
        font-weight: 700;
        transition: color 0.3s ease, transform 0.3s ease;
        display: inline-block;
    }
    .live-counter.updated {
        color: #1a73e8;
        transform: scale(1.4) translateY(-2px);
    }

    /* AI Highlighter Tooltip */
    #ai-highlighter-tooltip {
        position: absolute;
        display: none;
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(0, 0, 0, 0.05);
        padding: 10px 16px;
        border-radius: 16px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        z-index: 1000;
        transform: translateY(10px);
        opacity: 0;
        transition: opacity 0.2s ease, transform 0.2s ease;
        pointer-events: none;
    }
    #ai-highlighter-tooltip.show {
        display: flex;
        gap: 12px;
        transform: translateY(-5px);
        opacity: 1;
        pointer-events: auto;
    }
    #ai-highlighter-tooltip::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 50%;
        transform: translateX(-50%);
        border-width: 8px 8px 0;
        border-style: solid;
        border-color: rgba(255, 255, 255, 0.98) transparent transparent transparent;
    }
    .ai-btn {
        background: transparent;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 8px;
        border-radius: 14px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .ai-btn:hover {
        background: rgba(0, 0, 0, 0.04);
        transform: scale(1.15) translateY(-4px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    }
    
    /* Overlay untuk animasi keluar dari layar */
    #ai-splash-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.4);
        backdrop-filter: blur(4px);
        z-index: 9998;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.4s ease;
    }
    #ai-splash-overlay.show {
        opacity: 1;
        pointer-events: auto;
    }
</style>
@endpush

@section('content')

<div class="container py-4">
    <div class="row g-5">
<div class="col-lg-8">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb" style="font-size: 0.9rem; font-weight: 500;">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-success text-decoration-none">Beranda</a></li>
            <li class="breadcrumb-item">
                <a href="{{ route('kategori.public', $artikel->id_kategori) }}" class="text-success text-decoration-none">
                    {{ $artikel->kategori->nama_kategori ?? __('Tanpa Kategori') }}
                </a>
            </li>
            <li class="breadcrumb-item text-muted active" aria-current="page">{{ \Illuminate\Support\Str::limit($artikel->judul, 40) }}</li>
        </ol>
    </nav>

    <!-- Main Image (Top) -->
    @if($artikel->gambar && $artikel->gambar !== 'default.png')
        <div style="overflow: hidden; border-radius: 16px; margin-bottom: 24px; box-shadow: var(--card-shadow);">
            <img src="{{ asset('storage/gambar/' . $artikel->gambar) }}" style="width: 100%; height: 400px; object-fit: cover;" alt="{{ $artikel->judul }}">
        </div>
    @else
        <div class="d-flex align-items-center justify-content-center" style="background-color: var(--input-bg); height: 400px; border-radius: 16px; margin-bottom: 24px;">
            <span class="material-icons-outlined" style="font-size: 80px; color: var(--text-muted);">image</span>
        </div>
    @endif

    <!-- Category Badge -->
    <div class="mb-3">
        <span class="badge" style="background-color: #e8f0fe; color: #1a73e8; font-weight: 500; padding: 6px 12px; border-radius: 20px;">
            {{ $artikel->kategori->nama_kategori ?? __('Tanpa Kategori') }}
        </span>
    </div>

    <!-- Title -->
    <h1 class="fw-bold mb-4" style="color: var(--text-main); font-size: 2rem; line-height: 1.3; letter-spacing: -0.5px;">
        {{ $artikel->judul }}
    </h1>

    <!-- Metadata (Author & Date) -->
    <div class="d-flex align-items-center mb-4 pb-4" style="font-size: 0.95rem; color: var(--text-muted); border-bottom: 1px solid var(--border-color);">
        @php
            $fotoPenulis = $artikel->penulis && $artikel->penulis->foto ? $artikel->penulis->foto : 'default.png';
            $username = $artikel->penulis ? $artikel->penulis->user_name : '#';
            $namaLengkap = $artikel->penulis->nama_lengkap ?? 'Redaksi';
            $inisial = strtoupper(substr($namaLengkap, 0, 1));
        @endphp
        
        @if($fotoPenulis !== 'default.png')
            <img src="{{ asset('storage/foto/' . $fotoPenulis) }}" class="rounded-circle me-3" style="width: 40px; height: 40px; object-fit: cover;" alt="{{ $namaLengkap }}">
        @else
            <div class="d-flex align-items-center justify-content-center text-white me-3" style="width: 40px; height: 40px; border-radius: 50%; background-color: #1a73e8; font-size: 16px; font-weight: bold;">
                {{ $inisial }}
            </div>
        @endif
        
        <div>
            <a href="{{ route('penulis.show', $username) }}" class="text-decoration-none fw-bold d-block" style="color: var(--text-main); margin-bottom: 2px;" onmouseover="this.style.color='#1a73e8'" onmouseout="this.style.color='var(--text-main)'">
                {{ $namaLengkap }}
            </a>
            <div class="small d-flex align-items-center">
                <span>{{ \Carbon\Carbon::parse($artikel->tanggal)->translatedFormat('d F Y') }}</span>
                <span class="mx-2">•</span>
                <span>{{ \Carbon\Carbon::parse($artikel->created_at)->format('H:i') }} WIB</span>
            </div>
        </div>
    </div>

    <article class="article-content" id="article-main-content">
        {{-- Menampilkan isi artikel (HTML) tanpa escaping --}}
        {!! $artikel->isi_artikel !!}
    </article>

    <!-- AI Highlighter Tooltip -->
    <div id="ai-highlighter-tooltip">
        <button class="ai-btn" onclick="openAIPrompt('chatgpt', this)" title="Tanya ChatGPT">
            <img src="{{ asset('images/icons/OpenAI_Logo.svg.png') }}" alt="ChatGPT" style="width: 32px; height: 32px; object-fit: contain;">
        </button>
        <button class="ai-btn" onclick="openAIPrompt('claude', this)" title="Tanya Claude">
            <img src="{{ asset('images/icons/Claude_AI_logo.svg.png') }}" alt="Claude" style="width: 32px; height: 32px; object-fit: contain;">
        </button>
        <button class="ai-btn" onclick="openAIPrompt('gemini', this)" title="Tanya Gemini">
            <img src="{{ asset('images/icons/Google_Gemini_logo.svg.png') }}" alt="Gemini" style="width: 32px; height: 32px; object-fit: contain;">
        </button>
    </div>
    
    <!-- Animasi Overlay -->
    <div id="ai-splash-overlay"></div>

    <!-- Reactions Section -->
    <div class="reactions-container mt-5 pt-4 text-center" style="border-top: 1px solid var(--border-color); max-width: 800px; margin: 0 auto;">
        <h5 class="mb-4 fw-semibold" style="color: var(--text-main);">Bagaimana reaksi Anda terhadap artikel ini?</h5>
        <div class="d-flex justify-content-center flex-wrap gap-3" id="reaction-buttons">
            <button class="btn-reaction" data-tipe="inspiratif" onclick="submitReaction('inspiratif')">
                <div class="reaction-emoji">💡</div>
                <div class="reaction-label">Inspiratif</div>
                <div class="reaction-count" id="count-inspiratif">{{ $reaksiCounts['inspiratif'] }}</div>
            </button>
            <button class="btn-reaction" data-tipe="terkejut" onclick="submitReaction('terkejut')">
                <div class="reaction-emoji">😲</div>
                <div class="reaction-label">Terkejut</div>
                <div class="reaction-count" id="count-terkejut">{{ $reaksiCounts['terkejut'] }}</div>
            </button>
            <button class="btn-reaction" data-tipe="sedih" onclick="submitReaction('sedih')">
                <div class="reaction-emoji">😢</div>
                <div class="reaction-label">Sedih</div>
                <div class="reaction-count" id="count-sedih">{{ $reaksiCounts['sedih'] }}</div>
            </button>
            <button class="btn-reaction" data-tipe="menarik" onclick="submitReaction('menarik')">
                <div class="reaction-emoji">🔥</div>
                <div class="reaction-label">Menarik</div>
                <div class="reaction-count" id="count-menarik">{{ $reaksiCounts['menarik'] }}</div>
            </button>
        </div>
        <div id="reaction-message" class="mt-3 text-success fw-medium" style="display: none; opacity: 0; transition: opacity 0.3s ease;"></div>
    </div>

    <div class="text-center mt-5 pt-4" style="max-width: 800px; margin: 0 auto;">
        <a href="{{ route('home') }}" class="btn-back">
            <span class="material-icons-outlined me-2">arrow_back</span>
            {{ __('Kembali ke Beranda') }}
        </a>
    </div>
        </div>

        <!-- Sidebar Column -->
        <div class="col-lg-4">
            <!-- Related Articles Widget -->
            @if(isset($related) && count($related) > 0)
            <div class="p-4 rounded-4" style="background-color: var(--bg-surface); box-shadow: var(--card-shadow); position: sticky; top: 100px;">
                <h4 class="fw-bold mb-4" style="color: var(--text-main); border-bottom: 2px solid #1a73e8; display: inline-block; padding-bottom: 8px; font-size: 1.1rem; text-transform: uppercase; letter-spacing: 0.5px;">{{ __('Artikel Terkait') }}</h4>
                <div class="d-flex flex-column">
                    @foreach($related as $rel)
                        <div class="d-flex mb-3 pb-3" style="border-bottom: 1px solid var(--border-color);">
                            @if($rel->gambar && $rel->gambar !== 'default.png')
                                <div style="flex-shrink: 0; margin-right: 16px; overflow: hidden; border-radius: 8px;">
                                    <img src="{{ asset('storage/gambar/' . $rel->gambar) }}" alt="{{ $rel->judul }}" style="width: 80px; height: 80px; object-fit: cover; transition: transform 0.3s ease;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                                </div>
                            @else
                                <div class="d-flex align-items-center justify-content-center flex-shrink: 0 me-3 rounded" style="width: 80px; height: 80px; background-color: var(--input-bg);">
                                    <span class="material-icons-outlined" style="color: var(--text-muted);">image</span>
                                </div>
                            @endif
                            <div>
                                <a href="{{ route('baca', $rel->id) }}" class="text-decoration-none fw-semibold" style="color: var(--text-main); font-size: 0.95rem; line-height: 1.4; display: block; margin-bottom: 6px;" onmouseover="this.style.color='#1a73e8'" onmouseout="this.style.color='var(--text-main)'">
                                    {{ \Illuminate\Support\Str::limit($rel->judul, 60) }}
                                </a>
                                <div class="text-muted small d-flex align-items-center">
                                    <span class="material-icons-outlined me-1" style="font-size: 14px;">calendar_today</span>
                                    {{ \Carbon\Carbon::parse($rel->tanggal)->translatedFormat('d M Y') }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div> <!-- End of col-lg-4 -->
    </div> <!-- End of row -->
</div>

@endsection

@push('scripts')
<script>
    // --- 1. A11y Text Zoom Logic ---
    const btnDecrease = document.getElementById('btn-text-decrease');
    const btnIncrease = document.getElementById('btn-text-increase');
    const articleContent = document.querySelector('.article-content');
    
    let currentFontSize = 1.15; // rem
    
    btnIncrease.addEventListener('click', () => {
        if (currentFontSize < 2.0) {
            currentFontSize += 0.1;
            articleContent.style.fontSize = currentFontSize + 'rem';
        }
    });
    
    btnDecrease.addEventListener('click', () => {
        if (currentFontSize > 0.8) {
            currentFontSize -= 0.1;
            articleContent.style.fontSize = currentFontSize + 'rem';
        }
    });

    // --- 2. Text-to-Speech (TTS) Logic ---
    const btnPlay = document.getElementById('btn-tts-play');
    const btnStop = document.getElementById('btn-tts-stop');
    const playText = document.getElementById('tts-play-text');
    let synth = window.speechSynthesis;
    let isSpeaking = false;
    let isPaused = false;
    
    // Get pure text from article content
    function getArticleText() {
        // We only want the text from paragraphs and headings, skipping images/scripts
        let text = document.querySelector('.article-title').innerText + ". ";
        const paragraphs = document.querySelectorAll('.article-content p, .article-content h1, .article-content h2, .article-content h3, .article-content h4, .article-content li');
        paragraphs.forEach(p => {
            text += p.innerText + " ";
        });
        return text;
    }

    btnPlay.addEventListener('click', () => {
        if (isSpeaking && isPaused) {
            synth.resume();
            isPaused = false;
            playText.textContent = "Jeda";
            return;
        }
        
        if (isSpeaking && !isPaused) {
            synth.pause();
            isPaused = true;
            playText.textContent = "Lanjutkan";
            return;
        }
        
        const textToRead = getArticleText();
        if (textToRead !== '') {
            const utterance = new SpeechSynthesisUtterance(textToRead);
            // Detect locale from HTML lang attribute
            const docLang = document.documentElement.lang || 'id';
            utterance.lang = docLang === 'en' ? 'en-US' : 'id-ID';
            utterance.rate = 0.95; // Slightly slower for better comprehension
            
            utterance.onend = () => {
                isSpeaking = false;
                isPaused = false;
                playText.textContent = "Dengarkan";
                btnStop.classList.add('d-none');
            };

            synth.speak(utterance);
            isSpeaking = true;
            isPaused = false;
            playText.textContent = "Jeda";
            btnStop.classList.remove('d-none');
        }
    });

    btnStop.addEventListener('click', () => {
        if (synth.speaking) {
            synth.cancel();
            isSpeaking = false;
            isPaused = false;
            playText.textContent = "Dengarkan";
            btnStop.classList.add('d-none');
        }
    });
    
    // Cancel TTS when leaving page
    window.addEventListener('beforeunload', () => {
        if (synth.speaking) {
            synth.cancel();
        }
    });
    // --- 3. Save Bookmark Logic ---
    const btnSave = document.getElementById('btn-save-bookmark');
    const iconState = document.getElementById('bookmark-icon-state');
    const textState = document.getElementById('bookmark-text-state');
    
    if(btnSave) {
        const articleId = btnSave.getAttribute('data-id');
        let bookmarks = JSON.parse(localStorage.getItem('bookmarks')) || [];
        const isSaved = bookmarks.find(b => b.id == articleId);
        
        if (isSaved) {
            iconState.textContent = 'bookmark';
            textState.textContent = 'Tersimpan';
        }

        btnSave.addEventListener('click', () => {
            bookmarks = JSON.parse(localStorage.getItem('bookmarks')) || [];
            const index = bookmarks.findIndex(b => b.id == articleId);
            
            if (index > -1) {
                // Remove bookmark
                bookmarks.splice(index, 1);
                localStorage.setItem('bookmarks', JSON.stringify(bookmarks));
                iconState.textContent = 'bookmark_border';
                textState.textContent = 'Simpan Artikel';
                
                Swal.fire({
                    toast: true,
                    position: 'bottom-end',
                    icon: 'info',
                    title: 'Artikel dihapus dari simpanan.',
                    showConfirmButton: false,
                    timer: 3000,
                    background: document.body.classList.contains('dark-mode') ? '#1f1f1f' : '#ffffff',
                    color: document.body.classList.contains('dark-mode') ? '#ffffff' : '#000000',
                });
            } else {
                // Add bookmark
                const newBookmark = {
                    id: articleId,
                    title: btnSave.getAttribute('data-title'),
                    image: btnSave.getAttribute('data-image'),
                    url: btnSave.getAttribute('data-url'),
                    date: btnSave.getAttribute('data-date')
                };
                bookmarks.push(newBookmark);
                localStorage.setItem('bookmarks', JSON.stringify(bookmarks));
                iconState.textContent = 'bookmark';
                textState.textContent = 'Tersimpan';
                
                // Minta Service Worker untuk men-cache HTML artikel ini & gambarnya
                if ('serviceWorker' in navigator && navigator.serviceWorker.controller) {
                    navigator.serviceWorker.controller.postMessage({
                        type: 'CACHE_URLS',
                        payload: [
                            newBookmark.url,
                            newBookmark.image
                        ]
                    });
                }
                
                Swal.fire({
                    toast: true,
                    position: 'bottom-end',
                    icon: 'success',
                    title: 'Artikel berhasil disimpan!',
                    showConfirmButton: false,
                    timer: 3000,
                    background: document.body.classList.contains('dark-mode') ? '#1f1f1f' : '#ffffff',
                    color: document.body.classList.contains('dark-mode') ? '#ffffff' : '#000000',
                });
            }
        });
    }

    // --- 4. Sistem Reaksi (Emoticon) ---
    const artikelId = {{ $artikel->id }};
    const storageKey = `reaksi_artikel_${artikelId}`;
    const myReaction = localStorage.getItem(storageKey);

    // Disable button if already reacted
    if (myReaction) {
        const btn = document.querySelector(`.btn-reaction[data-tipe="${myReaction}"]`);
        if (btn) btn.classList.add('reacted');
    }

    window.submitReaction = function(tipe) {
        if (localStorage.getItem(storageKey)) {
            showMessage("Anda sudah memberikan reaksi pada artikel ini.", "text-muted");
            return;
        }

        const btn = document.querySelector(`.btn-reaction[data-tipe="${tipe}"]`);
        const originalHtml = btn.innerHTML;
        btn.style.opacity = '0.7';

        fetch(`/artikel/${artikelId}/reaksi`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ tipe_reaksi: tipe })
        })
        .then(response => response.json())
        .then(data => {
            btn.style.opacity = '1';
            if (data.success) {
                localStorage.setItem(storageKey, tipe);
                btn.classList.add('reacted');
                const countEl = document.getElementById(`count-${tipe}`);
                countEl.innerText = parseInt(countEl.innerText) + 1;
                showMessage("Terima kasih atas tanggapan Anda!", "text-success");
            } else {
                showMessage(data.message, "text-danger");
            }
        })
        .catch(err => {
            btn.style.opacity = '1';
            showMessage("Terjadi kesalahan jaringan.", "text-danger");
        });
    }

    function showMessage(msg, className) {
        const msgEl = document.getElementById('reaction-message');
        msgEl.className = `mt-3 fw-medium ${className}`;
        msgEl.innerText = msg;
        msgEl.style.display = 'block';
        setTimeout(() => msgEl.style.opacity = '1', 10);
    }

    // --- Copy Link Function ---
    window.copyLink = function() {
        navigator.clipboard.writeText(window.location.href).then(() => {
            const copyBtn = document.querySelector('.share-icon-btn.cp');
            const originalHtml = copyBtn.innerHTML;
            copyBtn.innerHTML = '<span class="material-icons-outlined" style="font-size: 20px;">check</span>';
            copyBtn.style.background = '#4caf50';
            copyBtn.style.color = '#fff';
            setTimeout(() => {
                copyBtn.innerHTML = originalHtml;
                copyBtn.style.background = '';
                copyBtn.style.color = '';
            }, 2000);
        });
    }

    // --- 5. Real-Time View Tracking & Stats Polling ---
    // Lacak tayangan (view) saat halaman dimuat
    fetch(`/artikel/${artikelId}/view`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });

    // Polling Stats secara berkala (tiap 10 detik)
    setInterval(() => {
        fetch(`/artikel/${artikelId}/stats`)
            .then(res => res.json())
            .then(data => {
                const viewEl = document.getElementById('live-views-count');
                const reactEl = document.getElementById('live-reactions-count');
                
                // Animasi update jika angka berubah
                if (parseInt(viewEl.innerText) !== data.views) {
                    viewEl.innerText = data.views;
                    triggerUpdateAnimation(viewEl);
                }
                if (parseInt(reactEl.innerText) !== data.reactions) {
                    reactEl.innerText = data.reactions;
                    triggerUpdateAnimation(reactEl);
                }
            })
            .catch(err => console.log('Live polling error:', err));
    }, 10000);

    // Efek animasi angka melompat (reaktif)
    function triggerUpdateAnimation(el) {
        el.classList.add('updated');
        setTimeout(() => el.classList.remove('updated'), 600);
    }

    // --- 6. AI Highlighter Logic ---
    const articleEl = document.getElementById('article-main-content');
    const tooltip = document.getElementById('ai-highlighter-tooltip');
    let selectedText = '';

    // Deteksi sorotan teks
    if (articleEl) {
        articleEl.addEventListener('mouseup', handleSelection);
        articleEl.addEventListener('touchend', handleSelection);
    }

    function handleSelection(e) {
        setTimeout(() => {
            const selection = window.getSelection();
            selectedText = selection.toString().trim();

            if (selectedText.length > 5) {
                const range = selection.getRangeAt(0);
                const rect = range.getBoundingClientRect();
                
                // Kalkulasi posisi agar pas di atas teks yang diblok
                const top = rect.top + window.scrollY - 55; 
                let left = rect.left + window.scrollX + (rect.width / 2) - 150; // Perkiraan setengah lebar tooltip
                
                // Hindari tooltip terpotong di tepi kiri/kanan layar
                if (left < 10) left = 10;
                
                tooltip.style.top = `${top}px`;
                tooltip.style.left = `${left}px`;
                tooltip.classList.add('show');
            } else {
                tooltip.classList.remove('show');
            }
        }, 10);
    }

    // Hilangkan tooltip jika klik di luar
    document.addEventListener('mousedown', (e) => {
        if (!tooltip.contains(e.target) && e.target.id !== 'article-main-content') {
            tooltip.classList.remove('show');
        }
    });

    window.openAIPrompt = function(ai, btnElement) {
        if (!selectedText) return;
        
        // 1. Dapatkan elemen gambar yang diklik
        const imgEl = btnElement.querySelector('img');
        const rect = imgEl.getBoundingClientRect();
        
        // 2. Buat clone gambar untuk dianimasikan
        const clone = document.createElement('img');
        clone.src = imgEl.src;
        clone.style.position = 'fixed';
        clone.style.top = rect.top + 'px';
        clone.style.left = rect.left + 'px';
        clone.style.width = rect.width + 'px';
        clone.style.height = rect.height + 'px';
        clone.style.zIndex = '9999';
        clone.style.transition = 'all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275)';
        clone.style.objectFit = 'contain';
        document.body.appendChild(clone);
        
        // 3. Tampilkan background overlay
        const overlay = document.getElementById('ai-splash-overlay');
        overlay.classList.add('show');
        
        // Hilangkan tooltip asli
        tooltip.classList.remove('show');
        
        // 4. Kalkulasi ke tengah layar dan perbesar (animasi masuk)
        setTimeout(() => {
            const targetTop = (window.innerHeight / 2) - (rect.height / 2);
            const targetLeft = (window.innerWidth / 2) - (rect.width / 2);
            
            clone.style.top = targetTop + 'px';
            clone.style.left = targetLeft + 'px';
            clone.style.transform = 'scale(6)';
        }, 10);
        
        // 5. Siapkan URL
        const encodedText = encodeURIComponent(selectedText);
        let url = '';

        if (ai === 'chatgpt') {
            url = `https://chatgpt.com/?q=Jelaskan+maksud+kalimat+berikut+dalam+bahasa+indonesia+yang+mudah+dipahami:+%22${encodedText}%22`;
        } else if (ai === 'claude') {
            url = `https://claude.ai/new?q=Tolong+analisis+dan+jelaskan+kalimat+ini:+%22${encodedText}%22`;
        } else if (ai === 'gemini') {
            url = `https://gemini.google.com/app?q=Berikan+penjelasan+untuk+kalimat+ini:+%22${encodedText}%22`;
        }

        // 6. Eksekusi perpindahan halaman setelah animasi selesai
        setTimeout(() => {
            if (url) window.open(url, '_blank');
            window.getSelection().removeAllRanges();
            
            // Cleanup
            overlay.classList.remove('show');
            setTimeout(() => clone.remove(), 400); // Tunggu sampai hilang
        }, 700);
    }
</script>
@endpush
