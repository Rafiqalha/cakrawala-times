@extends('frontend.layout')

@section('title', 'Kontak - Cakrawala Times')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="text-center mb-5">
                <span class="material-icons-outlined mb-3" style="font-size: 64px; color: #1a73e8;">email</span>
                <h1 class="fw-bold" style="color: var(--text-main);">Hubungi Kami</h1>
                <p class="text-muted fs-5">Punya pertanyaan, kritik, saran, atau tawaran kerja sama? Kami siap mendengarkan Anda.</p>
            </div>
            
            <div class="card border-0" style="border-radius: 16px; background-color: var(--bg-surface); box-shadow: var(--card-shadow);">
                <div class="card-body p-4 p-md-5">
                    <form action="#" method="POST" onsubmit="event.preventDefault(); alert('Pesan berhasil terkirim! (Simulasi)');">
                        <div class="mb-4">
                            <label class="form-label fw-medium" style="color: var(--text-main);">Nama Lengkap</label>
                            <input type="text" class="form-control px-3 py-2" placeholder="Masukkan nama Anda" required style="border-radius: 8px; background-color: var(--input-bg); color: var(--text-main); border: 1px solid var(--border-color);">
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-medium" style="color: var(--text-main);">Email</label>
                            <input type="email" class="form-control px-3 py-2" placeholder="alamat@email.com" required style="border-radius: 8px; background-color: var(--input-bg); color: var(--text-main); border: 1px solid var(--border-color);">
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-medium" style="color: var(--text-main);">Pesan Anda</label>
                            <textarea class="form-control px-3 py-2" rows="5" placeholder="Ketik pesan Anda di sini..." required style="border-radius: 8px; background-color: var(--input-bg); color: var(--text-main); border: 1px solid var(--border-color);"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-medium" style="border-radius: 100px; background-color: #1a73e8; border: none;">Kirim Pesan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
