<!-- Widget: Topik Pilihan -->
<div class="sidebar-widget">
    <h5 class="sidebar-title">Topik Pilihan</h5>
    <div>
        <a href="{{ route('home') }}" class="chip-kategori {{ !isset($kategoriAktif) ? 'active' : '' }}">Semua Berita</a>
        @foreach($kategori as $kat)
            <a href="{{ route('kategori.public', $kat->id) }}" 
               class="chip-kategori {{ (isset($kategoriAktif) && $kategoriAktif->id == $kat->id) ? 'active' : '' }}">
                {{ $kat->nama_kategori }}
            </a>
        @endforeach
    </div>
</div>

<!-- Widget: Berita Terkini -->
<div class="sidebar-widget">
    <h5 class="sidebar-title">Berita Terkini</h5>
    @foreach($terkini as $tk)
        <div class="terkini-item">
            @if($tk->gambar && $tk->gambar !== 'default.png')
                <div style="overflow: hidden; border-radius: 8px; margin-right: 16px;">
                    <img src="{{ asset('storage/gambar/' . $tk->gambar) }}" class="terkini-img m-0" alt="{{ $tk->judul }}">
                </div>
            @else
                <div class="terkini-img d-flex align-items-center justify-content-center" style="background-color: var(--input-bg);">
                    <span class="material-icons-outlined" style="color: var(--text-muted);">image</span>
                </div>
            @endif
            <div>
                <a href="{{ route('baca', $tk->id) }}" class="terkini-title">
                    {{ \Illuminate\Support\Str::limit($tk->judul, 60) }}
                </a>
                <div class="text-muted small mt-1">
                    {{ \Carbon\Carbon::parse($tk->tanggal)->diffForHumans() }}
                </div>
            </div>
        </div>
    @endforeach
</div>
