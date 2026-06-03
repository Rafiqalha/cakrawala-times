@forelse($artikel as $item)
    <div class="col-md-6 artikel-grid-item">
        <div class="artikel-card">
            <a href="{{ route('baca', $item->id) }}" style="overflow: hidden;">
                @if($item->gambar && $item->gambar !== 'default.png')
                    <img src="{{ asset('storage/gambar/' . $item->gambar) }}" class="artikel-img" alt="{{ $item->judul }}">
                @else
                    <div class="artikel-img d-flex align-items-center justify-content-center" style="background-color: var(--input-bg);">
                        <span class="material-icons-outlined" style="font-size: 48px; color: var(--text-muted);">image</span>
                    </div>
                @endif
            </a>
            
            <div class="artikel-body">
                <div class="mb-2">
                    <span class="badge" style="background-color: #e8def8; color: #1d192b; border-radius: 6px; padding: 4px 8px; font-weight: 500;">
                        {{ $item->kategori->nama_kategori ?? __('Tanpa Kategori') }}
                    </span>
                </div>
                
                @php
                    $h_judul = $item->judul;
                    $h_excerpt = \Illuminate\Support\Str::limit(strip_tags($item->isi_artikel), 100);
                    
                    if (isset($keyword) && !empty(trim($keyword))) {
                        $esc_kw = preg_quote($keyword, '/');
                        // Highlight Judul
                        $h_judul = preg_replace('/(' . $esc_kw . ')/i', '<mark style="background-color: #ff9800; color: white; padding: 0 2px; border-radius: 4px;">$1</mark>', htmlspecialchars($item->judul));
                        // Highlight Excerpt
                        $h_excerpt = preg_replace('/(' . $esc_kw . ')/i', '<mark style="background-color: #ff9800; color: white; padding: 0 2px; border-radius: 4px;">$1</mark>', htmlspecialchars($h_excerpt));
                    } else {
                        $h_judul = htmlspecialchars($h_judul);
                        $h_excerpt = htmlspecialchars($h_excerpt);
                    }
                @endphp

                <a href="{{ route('baca', $item->id) }}" class="artikel-title">
                    {!! $h_judul !!}
                </a>
                
                <div class="artikel-excerpt">
                    {!! $h_excerpt !!}
                </div>
                
                <div class="artikel-meta mt-auto">
                    @php
                        $fotoPenulis = $item->penulis && $item->penulis->foto ? $item->penulis->foto : 'default.png';
                        $username = $item->penulis ? $item->penulis->user_name : '#';
                    @endphp
                    <a href="{{ route('penulis.show', $username) }}" class="d-flex align-items-center text-decoration-none me-auto" style="color: var(--text-muted);">
                        <img src="{{ asset('storage/foto/' . $fotoPenulis) }}" class="penulis-avatar" alt="Avatar">
                        <span style="font-weight: 500;">
                            {{ $item->penulis->nama_lengkap ?? 'Redaksi' }}
                        </span>
                    </a>
                    
                    <span class="d-flex align-items-center">
                        <span class="material-icons-outlined me-1" style="font-size: 14px;">calendar_today</span>
                        {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M') }}
                    </span>
                </div>
            </div>
        </div>
    </div>
@empty
    <!-- Kosong jika load more tidak ada sisa, namun pada awal request jika kosong akan ditangani dari home -->
@endforelse
