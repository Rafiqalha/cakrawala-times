<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @yield('meta')
    <!-- Meta PWA -->
    <meta name="theme-color" content="#1a73e8">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="apple-touch-icon" href="{{ asset('images/icons/icon-192x192.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('images/icons/icon-192x192-removebg-preview.png') }}">
    
    <title>@yield('title', 'Cakrawala Times - Portal Berita Modern')</title>
    <!-- Google Fonts: Inter & Lora -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Lora:ital,wght@0,400;0,500;0,600;1,400;1,500&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Brands Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <style>
        :root {
            --bg-body: #f8f9fa;
            --bg-surface: #ffffff;
            --text-main: #1f1f1f;
            --text-muted: #747775;
            --border-color: #e0e0e0;
            --nav-bg: #ffffff;
            --input-bg: #f0f4f9;
            --card-shadow: 0 1px 3px 0 rgba(0,0,0,0.12);
            --card-shadow-hover: 0 4px 8px 3px rgba(0,0,0,0.15);
        }
        
        .dark-mode {
            --bg-body: #000000; /* Deep Black */
            --bg-surface: #111111; /* Extremely dark gray for cards */
            --text-main: #e3e3e3;
            --text-muted: #a0a0a0;
            --border-color: #333333;
            --nav-bg: #000000;
            --input-bg: #222222;
            --card-shadow: 0 1px 3px 0 rgba(255,255,255,0.05);
            --card-shadow-hover: 0 4px 12px 0 rgba(255,255,255,0.1);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Reading Progress Bar */
        #reading-progress-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: transparent;
            z-index: 1050;
        }
        #reading-progress-bar {
            height: 100%;
            background-color: #1a73e8;
            width: 0%;
            transition: width 0.1s;
        }

        /* Top App Bar */
        .navbar {
            background-color: var(--nav-bg) !important;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.08);
            padding-top: 14px;
            padding-bottom: 14px;
            position: sticky;
            top: 0;
            z-index: 1020;
            transition: background-color 0.3s ease;
        }
        .navbar-brand {
            color: #1a73e8 !important;
            font-weight: 700;
            font-size: 1.5rem;
            letter-spacing: 0.2px;
        }
        .nav-link {
            color: var(--text-muted) !important;
            font-weight: 500;
            border-radius: 100px;
            padding: 8px 16px !important;
            margin: 0 4px;
            transition: all 0.2s ease;
            white-space: nowrap;
        }
        .nav-link:hover {
            background-color: var(--input-bg);
            color: #1a73e8 !important;
        }
        .btn-login {
            background-color: var(--input-bg);
            color: #1a73e8;
            border-radius: 100px;
            font-weight: 500;
            padding: 8px 24px;
            border: none;
            transition: all 0.2s ease;
        }
        .btn-login:hover {
            background-color: #1a73e8;
            color: #ffffff;
        }
        
        .btn-theme-toggle {
            background: transparent;
            border: none;
            color: var(--text-muted);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            cursor: pointer;
        }
        .btn-theme-toggle:hover {
            background-color: var(--input-bg);
            color: var(--text-main);
        }

        .main-content {
            min-height: 80vh;
            padding-top: 32px;
            padding-bottom: 32px;
        }
        
        /* Input Search */
        .search-input {
            border-radius: 100px; 
            border: 1px solid var(--border-color); 
            background-color: var(--input-bg);
            color: var(--text-main);
            transition: all 0.3s;
        }
        .search-input:focus {
            background-color: var(--bg-surface);
            color: var(--text-main);
            border-color: #1a73e8;
            box-shadow: none;
        }
        .search-input::placeholder {
            color: var(--text-muted);
        }

        /* Footer */
        .newsletter-section {
            background: linear-gradient(135deg, #1a73e8, #041e49);
            color: white;
            padding: 64px 0;
            margin-top: 80px;
            border-radius: 24px;
            margin-left: 12px;
            margin-right: 12px;
            text-align: center;
        }
        .newsletter-input {
            border-radius: 100px 0 0 100px;
            border: none;
            padding: 16px 24px;
            font-size: 1rem;
        }
        .newsletter-btn {
            border-radius: 0 100px 100px 0;
            padding: 16px 32px;
            background-color: #ff9800;
            color: #fff;
            font-weight: 600;
            border: none;
            transition: all 0.2s;
        }
        .newsletter-btn:hover {
            background-color: #f57c00;
        }

        footer {
            background-color: #1a1c1e;
            color: #c4c7c5;
            padding: 64px 0 24px 0;
            margin-top: 40px;
        }
        .footer-brand {
            color: #ffffff !important;
            font-weight: 700;
            font-size: 1.75rem;
            letter-spacing: 0.5px;
            text-decoration: none;
        }
        .footer-heading {
            color: #ffffff;
            font-weight: 600;
            margin-bottom: 24px;
            font-size: 1.1rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .footer-link {
            color: #a8c7fa;
            text-decoration: none;
            display: block;
            margin-bottom: 12px;
            transition: color 0.2s;
        }
        .footer-link:hover {
            color: #ffffff;
        }
        .footer-bottom {
            border-top: 1px solid #444746;
            padding-top: 24px;
            margin-top: 48px;
            font-size: 0.9rem;
        }
        .social-icon {
            color: #c4c7c5;
            margin-right: 16px;
            text-decoration: none;
            transition: color 0.2s;
        }
        .social-icon:hover {
            color: #ffffff;
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Reading Progress Bar -->
    <div id="reading-progress-container">
        <div id="reading-progress-bar"></div>
    </div>

    <!-- Top App Bar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <img src="{{ asset('images/icons/icon-192x192-removebg-preview.png') }}" class="me-2" style="height: 32px; width: auto;" alt="Logo Cakrawala Times">
                Cakrawala Times
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="material-icons-outlined" style="color: var(--text-main);">menu</span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active fw-semibold' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    @php
                        $semuaKategori = \App\Models\KategoriArtikel::all();
                    @endphp
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ __('Topik') }}
                        </a>
                        <ul class="dropdown-menu border-0 shadow-sm" style="border-radius: 12px; background-color: var(--bg-surface);">
                            @foreach($semuaKategori as $kat)
                                <li><a class="dropdown-item py-2" style="color: var(--text-main);" href="{{ route('kategori.public', $kat->id) }}">{{ $kat->nama_kategori }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">{{ __('Tentang Kami') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('redaksi') }}">{{ __('Redaksi') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">{{ __('Kontak') }}</a>
                    </li>
                </ul>

                <!-- Search Bar -->
                <form action="{{ route('search') }}" method="GET" class="d-flex me-2 position-relative" style="max-width: 250px;">
                    <span class="material-icons-outlined position-absolute" style="left: 12px; top: 8px; color: var(--text-muted); font-size: 20px;">search</span>
                    <input class="form-control ps-5 search-input" type="search" name="q" id="live-search-input" placeholder="{{ __('Cari...') }}" autocomplete="off" aria-label="Search">
                    
                    <!-- Live Search Dropdown -->
                    <div id="live-search-results" class="position-absolute shadow-lg d-none" style="top: 100%; left: 0; right: 0; background-color: var(--bg-surface); border-radius: 12px; margin-top: 8px; z-index: 1050; max-height: 400px; overflow-y: auto; border: 1px solid var(--border-color);">
                    </div>
                </form>

                <!-- Language Switcher -->
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 4px 8px !important;">
                            @if(app()->getLocale() == 'id')
                                🇮🇩 ID
                            @else
                                🇺🇸 EN
                            @endif
                        </a>
                        <ul class="dropdown-menu border-0 shadow-sm" style="border-radius: 12px; background-color: var(--bg-surface); min-width: 100px;">
                            <li><a class="dropdown-item py-2" style="color: var(--text-main);" href="{{ route('lang.switch', 'id') }}">🇮🇩 Indonesia</a></li>
                            <li><a class="dropdown-item py-2" style="color: var(--text-main);" href="{{ route('lang.switch', 'en') }}">🇺🇸 English</a></li>
                        </ul>
                    </li>
                </ul>

                <!-- Bookmark Button -->
                <button id="bookmark-toggle" class="btn-theme-toggle mx-1" title="Artikel Tersimpan" data-bs-toggle="modal" data-bs-target="#bookmarkModal">
                    <span class="material-icons-outlined" style="color: var(--text-muted);">bookmarks</span>
                </button>

                <!-- Theme Toggle -->
                <button id="theme-toggle" class="btn-theme-toggle mx-1 me-3" title="Ganti Tema">
                    <span class="material-icons-outlined" id="theme-icon">dark_mode</span>
                </button>

                <div class="d-flex align-items-center">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-login d-flex align-items-center">
                            <span class="material-icons-outlined me-1" style="font-size: 18px;">dashboard</span> Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-login d-flex align-items-center">
                            <span class="material-icons-outlined me-1" style="font-size: 18px;">login</span> Login
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content container">
        @yield('content')
    </main>

    <!-- Newsletter Section -->
    <div class="container">
        <div class="newsletter-section shadow-sm">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <h3 class="fw-bold mb-3">Berlangganan Newsletter Cakrawala</h3>
                    <p class="mb-4" style="color: #a8c7fa; font-size: 1.1rem;">Dapatkan ringkasan berita eksklusif dan tajuk rencana pilihan redaksi setiap pagi langsung di kotak masuk Anda.</p>
                    <form onsubmit="subscribeNewsletter(event)" class="d-flex">
                        <input type="email" class="form-control newsletter-input" placeholder="Masukkan alamat surel (email) Anda" required>
                        <button type="submit" class="btn newsletter-btn">Subscribe</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row g-5">
                <!-- Kolom 1: Brand & Deskripsi -->
                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('home') }}" class="footer-brand d-flex align-items-center mb-3">
                        <img src="{{ asset('images/icons/icon-192x192-removebg-preview.png') }}" class="me-2" style="height: 36px; width: auto;" alt="Logo Cakrawala Times">
                        Cakrawala Times
                    </a>
                    <p style="line-height: 1.8; margin-bottom: 24px;">Portal berita independen terdepan yang menyajikan jurnalisme berkualitas, tajam, berimbang, dan berstandar global untuk mencerahkan wawasan Anda.</p>
                    <div class="d-flex align-items-center">
                        <a href="#" class="social-icon" title="Facebook"><i class="fa-brands fa-facebook-f fa-lg"></i></a>
                        <a href="#" class="social-icon" title="X (Twitter)"><i class="fa-brands fa-x-twitter fa-lg"></i></a>
                        <a href="#" class="social-icon" title="Instagram"><i class="fa-brands fa-instagram fa-lg"></i></a>
                        <a href="#" class="social-icon" title="TikTok"><i class="fa-brands fa-tiktok fa-lg"></i></a>
                        <a href="#" class="social-icon" title="YouTube"><i class="fa-brands fa-youtube fa-lg"></i></a>
                    </div>
                </div>

                <!-- Kolom 2: Rubrik / Kategori -->
                <div class="col-lg-3 col-md-6">
                    <h5 class="footer-heading">{{ __('Kanal Utama') }}</h5>
                    @foreach($semuaKategori->take(5) as $kat)
                        <a href="{{ route('kategori.public', $kat->id) }}" class="footer-link">{{ $kat->nama_kategori }}</a>
                    @endforeach
                </div>

                <!-- Kolom 3: Perusahaan -->
                <div class="col-lg-2 col-md-6">
                    <h5 class="footer-heading">{{ __('Perusahaan') }}</h5>
                    <a href="{{ route('about') }}" class="footer-link">{{ __('Tentang Kami') }}</a>
                    <a href="{{ route('redaksi') }}" class="footer-link">{{ __('Susunan Redaksi') }}</a>
                    <a href="#" class="footer-link">{{ __('Karir') }}</a>
                    <a href="#" class="footer-link">{{ __('Pedoman Siber') }}</a>
                </div>

                <!-- Kolom 4: Bantuan & Legal -->
                <div class="col-lg-3 col-md-6">
                    <h5 class="footer-heading">{{ __('Bantuan & Legal') }}</h5>
                    <a href="{{ route('contact') }}" class="footer-link">{{ __('Hubungi Kami') }}</a>
                    <a href="{{ route('privacy') }}" class="footer-link">{{ __('Kebijakan Privasi') }}</a>
                    <a href="#" class="footer-link">{{ __('Syarat & Ketentuan') }}</a>
                    <a href="#" class="footer-link">{{ __('Panduan Komunitas') }}</a>
                </div>
            </div>

            <div class="footer-bottom d-flex flex-column flex-md-row justify-content-between align-items-center">
                <p class="mb-2 mb-md-0">&copy; {{ date('Y') }} PT Cakrawala Media Jurnalistik. {{ __('Seluruh Hak Cipta Dilindungi Undang-Undang.') }}</p>
                <div style="font-size: 0.85rem;">
                    Didesain menggunakan Google Material 3
                </div>
            </div>
        </div>
    </footer>

    <!-- Bookmark Modal -->
    <div class="modal fade" id="bookmarkModal" tabindex="-1" aria-labelledby="bookmarkModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg" style="background-color: var(--bg-surface); color: var(--text-main); border-radius: 16px;">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold d-flex align-items-center" id="bookmarkModalLabel">
                        <span class="material-icons-outlined me-2" style="color: #1a73e8;">bookmarks</span>
                        Artikel Tersimpan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="bookmark-list-container" style="min-height: 200px;">
                    <!-- Diisi lewat JS -->
                    <div class="text-center text-muted mt-5">
                        <span class="material-icons-outlined mb-2" style="font-size: 48px; color: var(--border-color);">bookmark_border</span>
                        <p>Belum ada artikel yang disimpan.</p>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-login w-100" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Wow Features Scripts -->
    <script>
        // --- 1. Dark Mode Logic ---
        const themeToggle = document.getElementById('theme-toggle');
        const themeIcon = document.getElementById('theme-icon');
        const body = document.body;
        
        const currentTheme = localStorage.getItem('theme');
        if (currentTheme === 'dark') {
            body.classList.add('dark-mode');
            themeIcon.textContent = 'light_mode';
        }

        themeToggle.addEventListener('click', () => {
            body.classList.toggle('dark-mode');
            
            if (body.classList.contains('dark-mode')) {
                localStorage.setItem('theme', 'dark');
                themeIcon.textContent = 'light_mode';
            } else {
                localStorage.setItem('theme', 'light');
                themeIcon.textContent = 'dark_mode';
            }
        });

        // --- 2. Reading Progress Bar Logic ---
        window.addEventListener('scroll', () => {
            const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrolled = (winScroll / height) * 100;
            document.getElementById("reading-progress-bar").style.width = scrolled + "%";
        });
        
        // --- 3. Newsletter Logic ---
        function subscribeNewsletter(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Berhasil Berlangganan!',
                text: 'Terima kasih telah bergabung. Anda akan mulai menerima newsletter kami.',
                icon: 'success',
                confirmButtonColor: '#1a73e8',
                background: document.body.classList.contains('dark-mode') ? '#1f1f1f' : '#ffffff',
                color: document.body.classList.contains('dark-mode') ? '#ffffff' : '#000000',
            });
            e.target.reset();
        }

        // --- 4. Bookmark Modal Render Logic ---
        document.getElementById('bookmarkModal').addEventListener('show.bs.modal', function () {
            const container = document.getElementById('bookmark-list-container');
            let bookmarks = JSON.parse(localStorage.getItem('bookmarks')) || [];
            
            if (bookmarks.length === 0) {
                container.innerHTML = `
                    <div class="text-center text-muted mt-5">
                        <span class="material-icons-outlined mb-2" style="font-size: 48px; color: var(--border-color);">bookmark_border</span>
                        <p>Belum ada artikel yang disimpan.</p>
                    </div>`;
                return;
            }
            
            let html = '<div class="list-group list-group-flush">';
            bookmarks.reverse().forEach((b, index) => {
                html += `
                <a href="${b.url}" class="list-group-item list-group-item-action d-flex align-items-center p-3 mb-2 rounded border-0" style="background-color: var(--input-bg);">
                    <img src="${b.image}" alt="Img" class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                    <div class="flex-grow-1">
                        <h6 class="mb-1 fw-bold" style="font-size: 0.95rem; color: var(--text-main);">${b.title}</h6>
                        <small style="color: var(--text-muted);">${b.date}</small>
                    </div>
                    <button class="btn btn-sm text-danger ms-2" onclick="removeBookmark(event, '${b.id}')" title="Hapus">
                        <span class="material-icons-outlined">delete</span>
                    </button>
                </a>`;
            });
            html += '</div>';
            container.innerHTML = html;
        });

        function removeBookmark(e, id) {
            e.preventDefault();
            e.stopPropagation();
            let bookmarks = JSON.parse(localStorage.getItem('bookmarks')) || [];
            bookmarks = bookmarks.filter(b => b.id !== id);
            localStorage.setItem('bookmarks', JSON.stringify(bookmarks));
            // Re-render
            const event = new Event('show.bs.modal');
            document.getElementById('bookmarkModal').dispatchEvent(event);
        }

        // --- 5. Live Search & Highlighting ---
        const searchInput = document.getElementById('live-search-input');
        const searchResults = document.getElementById('live-search-results');
        let searchTimeout;

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                const query = this.value.trim();

                if (query.length < 2) {
                    searchResults.classList.add('d-none');
                    return;
                }

                // Animasi Loading
                searchResults.classList.remove('d-none');
                searchResults.innerHTML = '<div class="p-3 text-center text-muted"><span class="spinner-border spinner-border-sm me-2"></span>Mencari...</div>';

                searchTimeout = setTimeout(() => {
                    fetch(`/live-search?q=${encodeURIComponent(query)}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.length === 0) {
                                searchResults.innerHTML = '<div class="p-3 text-center text-muted small">Tidak ditemukan hasil.</div>';
                                return;
                            }

                            let html = '<div class="list-group list-group-flush">';
                            data.forEach(item => {
                                // Simple Highlight untuk Judul (Case Insensitive)
                                const regex = new RegExp('(' + query.replace(/[.*+?^${}()|[\\]\\\\]/g, '\\\\$&') + ')', 'gi');
                                const highlightedTitle = item.judul.replace(regex, '<mark style="background-color: #ff9800; color: white; padding: 0 2px; border-radius: 4px;">$1</mark>');
                                
                                const imgPath = item.gambar && item.gambar !== 'default.png' ? '/storage/gambar/' + item.gambar : '';
                                const imgHtml = imgPath ? `<img src="${imgPath}" class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">` : '';

                                html += `
                                <a href="/baca/${item.id}" class="list-group-item list-group-item-action d-flex align-items-center p-2 border-0" style="background-color: transparent;">
                                    ${imgHtml}
                                    <div class="flex-grow-1 text-truncate">
                                        <div class="text-truncate" style="font-size: 0.9rem; color: var(--text-main); font-weight: 500;">${highlightedTitle}</div>
                                        <small class="text-muted" style="font-size: 0.75rem;">${item.kategori ? item.kategori.nama_kategori : ''}</small>
                                    </div>
                                </a>`;
                            });
                            html += `<a href="/cari?q=${encodeURIComponent(query)}" class="list-group-item list-group-item-action text-center text-primary py-2 border-0" style="font-size: 0.85rem; font-weight: 600; background-color: var(--input-bg);">Lihat semua hasil</a></div>`;
                            
                            searchResults.innerHTML = html;
                        })
                        .catch(err => {
                            searchResults.innerHTML = '<div class="p-3 text-center text-danger small">Gagal memuat.</div>';
                        });
                }, 300); // 300ms Debounce
            });

            // Sembunyikan hasil saat klik di luar
            document.addEventListener('click', function(e) {
                if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                    searchResults.classList.add('d-none');
                }
            });
            // Tampilkan kembali saat input diklik
            searchInput.addEventListener('focus', function() {
                if (this.value.trim().length >= 2) {
                    searchResults.classList.remove('d-none');
                }
            });
        }
        updateIcon();
    </script>

    <!-- 5. Service Worker Registration (PWA) -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(registration => {
                        console.log('ServiceWorker PWA berhasil didaftarkan dengan scope: ', registration.scope);
                    })
                    .catch(err => {
                        console.log('Pendaftaran ServiceWorker PWA gagal: ', err);
                    });
            });
        }
    </script>
    
    @stack('scripts')
</body>
</html>
