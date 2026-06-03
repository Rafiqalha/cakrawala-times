@extends('frontend.layout')

@section('title', 'Kebijakan Privasi - Cakrawala Times')

@section('content')
<div class="container py-5">
    <div style="max-width: 800px; margin: 0 auto; background-color: var(--bg-surface); color: var(--text-main); padding: 40px; border-radius: 16px; box-shadow: var(--card-shadow);">
        <h1 class="fw-bold mb-4">Kebijakan Privasi</h1>
        <p class="text-muted mb-4">Pembaruan Terakhir: {{ date('d M Y') }}</p>

        <div style="font-size: 1rem; line-height: 1.8; color: var(--text-main);">
            <p>Selamat datang di <strong>Cakrawala Times</strong>. Kami menghargai privasi Anda dan berkomitmen untuk melindungi data pribadi Anda. Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi informasi saat Anda mengunjungi situs web kami.</p>

            <h4 class="fw-bold mt-4 mb-3" style="color: var(--text-main);">1. Informasi yang Kami Kumpulkan</h4>
            <p>Kami dapat mengumpulkan informasi non-pribadi seperti jenis peramban (browser), alamat IP, dan data analitik kunjungan secara anonim menggunakan *cookies* untuk meningkatkan pengalaman pengguna.</p>

            <h4 class="fw-bold mt-4 mb-3" style="color: var(--text-main);">2. Penggunaan Informasi</h4>
            <p>Informasi yang kami kumpulkan digunakan secara eksklusif untuk memahami tren membaca, mengoptimalkan kecepatan muat halaman, dan menampilkan konten yang lebih relevan.</p>

            <h4 class="fw-bold mt-4 mb-3" style="color: var(--text-main);">3. Keamanan Data</h4>
            <p>Kami menerapkan prosedur keamanan standar industri untuk melindungi situs kami dari akses tidak sah. Namun, perlu diingat bahwa tidak ada transmisi data di internet yang 100% aman.</p>

            <h4 class="fw-bold mt-4 mb-3" style="color: var(--text-main);">4. Perubahan Kebijakan</h4>
            <p>Kami dapat memperbarui kebijakan ini dari waktu ke waktu. Setiap perubahan akan diumumkan di halaman ini secara transparan.</p>

            <p class="mt-5">Jika Anda memiliki pertanyaan mengenai kebijakan privasi ini, silakan hubungi kami melalui <a href="{{ route('contact') }}" style="color: #1a73e8; text-decoration: none;">Halaman Kontak</a>.</p>
        </div>
    </div>
</div>
@endsection
