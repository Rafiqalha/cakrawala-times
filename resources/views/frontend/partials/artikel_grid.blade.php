@forelse($artikel as $item)
    <div class="col-12 mb-4">
        <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 12px; background-color: var(--bg-surface);">
            <a href="{{ route('baca', $item->id) }}" style="overflow: hidden; display: block;">
                @if($item->gambar && $item->gambar !== 'default.png')
                    <img src="{{ asset('storage/gambar/' . $item->gambar) }}" class="card-img-top" style="height: 280px; object-fit: cover; transition: transform 0.5s ease;" alt="{{ $item->judul }}" onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">
                @else
                    <div class="card-img-top d-flex align-items-center justify-content-center" style="height: 280px; background-color: var(--input-bg);">
                        <span class="material-icons-outlined" style="font-size: 64px; color: var(--text-muted);">image</span>
                    </div>
                @endif
            </a>
            
            <div class="card-body p-4 p-md-5">
                <div class="mb-3">
                    <span class="badge" style="background-color: #e8f0fe; color: #1a73e8; font-weight: 500; padding: 6px 12px; border-radius: 20px;">
                        {{ $item->kategori->nama_kategori ?? __('Tanpa Kategori') }}
                    </span>
                </div>
                
                @php
                    $h_judul = $item->judul;
                    $h_excerpt = \Illuminate\Support\Str::limit(strip_tags($item->isi_artikel), 200);
                    
                    if (isset($keyword) && !empty(trim($keyword))) {
                        $esc_kw = preg_quote($keyword, '/');
                        $h_judul = preg_replace('/(' . $esc_kw . ')/i', '<mark style="background-color: #ff9800; color: white; padding: 0 2px; border-radius: 4px;">$1</mark>', htmlspecialchars($item->judul));
                        $h_excerpt = preg_replace('/(' . $esc_kw . ')/i', '<mark style="background-color: #ff9800; color: white; padding: 0 2px; border-radius: 4px;">$1</mark>', htmlspecialchars($h_excerpt));
                    } else {
                        $h_judul = htmlspecialchars($h_judul);
                        $h_excerpt = htmlspecialchars($h_excerpt);
                    }
                @endphp

                <a href="{{ route('baca', $item->id) }}" class="text-decoration-none fw-bold mb-3 d-block" style="color: var(--text-main); font-size: 1.5rem; line-height: 1.4; letter-spacing: -0.3px;" onmouseover="this.style.color='#1a73e8'" onmouseout="this.style.color='var(--text-main)'">
                    {!! $h_judul !!}
                </a>
                
                <div class="d-flex align-items-center mb-4" style="font-size: 0.9rem; color: var(--text-muted);">
                    @php
                        $fotoPenulis = $item->penulis && $item->penulis->foto ? $item->penulis->foto : 'default.png';
                        $username = $item->penulis ? $item->penulis->user_name : '#';
                        $namaLengkap = $item->penulis->nama_lengkap ?? 'Redaksi';
                        $inisial = strtoupper(substr($namaLengkap, 0, 1));
                    @endphp
                    
                    @if($fotoPenulis !== 'default.png')
                        <img src="{{ asset('storage/foto/' . $fotoPenulis) }}" class="rounded-circle me-2" style="width: 28px; height: 28px; object-fit: cover;" alt="{{ $namaLengkap }}">
                    @else
                        <div class="d-flex align-items-center justify-content-center text-white me-2" style="width: 28px; height: 28px; border-radius: 50%; background-color: #1a73e8; font-size: 12px; font-weight: bold;">
                            {{ $inisial }}
                        </div>
                    @endif
                    
                    <a href="{{ route('penulis.show', $username) }}" class="text-decoration-none" style="color: var(--text-muted); font-weight: 500;" onmouseover="this.style.color='#1a73e8'" onmouseout="this.style.color='var(--text-muted)'">
                        {{ $namaLengkap }}
                    </a>
                    <span class="mx-2">•</span>
                    <span>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</span>
                </div>

                <p class="card-text mb-4" style="color: var(--text-muted); line-height: 1.7; font-size: 1rem;">
                    {!! $h_excerpt !!}
                </p>
                
                <a href="{{ route('baca', $item->id) }}" class="btn text-white rounded-pill px-4 py-2 d-inline-flex align-items-center" style="background-color: #10b981; font-weight: 500; font-size: 0.95rem; transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='#059669'" onmouseout="this.style.backgroundColor='#10b981'">
                    Baca Selengkapnya <span class="material-icons-outlined ms-1" style="font-size: 18px;">arrow_forward</span>
                </a>
            </div>
        </div>
    </div>
@empty
    <!-- Kosong -->
@endforelse
