<p align="center">
  <img src="public/images/icons/icon-192x192-removebg-preview.png" height="48" alt="Cakrawala Times Logo">
  <br>
  <strong>Cakrawala Times</strong>
</p>

<p align="center">
  Portal Berita Modern — Blog CMS berbasis Laravel 12 dengan arsitektur MVC
</p>

---

## Informasi UAS
- **Nama Lengkap:** Rafiq Alhariri Andriansyah
- **NIM:** 240605110178
- **Tautan Video YouTube:** [Isi dengan Link YouTube Anda di sini]

---

## Fitur

### Frontend Publik
- **Beranda** — Hero headline + grid artikel + infinite load
- **Baca Artikel** — Detail artikel lengkap dengan navigasi prev/next, artikel terkait
- **Reaksi Artikel** — 4 emosi (inspiratif/terkejut/sedih/menarik), 1x per IP
- **Pelacak Views** — Hitungan unik per session
- **Live Search** — Pencarian real-time dengan highlight + debounce
- **Filter Kategori** — Artikel per kategori
- **Profil Penulis** — Halaman publik per penulis
- **Pencarian** — Halaman hasil pencarian
- **Bookmark** — Simpan artikel via localStorage
- **Dark Mode** — Toggle tema dengan persistensi
- **Reading Progress Bar** — Indikator progres baca artikel
- **Multi Bahasa** — Indonesia / Inggris
- **PWA** — Service worker + manifest.json + offline page
- **Newsletter** — Form subscribe (simulasi)

### Admin Panel (Authenticated)
- **Dashboard** — Info penulis yang login + waktu login
- **CRUD Kategori** — Kelola kategori artikel (with delete constraint)
- **CRUD Penulis** — Kelola penulis + upload foto profil + hashing password
- **CRUD Artikel** — Kelola artikel + upload thumbnail + auto-fill penulis & tanggal

## Tech Stack

| Layer | Teknologi |
|-------|-----------|
| Backend | Laravel 12 / PHP 8.2+ |
| Database | MySQL 8.0+ (SQLite untuk dev) |
| ORM | Eloquent |
| Frontend | Bootstrap 5.3 + TailwindCSS v4 |
| Icons | Material Icons Outlined + FontAwesome 6 |
| Font | Inter + Lora (Google Fonts) |
| Build | Vite + Laravel Vite Plugin |
| Auth | Custom guard (tabel `penulis`) |
| Storage | Laravel Storage (public disk) |
| PWA | Service Worker + Manifest |

## Struktur Database

```
penulis ──┐          kategori_artikel ──┐
  │       │                │            │
  │ 1     │ N            1 │          N │
  └──► artikel ◄───────────┘
        │
        │ 1
        └──► reaksis
```

### Tabel
- **`penulis`** — `id`, `nama_lengkap`, `user_name` (unique), `password`, `foto`
- **`kategori_artikel`** — `id`, `nama_kategori`
- **`artikel`** — `id`, `judul`, `isi_artikel`, `gambar`, `tanggal`, `views`, `id_penulis` (FK), `id_kategori` (FK)
- **`reaksis`** — `id`, `artikel_id` (FK), `tipe_reaksi`, `ip_address`, timestamps

## Controller

| Controller | Tugas |
|------------|-------|
| `FrontEndController` | Semua halaman publik (home, baca, search, kategori, penulis, dll.) |
| `AuthController` | Login / Logout dengan custom guard |
| `DashboardController` | Halaman dashboard admin |
| `KategoriArtikelController` | CRUD kategori (resource) |
| `PenulisController` | CRUD penulis (resource) + upload foto + hash password |
| `ArtikelController` | CRUD artikel (resource) + upload gambar + eager loading |

## Route Utama

### Publik (tanpa auth)
| Method | URI | Deskripsi |
|--------|-----|-----------|
| GET | `/` | Beranda |
| GET | `/baca/{id}` | Detail artikel |
| GET | `/kategori-artikel/{id}` | Artikel per kategori |
| GET | `/cari` | Hasil pencarian |
| GET | `/live-search` | Live search API (JSON) |
| GET | `/penulis/{user_name}` | Profil publik penulis |
| GET | `/tentang-kami` | Halaman about |
| GET | `/redaksi` | Susunan redaksi |
| GET | `/kontak` | Halaman kontak |
| GET | `/kebijakan-privasi` | Halaman privasi |
| POST | `/artikel/{id}/reaksi` | Kirim reaksi (JSON) |
| POST | `/artikel/{id}/view` | Track view (JSON) |
| GET | `/artikel/{id}/stats` | Statistik artikel (JSON) |

### Admin (auth required)
| Method | URI | Deskripsi |
|--------|-----|-----------|
| GET | `/login` | Form login |
| POST | `/login` | Proses login |
| POST | `/logout` | Logout |
| GET | `/dashboard` | Dashboard admin |
| Resource | `/kategori` | CRUD kategori |
| Resource | `/penulis` | CRUD penulis |
| Resource | `/artikel` | CRUD artikel |

## Keamanan

- Password di-hash dengan **BCrypt**
- **CSRF Protection** di semua form
- **Middleware `auth`** melindungi semua route admin
- **Middleware `guest`** membatasi halaman login
- **Session regeneration** saat login (cegah session fixation)
- **Mass assignment protection** via `$fillable`
- **Eager loading** cegah N+1 query
- **File validation** (mimes, max) di semua upload
- **Delete constraint** — kategori/penulis dengan artikel tidak bisa dihapus
- **Logout via POST** — cegah CSRF logout

## Storage

```
storage/app/public/
├── foto/
│   ├── default.png       ← Fallback foto profil
│   └── foto_{uniqid}.ext
└── gambar/
    └── gambar_{uniqid}.ext
```

> Jalankan `php artisan storage:link` untuk akses public.

## Instalasi

```bash
git clone <repo-url>
cd aplikasi-blog
composer install
cp .env.example .env
php artisan key:generate
# Konfigurasi database di .env
php artisan migrate
php artisan storage:link
npm install && npm run build
php artisan serve
```

## Setup

```bash
composer run setup
```

## Dev

```bash
composer run dev
```

## Test

```bash
composer run test
```

## License

MIT — dibangun di atas [Laravel](https://laravel.com).
