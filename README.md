<div align="center">

<!-- Header Banner -->
<img src="public/images/icons/icon-192x192-removebg-preview.png" height="80" alt="Cakrawala Times Logo">

# CAKRAWALA TIMES

### Portal Berita Modern &mdash; Blog CMS Berbasis Laravel 12

<br>

[![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)](https://getbootstrap.com)
[![Vite](https://img.shields.io/badge/Vite-6.x-646CFF?style=for-the-badge&logo=vite&logoColor=white)](https://vitejs.dev)
[![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)](LICENSE)

<br>

<p>
  Cakrawala Times adalah aplikasi Content Management System (CMS) Blog lengkap yang dibangun menggunakan framework <strong>Laravel 12</strong> dengan arsitektur <strong>Model-View-Controller (MVC)</strong>. Aplikasi ini menyediakan sistem pengelolaan artikel, kategori, dan penulis secara penuh di sisi administrator, serta halaman publik yang elegan dan responsif untuk pengunjung umum.
</p>

</div>

---

<br>

## Informasi Pengembang

<table>
  <tr>
    <td><strong>Nama Lengkap</strong></td>
    <td>Rafiq Alhariri Andriansyah</td>
  </tr>
  <tr>
    <td><strong>NIM</strong></td>
    <td>240605110178</td>
  </tr>
  <tr>
    <td><strong>Mata Kuliah</strong></td>
    <td>Pemrograman Web</td>
  </tr>
  <tr>
    <td><strong>Tautan Video YouTube</strong></td>
    <td><a href="#">Video Demonstrasi Aplikasi</a></td>
  </tr>
</table>

---

<br>

## Daftar Isi

- [Tentang Aplikasi](#tentang-aplikasi)
- [Fitur Lengkap](#fitur-lengkap)
- [Teknologi yang Digunakan](#teknologi-yang-digunakan)
- [Arsitektur Aplikasi](#arsitektur-aplikasi)
- [Struktur Database](#struktur-database)
- [Daftar Controller](#daftar-controller)
- [Daftar Route](#daftar-route)
- [Keamanan](#keamanan)
- [Struktur Penyimpanan File](#struktur-penyimpanan-file)
- [Panduan Instalasi](#panduan-instalasi)
- [Panduan Penggunaan](#panduan-penggunaan)
- [Lisensi](#lisensi)

---

<br>

## Tentang Aplikasi

Cakrawala Times dirancang sebagai sistem manajemen konten berita yang modern dan berfitur lengkap. Aplikasi ini membedakan dua jenis pengguna secara tegas:

**1. Pengunjung (Publik)** -- Dapat mengakses seluruh halaman publik tanpa perlu melakukan login. Pengunjung dapat membaca artikel, menelusuri kategori, mencari berita, melihat profil penulis, dan memberikan reaksi terhadap artikel.

**2. Administrator / Penulis (Authenticated)** -- Pengguna yang telah login melalui halaman admin dapat mengelola seluruh konten di dalam CMS, termasuk membuat, mengedit, dan menghapus artikel, kategori, serta data penulis.

Aplikasi ini dikembangkan sebagai proyek tugas akhir semester (UAS) mata kuliah Pemrograman Web, yang merupakan pengembangan lanjutan dari CMS Blog dasar pada Modul 10 dengan penambahan halaman publik yang dapat diakses oleh pengunjung.

---

<br>

## Fitur Lengkap

### Halaman Publik (Frontend)

<table>
  <thead>
    <tr>
      <th width="40">No</th>
      <th width="220">Fitur</th>
      <th>Deskripsi</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td align="center">1</td>
      <td><strong>Halaman Beranda</strong></td>
      <td>Menampilkan hero headline artikel terbaru dengan overlay gradient, daftar artikel dengan gambar dan ringkasan konten, serta widget sidebar kategori yang menampilkan jumlah artikel per kategori. Artikel ditampilkan secara vertikal full-width dengan tombol "Baca Selengkapnya".</td>
    </tr>
    <tr>
      <td align="center">2</td>
      <td><strong>Halaman Detail Artikel</strong></td>
      <td>Menampilkan artikel secara lengkap dengan breadcrumb navigasi, gambar utama, badge kategori, judul, metadata penulis (foto, nama, tanggal publikasi), serta isi konten artikel. Di sisi kanan terdapat sidebar berisi 5 artikel terkait dari kategori yang sama.</td>
    </tr>
    <tr>
      <td align="center">3</td>
      <td><strong>Sistem Reaksi Artikel</strong></td>
      <td>Pengunjung dapat memberikan satu reaksi per artikel dari empat pilihan: Inspiratif, Terkejut, Sedih, dan Menarik. Sistem menggunakan validasi IP address untuk mencegah duplikasi serta localStorage di sisi klien untuk pengalaman pengguna yang mulus.</td>
    </tr>
    <tr>
      <td align="center">4</td>
      <td><strong>Pelacakan Jumlah Tayangan</strong></td>
      <td>Setiap artikel melacak jumlah tayangan unik berdasarkan session. Satu pengunjung hanya dihitung satu kali per session, menghasilkan statistik yang akurat.</td>
    </tr>
    <tr>
      <td align="center">5</td>
      <td><strong>Live Search (Pencarian Real-Time)</strong></td>
      <td>Fitur pencarian instan yang menampilkan hasil saat pengguna mengetik. Menggunakan mekanisme debounce 300ms untuk mengoptimalkan performa, dilengkapi highlight kata kunci pada hasil pencarian.</td>
    </tr>
    <tr>
      <td align="center">6</td>
      <td><strong>Filter Berdasarkan Kategori</strong></td>
      <td>Pengunjung dapat menyaring artikel berdasarkan kategori melalui widget sidebar. Setiap kategori menampilkan badge jumlah artikel yang tersedia, serta indikator visual untuk kategori yang sedang aktif.</td>
    </tr>
    <tr>
      <td align="center">7</td>
      <td><strong>Profil Penulis</strong></td>
      <td>Setiap penulis memiliki halaman profil publik yang menampilkan informasi penulis beserta seluruh artikel yang telah dipublikasikan oleh penulis tersebut.</td>
    </tr>
    <tr>
      <td align="center">8</td>
      <td><strong>Bookmark Artikel</strong></td>
      <td>Pengunjung dapat menyimpan artikel ke daftar bookmark menggunakan localStorage. Artikel yang tersimpan dapat diakses kapan saja melalui ikon bookmark di navigasi utama dan tersedia secara offline melalui Service Worker.</td>
    </tr>
    <tr>
      <td align="center">9</td>
      <td><strong>Dark Mode</strong></td>
      <td>Toggle pergantian tema gelap dan terang yang disimpan secara persisten di localStorage. Seluruh elemen antarmuka menyesuaikan secara otomatis dengan CSS Custom Properties.</td>
    </tr>
    <tr>
      <td align="center">10</td>
      <td><strong>Reading Progress Bar</strong></td>
      <td>Indikator progres membaca artikel yang muncul di bagian paling atas halaman, memberikan informasi visual kepada pembaca mengenai posisi scroll mereka dalam artikel.</td>
    </tr>
    <tr>
      <td align="center">11</td>
      <td><strong>Multi Bahasa</strong></td>
      <td>Dukungan internasionalisasi dengan dua bahasa: Bahasa Indonesia dan Bahasa Inggris. Pengunjung dapat beralih bahasa melalui dropdown di navigasi utama.</td>
    </tr>
    <tr>
      <td align="center">12</td>
      <td><strong>Progressive Web App (PWA)</strong></td>
      <td>Aplikasi dapat diinstal sebagai PWA dengan dukungan Service Worker untuk caching halaman dan gambar, manifest.json untuk metadata aplikasi, serta halaman offline khusus ketika tidak ada koneksi internet.</td>
    </tr>
    <tr>
      <td align="center">13</td>
      <td><strong>Newsletter</strong></td>
      <td>Formulir berlangganan newsletter dengan desain modern di bagian bawah halaman, dilengkapi notifikasi konfirmasi menggunakan SweetAlert2.</td>
    </tr>
    <tr>
      <td align="center">14</td>
      <td><strong>Infinite Load (Load More)</strong></td>
      <td>Artikel pada halaman beranda dimuat secara bertahap dengan tombol "Muat Lebih Banyak" yang mengambil data berikutnya melalui AJAX tanpa perlu memuat ulang halaman.</td>
    </tr>
    <tr>
      <td align="center">15</td>
      <td><strong>Text-to-Speech (TTS)</strong></td>
      <td>Fitur aksesibilitas yang membacakan isi artikel secara otomatis menggunakan Web Speech API. Mendukung kontrol play, pause, dan stop, dengan deteksi bahasa otomatis.</td>
    </tr>
    <tr>
      <td align="center">16</td>
      <td><strong>Pengaturan Ukuran Teks</strong></td>
      <td>Toolbar aksesibilitas yang memungkinkan pembaca memperbesar atau memperkecil ukuran font isi artikel sesuai kenyamanan mereka.</td>
    </tr>
    <tr>
      <td align="center">17</td>
      <td><strong>Berbagi ke Media Sosial</strong></td>
      <td>Tombol berbagi artikel ke berbagai platform: WhatsApp, X (Twitter), Facebook, LinkedIn, serta fitur salin tautan ke clipboard.</td>
    </tr>
  </tbody>
</table>

<br>

### Panel Administrator (Backend / CMS)

<table>
  <thead>
    <tr>
      <th width="40">No</th>
      <th width="220">Fitur</th>
      <th>Deskripsi</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td align="center">1</td>
      <td><strong>Dashboard</strong></td>
      <td>Halaman utama administrator yang menampilkan informasi penulis yang sedang login beserta waktu login. Dilengkapi tombol navigasi cepat ke fitur utama dan tautan untuk melihat website publik.</td>
    </tr>
    <tr>
      <td align="center">2</td>
      <td><strong>CRUD Kategori Artikel</strong></td>
      <td>Pengelolaan kategori artikel secara penuh: Tambah (Create), Lihat (Read), Edit (Update), dan Hapus (Delete). Kategori yang masih memiliki artikel terkait tidak dapat dihapus (delete constraint).</td>
    </tr>
    <tr>
      <td align="center">3</td>
      <td><strong>CRUD Penulis</strong></td>
      <td>Pengelolaan data penulis dengan fitur upload foto profil, hashing password otomatis menggunakan BCrypt, serta validasi username unik. Penulis yang masih memiliki artikel terkait tidak dapat dihapus.</td>
    </tr>
    <tr>
      <td align="center">4</td>
      <td><strong>CRUD Artikel</strong></td>
      <td>Pengelolaan artikel lengkap dengan editor teks, upload gambar thumbnail, auto-fill penulis berdasarkan pengguna yang login, dan auto-fill tanggal publikasi. Mendukung eager loading untuk mencegah masalah N+1 query.</td>
    </tr>
  </tbody>
</table>

---

<br>

## Teknologi yang Digunakan

<table>
  <thead>
    <tr>
      <th width="180">Kategori</th>
      <th>Teknologi</th>
      <th>Keterangan</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><strong>Backend Framework</strong></td>
      <td>Laravel 12</td>
      <td>Framework PHP modern dengan arsitektur MVC, Eloquent ORM, Blade Templating, dan ekosistem yang kaya</td>
    </tr>
    <tr>
      <td><strong>Bahasa Pemrograman</strong></td>
      <td>PHP 8.2+</td>
      <td>Versi PHP terbaru dengan dukungan fitur modern seperti named arguments, enums, dan fibers</td>
    </tr>
    <tr>
      <td><strong>Database</strong></td>
      <td>MySQL 8.0+</td>
      <td>Sistem manajemen basis data relasional untuk menyimpan seluruh data aplikasi</td>
    </tr>
    <tr>
      <td><strong>ORM</strong></td>
      <td>Eloquent</td>
      <td>Object-Relational Mapping bawaan Laravel untuk interaksi database menggunakan model PHP</td>
    </tr>
    <tr>
      <td><strong>Frontend CSS</strong></td>
      <td>Bootstrap 5.3</td>
      <td>Framework CSS responsif untuk layout, komponen, dan sistem grid</td>
    </tr>
    <tr>
      <td><strong>Ikon</strong></td>
      <td>Material Icons + FontAwesome 6</td>
      <td>Dua library ikon untuk kebutuhan antarmuka yang beragam</td>
    </tr>
    <tr>
      <td><strong>Tipografi</strong></td>
      <td>Inter + Lora</td>
      <td>Font sans-serif (Inter) untuk antarmuka dan font serif (Lora) untuk konten artikel agar nyaman dibaca</td>
    </tr>
    <tr>
      <td><strong>Build Tool</strong></td>
      <td>Vite 6.x</td>
      <td>Bundler modern untuk kompilasi aset frontend dengan hot module replacement</td>
    </tr>
    <tr>
      <td><strong>Autentikasi</strong></td>
      <td>Custom Guard</td>
      <td>Sistem autentikasi kustom menggunakan tabel penulis sebagai sumber data pengguna</td>
    </tr>
    <tr>
      <td><strong>Penyimpanan File</strong></td>
      <td>Laravel Storage</td>
      <td>Public disk untuk menyimpan foto profil penulis dan gambar thumbnail artikel</td>
    </tr>
    <tr>
      <td><strong>PWA</strong></td>
      <td>Service Worker + Manifest</td>
      <td>Dukungan Progressive Web App untuk pengalaman seperti aplikasi native</td>
    </tr>
  </tbody>
</table>

---

<br>

## Arsitektur Aplikasi

Aplikasi ini dibangun dengan arsitektur **Model-View-Controller (MVC)** yang merupakan pola desain standar pada framework Laravel:

```
                  Request
                    |
                    v
              +----------+
              |  Routes   |  --> web.php mendefinisikan seluruh URL endpoint
              +----------+
                    |
                    v
            +--------------+
            |  Middleware   |  --> auth, guest, csrf, language
            +--------------+
                    |
                    v
            +--------------+
            |  Controller  |  --> Logika bisnis dan pengolahan data
            +--------------+
               /        \
              v          v
        +-------+   +------+
        | Model |   | View |
        +-------+   +------+
            |            |
            v            v
       Database     Blade Template
       (MySQL)       (HTML + CSS)
```

**Penjelasan Alur:**

1. **Request** masuk melalui browser pengguna
2. **Routes** (`web.php`) mencocokkan URL dengan controller yang sesuai
3. **Middleware** melakukan pengecekan (autentikasi, CSRF, bahasa)
4. **Controller** memproses logika bisnis, berinteraksi dengan Model untuk data
5. **Model** berkomunikasi dengan database menggunakan Eloquent ORM
6. **View** (Blade Template) merender data menjadi halaman HTML yang dikembalikan ke browser

---

<br>

## Struktur Database

Aplikasi ini menggunakan empat tabel utama yang saling berelasi:

```
  penulis ──────────┐          kategori_artikel ──────────┐
    |                |                  |                   |
    | (Primary Key)  | (Foreign Key)    | (Primary Key)     | (Foreign Key)
    |     1          |       N          |      1            |       N
    └────────────► artikel ◄────────────┘
                     |
                     | (Primary Key)
                     |      1
                     |      N
                     └────────────► reaksis
```

<br>

### Detail Tabel

<table>
  <thead>
    <tr>
      <th width="180">Nama Tabel</th>
      <th>Kolom</th>
      <th>Keterangan</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><strong>penulis</strong></td>
      <td><code>id</code>, <code>nama_lengkap</code>, <code>user_name</code> (unique), <code>password</code>, <code>foto</code></td>
      <td>Menyimpan data penulis/administrator yang dapat login ke panel admin</td>
    </tr>
    <tr>
      <td><strong>kategori_artikel</strong></td>
      <td><code>id</code>, <code>nama_kategori</code></td>
      <td>Menyimpan daftar kategori untuk mengelompokkan artikel</td>
    </tr>
    <tr>
      <td><strong>artikel</strong></td>
      <td><code>id</code>, <code>judul</code>, <code>isi_artikel</code>, <code>gambar</code>, <code>tanggal</code>, <code>views</code>, <code>id_penulis</code> (FK), <code>id_kategori</code> (FK)</td>
      <td>Menyimpan konten artikel beserta relasi ke penulis dan kategori</td>
    </tr>
    <tr>
      <td><strong>reaksis</strong></td>
      <td><code>id</code>, <code>artikel_id</code> (FK), <code>tipe_reaksi</code>, <code>ip_address</code>, <code>timestamps</code></td>
      <td>Menyimpan data reaksi pengunjung terhadap artikel, dibatasi satu reaksi per IP per artikel</td>
    </tr>
  </tbody>
</table>

### Relasi Antar Tabel

| Relasi | Tipe | Penjelasan |
|--------|------|------------|
| Penulis → Artikel | One to Many | Satu penulis dapat menulis banyak artikel |
| Kategori → Artikel | One to Many | Satu kategori dapat memiliki banyak artikel |
| Artikel → Reaksi | One to Many | Satu artikel dapat memiliki banyak reaksi |

---

<br>

## Daftar Controller

<table>
  <thead>
    <tr>
      <th width="260">Controller</th>
      <th>Tanggung Jawab</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><code>FrontEndController</code></td>
      <td>Menangani seluruh halaman publik: beranda, detail artikel, pencarian, filter kategori, profil penulis, halaman statis (tentang kami, redaksi, kontak, kebijakan privasi), serta endpoint API untuk reaksi, view tracking, dan live search</td>
    </tr>
    <tr>
      <td><code>AuthController</code></td>
      <td>Menangani proses autentikasi: menampilkan form login, memproses login dengan custom guard, dan melakukan logout dengan regenerasi session</td>
    </tr>
    <tr>
      <td><code>DashboardController</code></td>
      <td>Menampilkan halaman dashboard administrator setelah berhasil login</td>
    </tr>
    <tr>
      <td><code>KategoriArtikelController</code></td>
      <td>Resource controller untuk operasi CRUD kategori artikel dengan validasi delete constraint</td>
    </tr>
    <tr>
      <td><code>PenulisController</code></td>
      <td>Resource controller untuk operasi CRUD penulis dengan fitur upload foto profil dan hashing password otomatis</td>
    </tr>
    <tr>
      <td><code>ArtikelController</code></td>
      <td>Resource controller untuk operasi CRUD artikel dengan upload gambar thumbnail, auto-fill penulis, dan eager loading relasi</td>
    </tr>
  </tbody>
</table>

---

<br>

## Daftar Route

### Route Publik (Tanpa Autentikasi)

<table>
  <thead>
    <tr>
      <th width="80">Method</th>
      <th width="260">URI</th>
      <th>Deskripsi</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><code>GET</code></td>
      <td><code>/</code></td>
      <td>Halaman beranda dengan hero headline, daftar artikel, dan sidebar kategori</td>
    </tr>
    <tr>
      <td><code>GET</code></td>
      <td><code>/baca/{id}</code></td>
      <td>Halaman detail artikel dengan konten lengkap dan artikel terkait di sidebar</td>
    </tr>
    <tr>
      <td><code>GET</code></td>
      <td><code>/kategori-artikel/{id}</code></td>
      <td>Halaman artikel yang difilter berdasarkan kategori tertentu</td>
    </tr>
    <tr>
      <td><code>GET</code></td>
      <td><code>/cari</code></td>
      <td>Halaman hasil pencarian artikel berdasarkan kata kunci</td>
    </tr>
    <tr>
      <td><code>GET</code></td>
      <td><code>/live-search</code></td>
      <td>Endpoint API (JSON) untuk fitur pencarian real-time</td>
    </tr>
    <tr>
      <td><code>GET</code></td>
      <td><code>/penulis/{user_name}</code></td>
      <td>Halaman profil publik penulis beserta daftar artikelnya</td>
    </tr>
    <tr>
      <td><code>GET</code></td>
      <td><code>/tentang-kami</code></td>
      <td>Halaman informasi tentang Cakrawala Times</td>
    </tr>
    <tr>
      <td><code>GET</code></td>
      <td><code>/redaksi</code></td>
      <td>Halaman susunan redaksi / daftar penulis</td>
    </tr>
    <tr>
      <td><code>GET</code></td>
      <td><code>/kontak</code></td>
      <td>Halaman informasi kontak</td>
    </tr>
    <tr>
      <td><code>GET</code></td>
      <td><code>/kebijakan-privasi</code></td>
      <td>Halaman kebijakan privasi</td>
    </tr>
    <tr>
      <td><code>POST</code></td>
      <td><code>/artikel/{id}/reaksi</code></td>
      <td>Endpoint API (JSON) untuk mengirim reaksi terhadap artikel</td>
    </tr>
    <tr>
      <td><code>POST</code></td>
      <td><code>/artikel/{id}/view</code></td>
      <td>Endpoint API (JSON) untuk melacak jumlah tayangan artikel</td>
    </tr>
    <tr>
      <td><code>GET</code></td>
      <td><code>/artikel/{id}/stats</code></td>
      <td>Endpoint API (JSON) untuk mengambil statistik artikel secara real-time</td>
    </tr>
  </tbody>
</table>

<br>

### Route Administrator (Memerlukan Autentikasi)

<table>
  <thead>
    <tr>
      <th width="80">Method</th>
      <th width="260">URI</th>
      <th>Deskripsi</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><code>GET</code></td>
      <td><code>/login</code></td>
      <td>Menampilkan halaman form login</td>
    </tr>
    <tr>
      <td><code>POST</code></td>
      <td><code>/login</code></td>
      <td>Memproses kredensial login</td>
    </tr>
    <tr>
      <td><code>POST</code></td>
      <td><code>/logout</code></td>
      <td>Memproses logout dan menghapus session</td>
    </tr>
    <tr>
      <td><code>GET</code></td>
      <td><code>/dashboard</code></td>
      <td>Halaman utama panel administrator</td>
    </tr>
    <tr>
      <td><code>Resource</code></td>
      <td><code>/kategori</code></td>
      <td>CRUD lengkap untuk pengelolaan kategori artikel (index, create, store, edit, update, destroy)</td>
    </tr>
    <tr>
      <td><code>Resource</code></td>
      <td><code>/penulis</code></td>
      <td>CRUD lengkap untuk pengelolaan data penulis (index, create, store, edit, update, destroy)</td>
    </tr>
    <tr>
      <td><code>Resource</code></td>
      <td><code>/artikel</code></td>
      <td>CRUD lengkap untuk pengelolaan artikel (index, create, store, edit, update, destroy)</td>
    </tr>
  </tbody>
</table>

---

<br>

## Keamanan

Aplikasi ini menerapkan beberapa lapisan keamanan untuk melindungi data dan mencegah serangan:

| Aspek Keamanan | Implementasi |
|----------------|--------------|
| **Enkripsi Password** | Seluruh password di-hash menggunakan algoritma BCrypt sebelum disimpan ke database |
| **CSRF Protection** | Setiap form POST dilindungi oleh token CSRF bawaan Laravel untuk mencegah serangan Cross-Site Request Forgery |
| **Middleware Auth** | Seluruh route panel administrator dilindungi middleware `auth` sehingga hanya pengguna yang sudah login yang dapat mengakses |
| **Middleware Guest** | Halaman login dibatasi dengan middleware `guest` agar pengguna yang sudah login dialihkan ke dashboard |
| **Session Regeneration** | Session di-regenerasi setiap kali login berhasil untuk mencegah serangan session fixation |
| **Mass Assignment Protection** | Setiap model mendefinisikan properti `$fillable` untuk mencegah mass assignment vulnerability |
| **Eager Loading** | Penggunaan eager loading pada query Eloquent untuk mencegah masalah N+1 query yang dapat menurunkan performa |
| **Validasi Upload File** | Setiap file yang diunggah divalidasi berdasarkan tipe MIME dan ukuran maksimum yang diizinkan |
| **Delete Constraint** | Kategori dan penulis yang masih memiliki artikel terkait tidak dapat dihapus untuk menjaga integritas data |
| **Logout via POST** | Proses logout hanya dapat dilakukan melalui method POST untuk mencegah serangan CSRF logout |

---

<br>

## Struktur Penyimpanan File

```
storage/app/public/
|
|-- foto/
|   |-- default.png            <-- Foto profil default (fallback)
|   |-- foto_{unique_id}.jpg   <-- Foto profil penulis yang diunggah
|   |-- foto_{unique_id}.png
|
|-- gambar/
|   |-- gambar_{unique_id}.jpg <-- Gambar thumbnail artikel yang diunggah
|   |-- gambar_{unique_id}.png
```

> **Catatan Penting:** Setelah instalasi, jalankan perintah `php artisan storage:link` untuk membuat symbolic link dari `public/storage` ke `storage/app/public`. Tanpa langkah ini, file yang diunggah tidak akan dapat diakses melalui browser.

---

<br>

## Panduan Instalasi

Berikut adalah langkah-langkah lengkap untuk menjalankan aplikasi ini di lingkungan lokal Anda.

### Prasyarat

Pastikan perangkat lunak berikut sudah terinstal di komputer Anda:

- **PHP** versi 8.2 atau lebih baru
- **Composer** (dependency manager untuk PHP)
- **Node.js** versi 18 atau lebih baru beserta npm
- **MySQL** versi 8.0 atau lebih baru (atau MariaDB)
- **Git** untuk melakukan clone repositori
- **XAMPP / Laragon / Herd** (opsional, untuk kemudahan manajemen server lokal)

### Langkah 1: Clone Repositori

```bash
git clone https://github.com/Rafiqalha/aplikasi-blog-240605110178.git
cd aplikasi-blog-240605110178
```

### Langkah 2: Instal Dependensi PHP

```bash
composer install
```

### Langkah 3: Konfigurasi Environment

Salin file konfigurasi contoh dan generate application key:

```bash
cp .env.example .env
php artisan key:generate
```

### Langkah 4: Konfigurasi Database

Buka file `.env` dengan text editor dan sesuaikan konfigurasi database berikut:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=aplikasi_blog
DB_USERNAME=root
DB_PASSWORD=
```

> **Catatan:** Pastikan Anda sudah membuat database dengan nama `aplikasi_blog` di MySQL sebelum melanjutkan ke langkah berikutnya.

### Langkah 5: Migrasi Database

Jalankan migrasi untuk membuat seluruh tabel yang dibutuhkan:

```bash
php artisan migrate
```

### Langkah 6: Buat Symbolic Link Storage

```bash
php artisan storage:link
```

### Langkah 7: Instal Dependensi Frontend dan Build Aset

```bash
npm install
npm run build
```

### Langkah 8: Jalankan Server Pengembangan

```bash
php artisan serve
```

Aplikasi akan berjalan di `http://127.0.0.1:8000`. Buka alamat tersebut di browser untuk mengakses halaman publik.

### Perintah Alternatif (Shortcut)

Jika tersedia, Anda juga dapat menggunakan perintah berikut:

```bash
# Setup awal (otomatis menjalankan langkah 2-7)
composer run setup

# Menjalankan server pengembangan
composer run dev

# Menjalankan test
composer run test
```

---

<br>

## Panduan Penggunaan

### Alur Pengunjung (Publik)

1. Buka halaman utama di `http://127.0.0.1:8000`
2. Lihat artikel terbaru yang ditampilkan di beranda dengan hero headline
3. Gunakan sidebar "Kategori Artikel" di sebelah kanan untuk menyaring artikel berdasarkan kategori
4. Klik tombol "Baca Selengkapnya" pada artikel untuk membuka halaman detail
5. Di halaman detail, baca isi artikel secara lengkap
6. Lihat 5 artikel terkait dari kategori yang sama di sidebar kanan
7. Berikan reaksi terhadap artikel (Inspiratif, Terkejut, Sedih, atau Menarik)
8. Klik salah satu artikel terkait untuk melanjutkan membaca
9. Gunakan fitur pencarian di navigasi atas untuk mencari artikel berdasarkan kata kunci
10. Kembali ke beranda menggunakan tombol "Kembali ke Beranda" atau klik logo di navigasi

### Alur Administrator (CMS)

1. Akses halaman login di `http://127.0.0.1:8000/login`
2. Masukkan username dan password yang terdaftar
3. Setelah login, Anda akan diarahkan ke halaman Dashboard
4. Gunakan sidebar navigasi untuk mengakses menu:
   - **Kategori** -- Tambah, edit, atau hapus kategori artikel
   - **Penulis** -- Tambah penulis baru, edit data, atau hapus penulis
   - **Artikel** -- Buat artikel baru, edit konten, atau hapus artikel
5. Untuk membuat artikel baru, pilih menu Artikel lalu klik tombol Tambah
6. Isi judul, pilih kategori, tulis konten, dan unggah gambar thumbnail
7. Klik tombol "Lihat Website" di sidebar untuk melihat tampilan publik dari website

---

<br>

## Lisensi

Proyek ini dilisensikan di bawah [MIT License](https://opensource.org/licenses/MIT) dan dibangun di atas framework [Laravel](https://laravel.com).

---

<div align="center">
  <br>
  <p>
    <strong>Cakrawala Times</strong> &mdash; Dibangun dengan Laravel 12
  </p>
  <p>
    <sub>Dikembangkan oleh Rafiq Alhariri Andriansyah (240605110178) sebagai proyek UAS Pemrograman Web</sub>
  </p>
</div>
