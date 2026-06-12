<!-- Widget: Kategori Artikel -->
<div class="card border-0 shadow-sm rounded-4" style="background-color: var(--bg-surface); position: sticky; top: 100px;">
    <div class="card-body p-4 p-md-5">
        <h4 class="fw-bold mb-4" style="color: var(--text-main); letter-spacing: -0.3px;">Kategori Artikel</h4>
        <div class="d-flex flex-column gap-3">
            @php
                $totalArtikel = \App\Models\Artikel::count();
            @endphp
            <a href="{{ route('home') }}" class="d-flex justify-content-between align-items-center text-decoration-none px-3 py-2 rounded-3 {{ !isset($kategoriAktif) ? 'active' : '' }}" style="color: {{ !isset($kategoriAktif) ? '#10b981' : 'var(--text-main)' }}; background-color: {{ !isset($kategoriAktif) ? '#d1fae5' : 'transparent' }}; transition: all 0.2s;" onmouseover="this.style.backgroundColor='{{ !isset($kategoriAktif) ? '#d1fae5' : 'var(--input-bg)' }}'" onmouseout="this.style.backgroundColor='{{ !isset($kategoriAktif) ? '#d1fae5' : 'transparent' }}'">
                <span style="font-size: 1.05rem; font-weight: {{ !isset($kategoriAktif) ? '600' : '400' }};">Semua Artikel</span>
                <span class="badge rounded-pill" style="background-color: {{ !isset($kategoriAktif) ? '#10b981' : '#e2e8f0' }}; color: {{ !isset($kategoriAktif) ? '#ffffff' : '#64748b' }}; font-weight: 600; font-size: 0.85rem; padding: 6px 12px;">{{ $totalArtikel }}</span>
            </a>
            
            @foreach($kategori as $kat)
                @php
                    $isActive = isset($kategoriAktif) && $kategoriAktif->id == $kat->id;
                    $count = \App\Models\Artikel::where('id_kategori', $kat->id)->count();
                @endphp
                <a href="{{ route('kategori.public', $kat->id) }}" class="d-flex justify-content-between align-items-center text-decoration-none px-3 py-2 rounded-3 {{ $isActive ? 'active' : '' }}" style="color: {{ $isActive ? '#10b981' : 'var(--text-main)' }}; background-color: {{ $isActive ? '#d1fae5' : 'transparent' }}; transition: all 0.2s;" onmouseover="this.style.backgroundColor='{{ $isActive ? '#d1fae5' : 'var(--input-bg)' }}'" onmouseout="this.style.backgroundColor='{{ $isActive ? '#d1fae5' : 'transparent' }}'">
                    <span style="font-size: 1.05rem; font-weight: {{ $isActive ? '600' : '400' }};">{{ $kat->nama_kategori }}</span>
                    <span class="badge rounded-pill" style="background-color: {{ $isActive ? '#10b981' : '#e2e8f0' }}; color: {{ $isActive ? '#ffffff' : '#64748b' }}; font-weight: 600; font-size: 0.85rem; padding: 6px 12px;">{{ $count }}</span>
                </a>
            @endforeach
        </div>
    </div>
</div>
