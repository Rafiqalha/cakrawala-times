# 📄 Product Requirements Document (PRD)
## Sistem Manajemen Konten (CMS) Blog — Laravel 11 MVC

---

| Atribut         | Detail                                        |
|-----------------|-----------------------------------------------|
| **Versi**       | 1.0.0                                         |
| **Status**      | Draft — Siap Review                           |
| **Dibuat oleh** | Tim Product & Architecture                    |
| **Terakhir diperbarui** | 2025                                  |
| **Framework**   | Laravel 11 / PHP 8.2+                        |
| **Tipe Proyek** | Transisi PHP Prosedural → MVC Framework       |

---

## Daftar Isi

1. [Ringkasan Produk](#1-ringkasan-produk)
2. [Latar Belakang & Masalah](#2-latar-belakang--masalah)
3. [Tujuan & Sasaran](#3-tujuan--sasaran)
4. [Ruang Lingkup Proyek](#4-ruang-lingkup-proyek)
5. [Pengguna & Peran](#5-pengguna--peran)
6. [User Stories](#6-user-stories)
7. [Alur Aplikasi (Flow)](#7-alur-aplikasi-flow)
8. [Tech Stack & Arsitektur Sistem](#8-tech-stack--arsitektur-sistem)
9. [Sistem Autentikasi & Keamanan](#9-sistem-autentikasi--keamanan)
10. [Kebutuhan Fungsional — Modul Dashboard](#10-kebutuhan-fungsional--modul-dashboard)
11. [Kebutuhan Fungsional — Operasi CRUD](#11-kebutuhan-fungsional--operasi-crud)
12. [Kebutuhan Non-Fungsional](#12-kebutuhan-non-fungsional)
13. [Struktur Database & Relasi Eloquent](#13-struktur-database--relasi-eloquent)
14. [Standar Koding & Konvensi](#14-standar-koding--konvensi)
15. [Manajemen File & Storage](#15-manajemen-file--storage)
16. [Batasan & Asumsi](#16-batasan--asumsi)
17. [Kriteria Keberhasilan (Definition of Done)](#17-kriteria-keberhasilan-definition-of-done)
18. [Glosarium](#18-glosarium)

---

## 1. Ringkasan Produk

**Blog CMS** adalah aplikasi web berbasis **Laravel 11** yang memungkinkan tim editorial untuk mengelola konten blog secara terstruktur — mulai dari manajemen penulis, kategori artikel, hingga publikasi artikel lengkap dengan thumbnail gambar.

Proyek ini merupakan **langkah modernisasi** dari pendekatan PHP prosedural menuju arsitektur framework yang terstruktur, mengadopsi pola **MVC (Model-View-Controller)** sebagai fondasi utama. Tujuannya bukan sekadar membangun fitur, tetapi menanamkan praktik engineering yang maintainable dan scalable.

> **Tagline:** *"Dari spaghetti code menuju arsitektur yang bersih dan terstruktur."*

---

## 2. Latar Belakang & Masalah

### 2.1 Kondisi Saat Ini
Sistem pengelolaan konten blog sebelumnya dibangun dengan **PHP prosedural** tanpa struktur yang jelas. Hal ini menyebabkan:

- **Duplikasi logika** di berbagai file PHP
- **Zero separation of concerns** — SQL query, logika bisnis, dan HTML tercampur
- **Tidak ada proteksi keamanan** yang terstandarisasi (CSRF, hashing password, dll.)
- **Sulit di-maintain** — perubahan satu fitur berdampak ke file lain
- **Tidak ada form validation** yang konsisten
- **Manajemen file upload** yang tidak terorganisir

### 2.2 Dampak Bisnis
Kondisi tersebut menyebabkan produktivitas developer rendah, bug sulit ditelusuri, dan risiko keamanan yang tidak terkontrol pada data penulis maupun konten artikel.

---

## 3. Tujuan & Sasaran

### 3.1 Tujuan Bisnis
- Membangun sistem CMS yang fungsional dan dapat digunakan tim editorial secara mandiri
- Memberikan dasar arsitektur yang solid untuk pengembangan fitur selanjutnya

### 3.2 Tujuan Teknis

| No | Tujuan Teknis | Indikator Sukses |
|----|---------------|------------------|
| T1 | Mengimplementasikan pola MVC secara konsisten | Tidak ada logika bisnis di View, tidak ada query di Controller |
| T2 | Autentikasi kustom dengan tabel `penulis` | Login berhasil tanpa tabel `users` default Laravel |
| T3 | CRUD lengkap untuk 3 modul (Kategori, Penulis, Artikel) | Semua operasi CRUD berjalan tanpa error |
| T4 | File upload terorganisir via Laravel Storage | File tersimpan di folder yang benar, nama unik |
| T5 | Proteksi akses dengan Middleware | Halaman terproteksi tidak bisa diakses tanpa login |
| T6 | Mencegah N+1 Query Problem pada listing | Semua query listing menggunakan Eager Loading |

---

## 4. Ruang Lingkup Proyek

### 4.1 Dalam Lingkup (In Scope)
- ✅ Sistem autentikasi kustom (login, logout, session)
- ✅ Dashboard dengan informasi pengguna dan waktu login
- ✅ CRUD Kategori Artikel
- ✅ CRUD Penulis (dengan upload foto profil)
- ✅ CRUD Artikel (dengan upload thumbnail, relasi penulis & kategori)
- ✅ Proteksi akses berbasis middleware
- ✅ Validasi form sisi server
- ✅ Flash message notifikasi (sukses/gagal)
- ✅ Sidebar navigasi dinamis dengan indikator aktif

### 4.2 Di Luar Lingkup (Out of Scope)
- ❌ Halaman blog publik (frontend untuk pembaca)
- ❌ Sistem komentar artikel
- ❌ Multi-role / izin berbasis peran (RBAC)
- ❌ API RESTful (JSON response)
- ❌ Fitur pencarian dan filter artikel
- ❌ Sistem notifikasi email
- ❌ Pagination (dapat ditambahkan di versi selanjutnya)

---

## 5. Pengguna & Peran

Aplikasi ini memiliki **satu jenis pengguna** pada versi 1.0:

| Peran | Deskripsi | Akses |
|-------|-----------|-------|
| **Penulis (Admin)** | Pengguna terdaftar yang dapat login dan mengelola seluruh konten | Full access: Dashboard, Kategori, Penulis, Artikel |

> **Catatan:** Pendaftaran akun Penulis dilakukan secara manual melalui modul manajemen Penulis oleh pengguna yang sudah login. Tidak ada halaman registrasi publik.

---

## 6. User Stories

### 6.1 Autentikasi

| ID | Sebagai... | Saya ingin... | Sehingga... |
|----|-----------|---------------|-------------|
| US-01 | Penulis | Login menggunakan `user_name` dan `password` | Saya dapat mengakses area manajemen |
| US-02 | Penulis yang sudah login | Di-redirect ke dashboard saat membuka halaman login | Saya tidak perlu login ulang |
| US-03 | Penulis | Logout dengan aman | Sesi saya berakhir dan data aman |

### 6.2 Dashboard

| ID | Sebagai... | Saya ingin... | Sehingga... |
|----|-----------|---------------|-------------|
| US-04 | Penulis | Melihat nama lengkap dan foto profil saya | Saya tahu akun siapa yang aktif |
| US-05 | Penulis | Melihat waktu login saya (hari, tanggal, jam) | Saya dapat memantau aktivitas login |

### 6.3 Manajemen Kategori

| ID | Sebagai... | Saya ingin... | Sehingga... |
|----|-----------|---------------|-------------|
| US-06 | Penulis | Menambah kategori baru | Artikel dapat dikategorikan |
| US-07 | Penulis | Mengedit nama kategori | Kategorisasi tetap akurat |
| US-08 | Penulis | Menghapus kategori yang tidak digunakan | Data tetap bersih |
| US-09 | Penulis | Mendapat peringatan saat menghapus kategori yang masih dipakai | Integritas data terjaga |

### 6.4 Manajemen Penulis

| ID | Sebagai... | Saya ingin... | Sehingga... |
|----|-----------|---------------|-------------|
| US-10 | Penulis | Menambah akun penulis baru | Tim editorial dapat bertambah |
| US-11 | Penulis | Mengunggah foto profil saat membuat/edit akun | Profil lebih personal |
| US-12 | Penulis | Mengubah password saat edit (opsional) | Password dapat diperbarui jika diperlukan |
| US-13 | Penulis | Menghapus penulis beserta file fotonya | Tidak ada file orphan di storage |

### 6.5 Manajemen Artikel

| ID | Sebagai... | Saya ingin... | Sehingga... |
|----|-----------|---------------|-------------|
| US-14 | Penulis | Membuat artikel baru dengan memilih kategori | Artikel terorganisir |
| US-15 | Penulis | Mengunggah gambar thumbnail artikel | Artikel lebih menarik secara visual |
| US-16 | Penulis | Sistem otomatis mengisi nama penulis saya | Tidak perlu input manual yang rawan kesalahan |
| US-17 | Penulis | Sistem otomatis mengisi tanggal publish | Tidak perlu input manual |
| US-18 | Penulis | Menghapus artikel dan gambarnya terhapus otomatis | Storage tetap bersih |

---

## 7. Alur Aplikasi (Flow)

```
[Guest]
   │
   ▼
[Halaman Login]  ←─── middleware: guest (redirect ke /dashboard jika sudah login)
   │
   │ POST /login (user_name + password)
   ▼
[Autentikasi] ─── Gagal ──→ [Login + Flash Error]
   │
   │ Berhasil → Simpan waktu login ke Session
   ▼
[Dashboard] ←─── middleware: auth (redirect ke /login jika belum login)
   │
   ├──→ [Manajemen Kategori] → index / create / store / edit / update / destroy
   │
   ├──→ [Manajemen Penulis]  → index / create / store / edit / update / destroy
   │
   └──→ [Manajemen Artikel]  → index / create / store / edit / update / destroy
         │
         └─ Setiap operasi menggunakan pola PRG:
            POST/PUT/DELETE → Proses → Redirect → GET (dengan Flash Message)
```

---

## 8. Tech Stack & Arsitektur Sistem

### 8.1 Ringkasan Tech Stack

| Layer | Teknologi | Versi | Keterangan |
|-------|-----------|-------|------------|
| **Backend Framework** | Laravel | 11.x | Core framework |
| **Runtime** | PHP | 8.2+ | Minimum requirement |
| **ORM** | Eloquent | (bundled) | Query builder & relasi |
| **Database** | MySQL | 8.0+ | Penyimpanan data utama |
| **Frontend** | Bootstrap | 5.x | CSS framework |
| **Template Engine** | Blade | (bundled) | View layer Laravel |
| **Web Server** | Apache / Nginx | — | Production server |

---

### 8.2 Pola Arsitektur: MVC

Aplikasi mengimplementasikan **MVC (Model-View-Controller)** secara ketat. Setiap layer memiliki tanggung jawab yang terdefinisi dan **tidak boleh dilanggar**.

```
┌─────────────────────────────────────────────────────────┐
│                    HTTP REQUEST                         │
└──────────────────────┬──────────────────────────────────┘
                       │
                       ▼
┌─────────────────────────────────────────────────────────┐
│                  ROUTING LAYER                          │
│          routes/web.php  (RESTful Resource Routes)      │
└──────────────────────┬──────────────────────────────────┘
                       │
                       ▼
┌─────────────────────────────────────────────────────────┐
│                MIDDLEWARE LAYER                         │
│         auth  ←──────────────────→  guest              │
│   (protect dashboard/CRUD)    (protect login page)     │
└──────────────────────┬──────────────────────────────────┘
                       │
                       ▼
┌─────────────────────────────────────────────────────────┐
│              CONTROLLER LAYER  (C)                      │
│  • Menerima HTTP request                                │
│  • Menjalankan validasi form                            │
│  • Memanggil Model untuk operasi data                   │
│  • Menangani logika file upload                         │
│  • Mengembalikan View atau Redirect + Flash             │
│                                                         │
│  AuthController  │  KategoriController                 │
│  PenulisController  │  ArtikelController                │
└───────┬──────────────────────────┬──────────────────────┘
        │                          │
        ▼                          ▼
┌───────────────┐       ┌──────────────────────┐
│  MODEL LAYER  │       │     VIEW LAYER  (V)  │
│     (M)       │       │                      │
│  Eloquent ORM │       │  Blade Templates     │
│  • Penulis    │       │  @extends(layout)    │
│  • Kategori   │       │  @section(content)   │
│  • Artikel    │       │  Bootstrap 5 UI      │
│  Relationships│       │  @yield untuk slot   │
│  $fillable    │       │                      │
│  $timestamps  │       │                      │
└───────┬───────┘       └──────────────────────┘
        │
        ▼
┌───────────────┐
│   DATABASE    │
│   MySQL       │
│   penulis     │
│   kategori    │
│   artikel     │
└───────────────┘
```

---

### 8.3 Struktur Direktori (Relevan)

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── AuthController.php
│   │   ├── DashboardController.php
│   │   ├── KategoriArtikelController.php
│   │   ├── PenulisController.php
│   │   └── ArtikelController.php
│   └── Middleware/               (auth & guest sudah tersedia di Laravel)
├── Models/
│   ├── Penulis.php
│   ├── KategoriArtikel.php
│   └── Artikel.php
resources/
└── views/
    ├── layouts/
    │   └── app.blade.php         (master layout: navbar + sidebar + yield)
    ├── auth/
    │   └── login.blade.php
    ├── dashboard/
    │   └── index.blade.php
    ├── kategori/
    │   ├── index.blade.php
    │   ├── create.blade.php
    │   └── edit.blade.php
    ├── penulis/
    │   ├── index.blade.php
    │   ├── create.blade.php
    │   └── edit.blade.php
    └── artikel/
        ├── index.blade.php
        ├── create.blade.php
        └── edit.blade.php
routes/
└── web.php
storage/
└── app/public/
    ├── foto/                     (foto profil penulis)
    └── gambar/                   (thumbnail artikel)
```

---

### 8.4 Routing Strategy

Seluruh route modul menggunakan **Laravel Resource Routing** kecuali autentikasi:

```php
// routes/web.php

// Auth
Route::get('/login', [AuthController::class, 'showLoginForm'])->middleware('guest')->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('kategori', KategoriArtikelController::class);
    Route::resource('penulis', PenulisController::class);
    Route::resource('artikel', ArtikelController::class);
});
```

**Mapping HTTP Verb → Method Controller (Resource):**

| HTTP Verb | URI | Method | Fungsi |
|-----------|-----|--------|--------|
| GET | `/kategori` | `index` | Tampil semua data |
| GET | `/kategori/create` | `create` | Form tambah |
| POST | `/kategori` | `store` | Simpan data baru |
| GET | `/kategori/{id}/edit` | `edit` | Form edit |
| PUT/PATCH | `/kategori/{id}` | `update` | Update data |
| DELETE | `/kategori/{id}` | `destroy` | Hapus data |

*(Pola yang sama berlaku untuk `penulis` dan `artikel`)*

---

### 8.5 Layout Blade (Master Template)

Semua halaman menggunakan satu **master layout** (`layouts/app.blade.php`) dengan blok `@yield`:

```blade
{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <title>@yield('title', 'Blog CMS')</title>
    <!-- Bootstrap 5 CSS -->
</head>
<body>
    @include('partials.navbar')
    <div class="container-fluid">
        <div class="row">
            @include('partials.sidebar')     {{-- Sidebar dinamis --}}
            <main class="col-md-9">
                @yield('content')            {{-- Konten halaman --}}
            </main>
        </div>
    </div>
    <!-- Bootstrap 5 JS -->
    @stack('scripts')
</body>
</html>
```

```blade
{{-- Contoh child view --}}
@extends('layouts.app')

@section('title', 'Manajemen Artikel')

@section('content')
    {{-- Konten spesifik halaman --}}
@endsection
```

---

## 9. Sistem Autentikasi & Keamanan

### 9.1 Custom Authentication Guard

Sistem autentikasi **TIDAK** menggunakan tabel `users` default Laravel. Seluruh autentikasi menggunakan tabel **`penulis`** dengan identifier kustom.

**Konfigurasi `config/auth.php`:**

```php
'guards' => [
    'web' => [
        'driver'   => 'session',
        'provider' => 'penulis',
    ],
],

'providers' => [
    'penulis' => [
        'driver' => 'eloquent',
        'model'  => App\Models\Penulis::class,
    ],
],
```

**Model `Penulis` harus mengimplementasikan:**

```php
use Illuminate\Foundation\Auth\User as Authenticatable;

class Penulis extends Authenticatable
{
    protected $table = 'penulis';

    // Override identifier default ('email') ke 'user_name'
    public function getAuthIdentifierName(): string
    {
        return 'user_name';  // Field yang digunakan sebagai username
    }
}
```

---

### 9.2 Hashing Password (BCrypt)

- Password penulis **wajib** di-hash menggunakan `bcrypt()` atau `Hash::make()` saat **Create** dan **Update** (jika password baru diisi)
- Verifikasi menggunakan `Hash::check()` atau `Auth::attempt()`
- Password dalam database **tidak pernah** disimpan dalam bentuk plaintext

```php
// Saat menyimpan password baru
'password' => bcrypt($request->password)

// Saat login
Auth::attempt([
    'user_name' => $request->user_name,
    'password'  => $request->password,
])
```

---

### 9.3 Middleware Protection

| Middleware | Tipe Proteksi | Diterapkan pada | Behavior jika Gagal |
|------------|---------------|-----------------|---------------------|
| `auth` | Wajib login | Dashboard, semua CRUD | Redirect → `/login` |
| `guest` | Wajib belum login | Halaman Login | Redirect → `/dashboard` |

---

### 9.4 Session Management — Waktu Login

Saat login berhasil, **waktu login disimpan ke session** dan ditampilkan di dashboard:

```php
// AuthController@login — setelah Auth::attempt() berhasil
session(['login_time' => now()->timezone('Asia/Jakarta')->format('l, d F Y — H:i:s')]);

// DashboardController@index
$loginTime = session('login_time');
return view('dashboard.index', compact('loginTime'));
```

**Format waktu login yang ditampilkan:** `Senin, 01 Januari 2025 — 09:30:45 WIB`

---

### 9.5 Logout (HTTP POST — Anti-CSRF)

Logout **wajib** menggunakan **HTTP POST**, bukan GET. Ini mencegah serangan CSRF-based logout:

```blade
{{-- Di sidebar/navbar --}}
<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-outline-danger">Logout</button>
</form>
```

---

### 9.6 CSRF Protection

- Semua form yang mengirim data (POST/PUT/PATCH/DELETE) **wajib** menyertakan `@csrf`
- Method spoofing untuk PUT/PATCH/DELETE menggunakan `@method('PUT')` / `@method('DELETE')`

---

## 10. Kebutuhan Fungsional — Modul Dashboard

### 10.1 Halaman Dashboard

**Route:** `GET /dashboard`  
**Middleware:** `auth`  
**View:** `dashboard/index.blade.php`

#### Komponen yang Wajib Ditampilkan:

| Komponen | Sumber Data | Fallback |
|----------|-------------|----------|
| Sapaan + nama lengkap | `Auth::user()->nama_lengkap` | — |
| Foto profil | `Auth::user()->foto` | `default.png` |
| Waktu login | `session('login_time')` | — |

#### Contoh implementasi foto profil dengan fallback:

```blade
@php
    $foto = Auth::user()->foto ? Auth::user()->foto : 'default.png';
@endphp
<img src="{{ asset('storage/foto/' . $foto) }}"
     alt="Foto Profil"
     class="rounded-circle"
     width="80" height="80">
```

---

### 10.2 Sidebar Navigasi Dinamis

Sidebar menampilkan indikator menu aktif menggunakan helper `request()->routeIs()`:

```blade
<ul class="nav flex-column">
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
           href="{{ route('dashboard') }}">
            🏠 Dashboard
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('kategori.*') ? 'active' : '' }}"
           href="{{ route('kategori.index') }}">
            🏷️ Kategori
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('penulis.*') ? 'active' : '' }}"
           href="{{ route('penulis.index') }}">
            👤 Penulis
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('artikel.*') ? 'active' : '' }}"
           href="{{ route('artikel.index') }}">
            📝 Artikel
        </a>
    </li>
</ul>
```

---

## 11. Kebutuhan Fungsional — Operasi CRUD

### 11.1 Pola PRG (Post/Redirect/Get) + Flash Message

Semua operasi POST, PUT, dan DELETE **wajib** mengikuti pola PRG:

```
[Form Submit] → POST/PUT/DELETE
                     │
           ┌─────────┴─────────┐
           │                   │
         Sukses               Gagal
           │                   │
     Redirect +           Redirect back +
     flash('success')     flash('error')
           │                   │
           └────────┬──────────┘
                    ▼
              GET (tampil view)
              + tampil flash msg
```

**Implementasi di Controller:**

```php
// Sukses
return redirect()->route('kategori.index')
    ->with('success', 'Kategori berhasil ditambahkan.');

// Gagal (misal: constraint violation)
return redirect()->back()
    ->with('error', 'Kategori tidak dapat dihapus karena masih memiliki artikel.');
```

**Implementasi di View (partial/komponen reusable):**

```blade
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        ✅ {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        ❌ {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
```

---

### 11.2 Modul Kategori Artikel

**Resource Controller:** `KategoriArtikelController`  
**Model:** `KategoriArtikel`  
**Tabel:** `kategori_artikel`

#### Spesifikasi Fungsional:

| Aksi | Method | Route | Deskripsi |
|------|--------|-------|-----------|
| Tampil semua | GET | `/kategori` | List semua kategori |
| Form tambah | GET | `/kategori/create` | Halaman form tambah |
| Simpan | POST | `/kategori` | Validasi + simpan ke DB |
| Form edit | GET | `/kategori/{id}/edit` | Form edit dengan data existing |
| Update | PUT | `/kategori/{id}` | Validasi + update di DB |
| Hapus | DELETE | `/kategori/{id}` | Cek constraint → hapus |

#### Validasi Form:

```php
$request->validate([
    'nama_kategori' => 'required|string|max:100|unique:kategori_artikel,nama_kategori',
    // Edit: tambahkan ,{$id} untuk mengecualikan data sendiri
    // 'nama_kategori' => "required|string|max:100|unique:kategori_artikel,nama_kategori,{$kategori->id}",
]);
```

#### ⚠️ Constraint Deletion — Kategori Tidak Boleh Dihapus jika Masih Memiliki Artikel:

```php
// KategoriArtikelController@destroy
public function destroy(KategoriArtikel $kategori)
{
    // Cek apakah masih memiliki artikel terkait
    if ($kategori->artikel()->count() > 0) {
        return redirect()->route('kategori.index')
            ->with('error', 'Kategori tidak dapat dihapus karena masih memiliki artikel terkait.');
    }

    $kategori->delete();
    return redirect()->route('kategori.index')
        ->with('success', 'Kategori berhasil dihapus.');
}
```

---

### 11.3 Modul Penulis

**Resource Controller:** `PenulisController`  
**Model:** `Penulis`  
**Tabel:** `penulis`

#### Spesifikasi Fungsional:

| Aksi | Method | Route | Deskripsi |
|------|--------|-------|-----------|
| Tampil semua | GET | `/penulis` | List semua penulis |
| Form tambah | GET | `/penulis/create` | Form tambah penulis baru |
| Simpan | POST | `/penulis` | Validasi + upload foto + simpan |
| Form edit | GET | `/penulis/{id}/edit` | Form edit dengan data existing |
| Update | PUT | `/penulis/{id}` | Validasi + update (ganti foto & password opsional) |
| Hapus | DELETE | `/penulis/{id}` | Cek constraint → hapus data + foto fisik |

#### Validasi Form — Create:

```php
$request->validate([
    'nama_lengkap'  => 'required|string|max:100',
    'user_name'     => 'required|string|max:50|unique:penulis,user_name',
    'password'      => 'required|string|min:6',
    'foto'          => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
]);
```

#### Validasi Form — Update:

```php
$request->validate([
    'nama_lengkap'  => 'required|string|max:100',
    'user_name'     => "required|string|max:50|unique:penulis,user_name,{$penulis->id}",
    'password'      => 'nullable|string|min:6',    // Opsional saat edit
    'foto'          => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
]);
```

#### Upload Foto Profil:

```php
// PenulisController@store / @update
if ($request->hasFile('foto')) {
    $fotoName = uniqid('foto_') . '.' . $request->foto->extension();
    $request->foto->storeAs('foto', $fotoName, 'public');
    $data['foto'] = $fotoName;
}
```

#### Update Password (Nullable):

```php
// Hanya update password jika field tidak kosong
if ($request->filled('password')) {
    $data['password'] = bcrypt($request->password);
}
```

#### ⚠️ Constraint Deletion — Hapus Penulis:

```php
// PenulisController@destroy
public function destroy(Penulis $penulis)
{
    if ($penulis->artikel()->count() > 0) {
        return redirect()->route('penulis.index')
            ->with('error', 'Penulis tidak dapat dihapus karena masih memiliki artikel.');
    }

    // Hapus file foto fisik jika bukan default
    if ($penulis->foto && $penulis->foto !== 'default.png') {
        Storage::disk('public')->delete('foto/' . $penulis->foto);
    }

    $penulis->delete();
    return redirect()->route('penulis.index')
        ->with('success', 'Penulis berhasil dihapus.');
}
```

---

### 11.4 Modul Artikel

**Resource Controller:** `ArtikelController`  
**Model:** `Artikel`  
**Tabel:** `artikel`

#### Spesifikasi Fungsional:

| Aksi | Method | Route | Deskripsi |
|------|--------|-------|-----------|
| Tampil semua | GET | `/artikel` | List artikel + eager load penulis & kategori |
| Form tambah | GET | `/artikel/create` | Form + dropdown kategori |
| Simpan | POST | `/artikel` | Auto-fill id_penulis & tanggal → simpan |
| Form edit | GET | `/artikel/{id}/edit` | Form edit dengan data existing |
| Update | PUT | `/artikel/{id}` | Validasi + ganti gambar opsional |
| Hapus | DELETE | `/artikel/{id}` | Hapus data + gambar fisik |

#### Validasi Form:

```php
$request->validate([
    'judul'             => 'required|string|max:255',
    'isi_artikel'       => 'required|string',
    'id_kategori'       => 'required|exists:kategori_artikel,id',
    'gambar'            => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
]);
```

#### Auto-fill `id_penulis` & `tanggal`:

```php
// ArtikelController@store — WAJIB, tidak boleh dari form input
$data = $request->validated();
$data['id_penulis'] = Auth::user()->id;      // Ambil dari session auth
$data['tanggal']    = now()->timezone('Asia/Jakarta')->format('Y-m-d');
```

> **⛔ Keamanan:** Kolom `id_penulis` dan `tanggal` **tidak boleh** menjadi bagian dari form input yang bisa dimanipulasi user. Keduanya di-assign secara server-side.

#### Upload Gambar Thumbnail:

```php
if ($request->hasFile('gambar')) {
    $gambarName = uniqid('gambar_') . '.' . $request->gambar->extension();
    $request->gambar->storeAs('gambar', $gambarName, 'public');
    $data['gambar'] = $gambarName;
}
```

#### Hapus Gambar Fisik saat Delete:

```php
// ArtikelController@destroy
public function destroy(Artikel $artikel)
{
    if ($artikel->gambar) {
        Storage::disk('public')->delete('gambar/' . $artikel->gambar);
    }
    $artikel->delete();
    return redirect()->route('artikel.index')
        ->with('success', 'Artikel berhasil dihapus.');
}
```

#### ✅ Eager Loading — Mencegah N+1 Query:

```php
// ArtikelController@index — WAJIB menggunakan with()
public function index()
{
    $artikel = Artikel::with(['penulis', 'kategori'])->get();
    return view('artikel.index', compact('artikel'));
}
```

> **Mengapa penting?** Tanpa `with()`, setiap baris artikel di tabel akan memicu 2 query tambahan (1 untuk penulis, 1 untuk kategori). Dengan 100 artikel = 201 query. Dengan Eager Loading = tetap 3 query.

#### Dropdown Kategori di Form:

```php
// ArtikelController@create & @edit
public function create()
{
    $kategori = KategoriArtikel::all();  // Untuk populate dropdown
    return view('artikel.create', compact('kategori'));
}
```

```blade
<select name="id_kategori" class="form-select" required>
    <option value="">-- Pilih Kategori --</option>
    @foreach($kategori as $kat)
        <option value="{{ $kat->id }}"
            {{ old('id_kategori', $artikel->id_kategori ?? '') == $kat->id ? 'selected' : '' }}>
            {{ $kat->nama_kategori }}
        </option>
    @endforeach
</select>
```

---

## 12. Kebutuhan Non-Fungsional

### 12.1 Performa

| Kriteria | Target |
|---------|--------|
| Waktu load halaman index artikel | < 500ms (dengan eager loading) |
| Upload foto/gambar | Maksimal 2MB per file |
| Query per halaman listing | ≤ 5 query (dengan eager loading aktif) |

### 12.2 Keamanan

| Kriteria | Implementasi |
|---------|--------------|
| CSRF Protection | `@csrf` di semua form |
| SQL Injection | Eloquent ORM (parameterized query) |
| Password | BCrypt hashing |
| Mass Assignment | `$fillable` didefinisikan di semua model |
| Akses tidak sah | Middleware `auth` di semua route terproteksi |
| File upload | Validasi `mimes`, `max`, `image` di semua form upload |

### 12.3 Maintainability

| Kriteria | Standar |
|---------|---------|
| Pemisahan layer | Tidak ada HTML di Controller, tidak ada query di View |
| Naming convention | PSR-4 (class), snake_case (kolom DB), camelCase (method PHP) |
| Blade template | Satu master layout, child menggunakan `@extends` & `@section` |
| Route naming | Semua route menggunakan named routes |

### 12.4 Usability

| Kriteria | Standar |
|---------|---------|
| Notifikasi feedback | Flash message pada setiap operasi CRUD |
| Validasi form | Error ditampilkan inline di bawah field terkait |
| Menu aktif | Sidebar menampilkan indikator visual halaman aktif |
| Foto fallback | Gambar default tersedia jika foto tidak diunggah |

---

## 13. Struktur Database & Relasi Eloquent

### 13.1 Diagram Relasi Entitas (ERD)

```
┌─────────────────────┐         ┌──────────────────────────┐
│      penulis        │         │     kategori_artikel      │
├─────────────────────┤         ├──────────────────────────┤
│ id (PK, AI)         │         │ id (PK, AI)              │
│ nama_lengkap        │         │ nama_kategori            │
│ user_name (UNIQUE)  │         └──────────┬───────────────┘
│ password            │                    │
│ foto                │                    │ 1
└──────────┬──────────┘                    │
           │                               │ N
           │ 1                             │
           │ N       ┌─────────────────────▼───────────────┐
           └────────►│            artikel                  │
                     ├─────────────────────────────────────┤
                     │ id (PK, AI)                         │
                     │ judul                               │
                     │ isi_artikel (TEXT)                  │
                     │ gambar                              │
                     │ tanggal                             │
                     │ id_penulis (FK → penulis.id)        │
                     │ id_kategori (FK → kategori_artikel) │
                     └─────────────────────────────────────┘
```

---

### 13.2 Tabel `penulis`

```sql
CREATE TABLE penulis (
    id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama_lengkap  VARCHAR(100)  NOT NULL,
    user_name     VARCHAR(50)   NOT NULL UNIQUE,
    password      VARCHAR(255)  NOT NULL,
    foto          VARCHAR(255)  NULL DEFAULT 'default.png'
);
```

**Model: `app/Models/Penulis.php`**

```php
<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Penulis extends Authenticatable
{
    protected $table      = 'penulis';
    public    $timestamps = false;               // ⚠️ WAJIB: nonaktifkan timestamps

    protected $fillable = [
        'nama_lengkap',
        'user_name',
        'password',
        'foto',
    ];

    protected $hidden = ['password'];            // Jangan expose password di serialisasi

    // Override auth identifier
    public function getAuthIdentifierName(): string
    {
        return 'user_name';
    }

    // Relasi: Satu penulis memiliki banyak artikel
    public function artikel()
    {
        return $this->hasMany(Artikel::class, 'id_penulis', 'id');
    }
}
```

---

### 13.3 Tabel `kategori_artikel`

```sql
CREATE TABLE kategori_artikel (
    id             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama_kategori  VARCHAR(100) NOT NULL
);
```

**Model: `app/Models/KategoriArtikel.php`**

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriArtikel extends Model
{
    protected $table      = 'kategori_artikel';
    public    $timestamps = false;               // ⚠️ WAJIB: nonaktifkan timestamps

    protected $fillable = [
        'nama_kategori',
    ];

    // Relasi: Satu kategori memiliki banyak artikel
    public function artikel()
    {
        return $this->hasMany(Artikel::class, 'id_kategori', 'id');
    }
}
```

---

### 13.4 Tabel `artikel`

```sql
CREATE TABLE artikel (
    id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    judul        VARCHAR(255) NOT NULL,
    isi_artikel  TEXT         NOT NULL,
    gambar       VARCHAR(255) NULL,
    tanggal      DATE         NOT NULL,
    id_penulis   INT UNSIGNED NOT NULL,
    id_kategori  INT UNSIGNED NOT NULL,

    CONSTRAINT fk_artikel_penulis
        FOREIGN KEY (id_penulis) REFERENCES penulis(id),
    CONSTRAINT fk_artikel_kategori
        FOREIGN KEY (id_kategori) REFERENCES kategori_artikel(id)
);
```

**Model: `app/Models/Artikel.php`**

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    protected $table      = 'artikel';
    public    $timestamps = false;               // ⚠️ WAJIB: nonaktifkan timestamps

    protected $fillable = [
        'judul',
        'isi_artikel',
        'gambar',
        'tanggal',
        'id_penulis',
        'id_kategori',
    ];

    // Relasi: Artikel dimiliki oleh satu penulis
    public function penulis()
    {
        return $this->belongsTo(Penulis::class, 'id_penulis', 'id');
    }

    // Relasi: Artikel masuk ke satu kategori
    public function kategori()
    {
        return $this->belongsTo(KategoriArtikel::class, 'id_kategori', 'id');
    }
}
```

---

### 13.5 Ringkasan Relasi Eloquent

| Model | Relasi | Target Model | FK | Tipe |
|-------|--------|--------------|----|------|
| `Penulis` | `hasMany` | `Artikel` | `id_penulis` | One-to-Many |
| `KategoriArtikel` | `hasMany` | `Artikel` | `id_kategori` | One-to-Many |
| `Artikel` | `belongsTo` | `Penulis` | `id_penulis` | Many-to-One |
| `Artikel` | `belongsTo` | `KategoriArtikel` | `id_kategori` | Many-to-One |

---

## 14. Standar Koding & Konvensi

### 14.1 Aturan Wajib

| # | Aturan | Alasan |
|---|--------|--------|
| 1 | `public $timestamps = false` di semua Model | Tabel tidak memiliki kolom `created_at`/`updated_at` |
| 2 | `$fillable` didefinisikan di semua Model | Proteksi Mass Assignment Attack |
| 3 | `Auth::user()->id` untuk `id_penulis` di artikel | Mencegah manipulasi dari sisi client |
| 4 | `now()->timezone('Asia/Jakarta')` untuk tanggal | Konsistensi timezone WIB |
| 5 | `Storage::disk('public')->delete()` saat hapus file | Mencegah file orphan di storage |
| 6 | `Artikel::with(['penulis', 'kategori'])` di index | Mencegah N+1 query problem |
| 7 | `@csrf` di semua form | Proteksi Cross-Site Request Forgery |
| 8 | `@method('PUT')` / `@method('DELETE')` di form edit/hapus | HTML form hanya support GET & POST |
| 9 | Route POST untuk logout | Mencegah CSRF logout attack via link |
| 10 | `uniqid()` sebagai prefix nama file upload | Mencegah konflik nama file |

### 14.2 Naming Convention

| Elemen | Konvensi | Contoh |
|--------|----------|--------|
| Controller class | PascalCase + `Controller` | `ArtikelController` |
| Model class | PascalCase | `KategoriArtikel` |
| Tabel DB | snake_case | `kategori_artikel` |
| Kolom DB | snake_case | `nama_lengkap`, `id_penulis` |
| Route name | dot-notation | `artikel.index`, `kategori.store` |
| Blade file | kebab-case (opsional) atau snake_case | `artikel/create.blade.php` |
| Method controller | camelCase | `showLoginForm()`, `destroy()` |

---

## 15. Manajemen File & Storage

### 15.1 Konfigurasi Storage

```bash
# Wajib dijalankan sekali di setup
php artisan storage:link
```

Perintah ini membuat symlink dari `public/storage` → `storage/app/public` sehingga file dapat diakses via URL.

### 15.2 Struktur Folder Storage

```
storage/app/public/
├── foto/
│   ├── default.png           ← File default WAJIB ada
│   ├── foto_abc123.jpg
│   └── foto_def456.png
└── gambar/
    ├── gambar_xyz789.jpg
    └── gambar_uvw012.png
```

### 15.3 Aturan File Upload

| Tipe File | Folder | Disk | Prefix | Format Nama | Max Size |
|-----------|--------|------|--------|-------------|----------|
| Foto Profil Penulis | `foto/` | `public` | `foto_` | `uniqid('foto_') . '.' . ext` | 2 MB |
| Thumbnail Artikel | `gambar/` | `public` | `gambar_` | `uniqid('gambar_') . '.' . ext` | 2 MB |

### 15.4 Generate URL File di View

```blade
{{-- Foto profil penulis --}}
<img src="{{ asset('storage/foto/' . ($penulis->foto ?? 'default.png')) }}"
     alt="{{ $penulis->nama_lengkap }}">

{{-- Thumbnail artikel --}}
@if($artikel->gambar)
    <img src="{{ asset('storage/gambar/' . $artikel->gambar) }}"
         alt="{{ $artikel->judul }}">
@endif
```

### 15.5 Aturan Penghapusan File

| Kondisi | Aksi pada Storage |
|---------|------------------|
| Penulis dihapus dengan foto (bukan `default.png`) | `Storage::disk('public')->delete('foto/' . $penulis->foto)` |
| Penulis edit + upload foto baru | Hapus foto lama, simpan foto baru |
| Artikel dihapus dengan gambar | `Storage::disk('public')->delete('gambar/' . $artikel->gambar)` |
| Artikel edit + upload gambar baru | Hapus gambar lama, simpan gambar baru |

---

## 16. Batasan & Asumsi

### 16.1 Batasan Teknis

- Aplikasi hanya mendukung **satu level user** (tidak ada role admin/editor/author yang berbeda)
- Tidak ada **pagination** pada listing — semua data ditampilkan sekaligus (versi 1.0)
- Tidak ada **fitur pencarian/filter** pada modul manapun (versi 1.0)
- **Timezone hardcode** ke `Asia/Jakarta` — tidak ada konfigurasi per-user
- Format file gambar terbatas pada: `jpg`, `jpeg`, `png`, `gif` (foto), ditambah `webp` (artikel)

### 16.2 Asumsi

- Database MySQL sudah terinstal dan konfigurasi `.env` sudah dikonfigurasi sebelum development
- `php artisan storage:link` sudah dijalankan pada saat setup
- File `default.png` untuk foto profil **sudah tersedia** di `storage/app/public/foto/`
- Seluruh data penulis diinput secara manual oleh admin melalui modul penulis (tidak ada self-register)
- Aplikasi berjalan di satu server (tidak ada multi-server atau CDN untuk storage)

---

## 17. Kriteria Keberhasilan (Definition of Done)

Sebuah fitur dianggap **selesai** jika memenuhi semua kriteria berikut:

### ✅ Checklist per Fitur CRUD

- [ ] Controller mengikuti pola Resource Controller standar Laravel
- [ ] Route didefinisikan menggunakan `Route::resource()` dengan nama yang benar
- [ ] Validasi server-side diterapkan dengan rules yang sesuai
- [ ] Pola PRG diterapkan — tidak ada form yang langsung return view setelah POST
- [ ] Flash message sukses dan error ditampilkan dengan benar
- [ ] Error validasi ditampilkan inline di bawah field yang bermasalah
- [ ] Middleware `auth` melindungi semua route yang membutuhkan login
- [ ] File upload menggunakan `Storage::disk('public')` dengan prefix `uniqid()`
- [ ] File fisik dihapus dari storage saat record dihapus atau diganti
- [ ] Constraint check mencegah penghapusan data yang masih berelasi
- [ ] Eager loading digunakan pada semua halaman listing dengan relasi
- [ ] `$timestamps = false` diset di semua model
- [ ] `$fillable` terdefinisi di semua model
- [ ] Password di-hash dengan BCrypt sebelum disimpan

### ✅ Checklist Autentikasi

- [ ] Login menggunakan `user_name` (bukan `email`)
- [ ] Guard & provider dikonfigurasi ke model `Penulis`
- [ ] Waktu login tersimpan di session dan tampil di dashboard
- [ ] Middleware `guest` mencegah halaman login diakses pengguna yang sudah login
- [ ] Logout menggunakan HTTP POST (bukan GET)
- [ ] Token CSRF tersertakan di form logout

---

## 18. Glosarium

| Istilah | Definisi |
|---------|----------|
| **MVC** | Model-View-Controller — pola arsitektur untuk memisahkan logika bisnis, presentasi, dan akses data |
| **Eloquent ORM** | Object-Relational Mapping bawaan Laravel untuk interaksi dengan database menggunakan objek PHP |
| **Eager Loading** | Teknik memuat relasi database sekaligus dalam satu query menggunakan `with()` untuk menghindari N+1 problem |
| **N+1 Problem** | Masalah performa di mana 1 query utama diikuti N query tambahan (satu per baris) untuk memuat relasi |
| **PRG Pattern** | Post/Redirect/Get — pola mencegah duplikasi submit form dengan redirect setelah POST |
| **Flash Message** | Pesan sementara yang disimpan di session dan hanya tampil sekali (setelah redirect) |
| **Mass Assignment** | Serangan yang mengisi field database berbahaya melalui manipulasi form input; dicegah dengan `$fillable` |
| **Middleware** | Lapisan filter HTTP yang berjalan sebelum request mencapai Controller |
| **Resource Controller** | Controller dengan method standar CRUD (index, create, store, edit, update, destroy) |
| **BCrypt** | Algoritma hashing satu arah yang digunakan untuk mengamankan password |
| **Storage Link** | Symlink dari `public/storage` ke `storage/app/public` agar file bisa diakses via URL |
| **CSRF** | Cross-Site Request Forgery — serangan yang memaksa user melakukan aksi tanpa sepengetahuannya |
| **Constraint** | Batasan integritas database yang mencegah operasi yang melanggar relasi antar tabel |
| **Eager Loading FK** | Foreign Key — referensi ke primary key tabel lain untuk mendefinisikan relasi |

---

*Dokumen ini adalah living document. Setiap perubahan signifikan pada spesifikasi teknis atau fungsional harus diperbarui di sini dan dikomunikasikan ke seluruh tim sebelum implementasi dimulai.*

---

**© Blog CMS Project — Laravel 11 MVC | PRD v1.0.0**
