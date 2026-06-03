# DESIGN.md
# System & Technical Design Document
# Blog CMS — Laravel 11 + MVC Architecture

---

## Document Information

| Field | Detail |
|---|---|
| Project | Blog Content Management System (CMS) |
| Framework | Laravel 11 (PHP 8.2+) |
| Architecture | MVC (Model-View-Controller) |
| Template Engine | Blade |
| ORM | Eloquent ORM |
| UI Framework | Bootstrap 5 |
| Document Version | 1.0.0 |
| Status | Final — Pre-Implementation |

---

## Table of Contents

1. Introduction
2. System Architecture (MVC)
3. Database Design & Eloquent Modeling
4. Security & Authentication Design
5. UI/UX & Layout Design
6. File Storage & Media Design
7. Routing & Resource Controller Design
8. Appendix — Summary Reference

---

## 1. Introduction

### 1.1 Project Overview

This document is the authoritative technical and design specification for a Blog Content Management System (CMS) built upon the Laravel 11 framework, adhering to the Model-View-Controller (MVC) architectural pattern. It is intended to serve as the single source of truth for all backend engineers, frontend engineers, and QA personnel participating in the development lifecycle.

### 1.2 Goals & Scope

- Provide a fully operable CMS platform for managing blog articles, authors, and content categories.
- Enforce clean separation of concerns through strict MVC compliance.
- Guarantee a secure, authenticated, and access-controlled administrative dashboard.
- Deliver a responsive and interactive user interface leveraging Bootstrap 5.
- Establish robust file management conventions for user-uploaded media assets.

### 1.3 Out of Scope

- Public-facing front-end blog reader interface.
- Comment system or reader account management.
- Third-party API integrations (social media, SEO tools).
- Multi-tenancy or multi-site support.

---

## 2. System Architecture (MVC)

### 2.1 Architectural Overview

The application adheres strictly to the Laravel MVC pattern, ensuring a clean unidirectional request lifecycle. The three tiers are:

- **Model** — Data layer; all database logic, relationships, and data manipulation via Eloquent ORM.
- **View** — Presentation layer; all HTML rendered via Blade Template Engine.
- **Controller** — Application logic layer; mediates between Model and View, processes HTTP requests, and manages response flow.

### 2.2 Request Lifecycle

The canonical request lifecycle follows this linear flow:

```
Browser (HTTP Request)
       |
       v
[1] routes/web.php  ← Route definition; maps URI + HTTP verb to Controller action
       |
       v
[2] Middleware       ← Auth/Guest guards; CSRF verification
       |
       v
[3] Controller       ← Business logic; calls Model(s), prepares data, returns response
       |
       v
[4] Model (Eloquent) ← Database query execution, relationship resolution, mass-assignment protection
       |
       v
[5] View (Blade)     ← Data binding, HTML rendering, component rendering
       |
       v
Browser (HTTP Response)
```

### 2.3 Directory Structure (Relevant Paths)

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── AuthController.php
│   │   ├── PenulisController.php
│   │   ├── KategoriArtikelController.php
│   │   └── ArtikelController.php
│   └── Middleware/
│       └── (Leverages built-in 'auth' and 'guest' middleware)
├── Models/
│   ├── Penulis.php
│   ├── KategoriArtikel.php
│   └── Artikel.php
config/
└── auth.php               ← Customized user provider + guard
resources/
└── views/
    ├── layouts/
    │   └── app.blade.php  ← Master layout
    ├── auth/
    │   └── login.blade.php
    ├── penulis/
    │   ├── index.blade.php
    │   ├── create.blade.php
    │   └── edit.blade.php
    ├── kategori/
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
└── app/
    └── public/
        ├── foto/          ← Author profile photos
        └── gambar/        ← Article thumbnail images
public/
└── storage/               ← Symbolic link → storage/app/public
```

---

## 3. Database Design & Eloquent Modeling

### 3.1 Design Principles

- **No default `users` table**: The Laravel default authentication table is replaced by the custom `penulis` table.
- **Timestamps disabled**: All models declare `public $timestamps = false;` to prevent Eloquent from automatically managing `created_at` / `updated_at` columns.
- **Mass Assignment protection**: All models define a `$fillable` array to explicitly whitelist columns safe for bulk assignment.

### 3.2 Entity-Relationship Diagram (Conceptual)

```
┌─────────────────────┐         ┌──────────────────────────┐         ┌─────────────────────────┐
│       penulis        │         │         artikel           │         │    kategori_artikel      │
├─────────────────────┤         ├──────────────────────────┤         ├─────────────────────────┤
│ id (PK)             │◄────────│ id (PK)                  │────────►│ id (PK)                  │
│ nama_lengkap        │  hasMany │ judul                    │ belongs  │ nama_kategori            │
│ user_name (unique)  │         │ isi_artikel              │   To     │                          │
│ password            │         │ thumbnail                │         └─────────────────────────┘
│ foto_profil         │         │ id_penulis (FK)          │
│ jenis_kelamin       │         │ id_kategori (FK)         │
└─────────────────────┘         └──────────────────────────┘
```

**Cardinality:**
- `penulis` → `artikel`: One-to-Many (`hasMany`)
- `kategori_artikel` → `artikel`: One-to-Many (`hasMany`)
- `artikel` → `penulis`: Many-to-One (`belongsTo`)
- `artikel` → `kategori_artikel`: Many-to-One (`belongsTo`)

### 3.3 Table: `penulis`

| Column | Type | Constraints | Notes |
|---|---|---|---|
| `id` | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | Eloquent default |
| `nama_lengkap` | VARCHAR(100) | NOT NULL | Full name display |
| `user_name` | VARCHAR(50) | NOT NULL, UNIQUE | Authentication identifier |
| `password` | VARCHAR(255) | NOT NULL | Bcrypt hashed string |
| `foto_profil` | VARCHAR(255) | NULLABLE | Stored path under `foto/` |
| `jenis_kelamin` | ENUM('L','P') | NOT NULL | Laki-laki / Perempuan |

### 3.4 Table: `kategori_artikel`

| Column | Type | Constraints | Notes |
|---|---|---|---|
| `id` | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | |
| `nama_kategori` | VARCHAR(100) | NOT NULL, UNIQUE | Category label |

### 3.5 Table: `artikel`

| Column | Type | Constraints | Notes |
|---|---|---|---|
| `id` | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | |
| `judul` | VARCHAR(200) | NOT NULL | Article headline |
| `isi_artikel` | LONGTEXT | NOT NULL | Full article body |
| `thumbnail` | VARCHAR(255) | NULLABLE | Stored path under `gambar/` |
| `id_penulis` | BIGINT UNSIGNED | NOT NULL, FK → `penulis.id` | ON DELETE RESTRICT |
| `id_kategori` | BIGINT UNSIGNED | NOT NULL, FK → `kategori_artikel.id` | ON DELETE RESTRICT |

### 3.6 Eloquent Model Specifications

#### Model: `Penulis`

```php
// app/Models/Penulis.php
class Penulis extends Authenticatable
{
    protected $table = 'penulis';
    public $timestamps = false;

    protected $fillable = [
        'nama_lengkap',
        'user_name',
        'password',
        'foto_profil',
        'jenis_kelamin',
    ];

    protected $hidden = ['password'];

    // RELATIONSHIP: One penulis has many artikel
    public function artikel(): HasMany
    {
        return $this->hasMany(Artikel::class, 'id_penulis');
    }
}
```

#### Model: `KategoriArtikel`

```php
// app/Models/KategoriArtikel.php
class KategoriArtikel extends Model
{
    protected $table = 'kategori_artikel';
    public $timestamps = false;

    protected $fillable = ['nama_kategori'];

    // RELATIONSHIP: One kategori has many artikel
    public function artikel(): HasMany
    {
        return $this->hasMany(Artikel::class, 'id_kategori');
    }
}
```

#### Model: `Artikel`

```php
// app/Models/Artikel.php
class Artikel extends Model
{
    protected $table = 'artikel';
    public $timestamps = false;

    protected $fillable = [
        'judul',
        'isi_artikel',
        'thumbnail',
        'id_penulis',
        'id_kategori',
    ];

    // RELATIONSHIP: Artikel belongs to one Penulis
    public function penulis(): BelongsTo
    {
        return $this->belongsTo(Penulis::class, 'id_penulis');
    }

    // RELATIONSHIP: Artikel belongs to one KategoriArtikel
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriArtikel::class, 'id_kategori');
    }
}
```

### 3.7 N+1 Query Prevention — Eager Loading

When retrieving a list of articles on the `index` view, Eloquent's Eager Loading MUST be used to pre-fetch all relational data in a single compound query, preventing the N+1 problem.

```php
// ArtikelController.php — index() method
public function index()
{
    // CORRECT: Eager Loading — executes 3 queries total (artikel + penulis + kategori)
    $artikels = Artikel::with(['penulis', 'kategori'])->get();

    // INCORRECT (N+1): Would execute 1 + N + N queries
    // $artikels = Artikel::all();

    return view('artikel.index', compact('artikels'));
}
```

**Query execution comparison:**

| Approach | Queries for 100 articles | Relative Cost |
|---|---|---|
| `Artikel::all()` then lazy-load | 201 queries | HIGH |
| `Artikel::with(['penulis','kategori'])` | 3 queries | LOW (optimal) |

---

## 4. Security & Authentication Design

### 4.1 Authentication Configuration

Laravel's authentication scaffolding is customized in `config/auth.php` to redirect the default guard away from the `users` table toward the custom `penulis` table.

```php
// config/auth.php
'guards' => [
    'web' => [
        'driver'   => 'session',
        'provider' => 'penulis', // ← custom provider
    ],
],

'providers' => [
    'penulis' => [
        'driver' => 'eloquent',
        'model'  => App\Models\Penulis::class,
    ],
],
```

The `Penulis` model extends `Authenticatable` and must override the username field:

```php
// In Penulis model
public function getAuthIdentifierName(): string
{
    return 'user_name'; // ← Override default 'email'
}
```

### 4.2 Password Security

All passwords are stored exclusively as Bcrypt hashes. Plaintext storage is strictly prohibited. Hashing is applied at the point of `store()` and `update()` in `PenulisController`.

```php
// Hashing on store
'password' => bcrypt($request->password),

// Hashing on update (conditional — only if a new password is submitted)
if ($request->filled('password')) {
    $data['password'] = bcrypt($request->password);
}
```

### 4.3 Middleware Strategy

| Route Group | Middleware | Purpose |
|---|---|---|
| `/login` (GET & POST) | `guest` | Redirect authenticated users away from login page |
| `/dashboard/*` (all) | `auth` | Block unauthenticated access; redirect to `/login` |
| All POST/PUT/DELETE | CSRF (built-in) | Prevent cross-site request forgery attacks |

**Route protection example:**

```php
// routes/web.php
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::resource('penulis', PenulisController::class)->except(['show']);
    Route::resource('kategori', KategoriArtikelController::class)->except(['show']);
    Route::resource('artikel', ArtikelController::class)->except(['show']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
```

### 4.4 Session Security — Fixation Prevention

Upon successful authentication, the session MUST be regenerated to prevent session fixation attacks. This is handled in `AuthController::login()`.

```php
// AuthController.php — login()
public function login(Request $request)
{
    $credentials = $request->only('user_name', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate(); // ← MANDATORY: Prevents session fixation
        return redirect()->intended('/dashboard');
    }

    return back()->withErrors(['user_name' => 'Kredensial tidak valid.']);
}
```

### 4.5 CSRF Protection

All HTML forms that submit data (POST, PUT, DELETE) MUST include the `@csrf` Blade directive. The logout action MUST use a form with POST method — never a plain anchor tag with GET.

```html
<!-- Logout button — MUST be POST form, never GET anchor -->
<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-outline-danger btn-sm">Logout</button>
</form>
```

---

## 5. UI/UX & Layout Design

### 5.1 Technology Stack

| Component | Technology |
|---|---|
| CSS Framework | Bootstrap 5.3 (CDN) |
| Icons | Bootstrap Icons |
| Template Engine | Laravel Blade |
| Interaction Pattern | PRG (Post/Redirect/Get) |
| Validation Feedback | Server-side; Bootstrap `is-invalid` classes |

### 5.2 Master Layout — `layouts/app.blade.php`

The master layout provides the structural shell for all authenticated views. It consists of three primary zones:

```
┌──────────────────────────────────────────────────────────────┐
│                        HEADER (Topbar)                        │
│  [≡ Toggle]  Blog CMS                    [Avatar] [Logout]   │
├──────────────┬───────────────────────────────────────────────┤
│              │                                               │
│   SIDEBAR    │              MAIN CONTENT                     │
│  (Nav Links) │         @yield('content')                     │
│              │                                               │
│  ┌────────┐  │                                               │
│  │Profile │  │                                               │
│  │ Card  │  │                                               │
│  └────────┘  │                                               │
│  • Dashboard │                                               │
│  • Penulis   │                                               │
│  • Kategori  │                                               │
│  • Artikel   │                                               │
│              │                                               │
└──────────────┴───────────────────────────────────────────────┘
```

#### 5.2.1 Sidebar — Profile Card

The sidebar MUST include a Profile Card component that dynamically renders the authenticated user's data from `Auth::user()`:

```html
<!-- Profile Card Component -->
<div class="card bg-dark text-white mb-3">
    <div class="card-body text-center">
        <img src="{{ Auth::user()->foto_profil
                    ? asset('storage/foto/' . Auth::user()->foto_profil)
                    : asset('storage/foto/default.png') }}"
             class="rounded-circle mb-2"
             width="70" height="70"
             alt="Foto Profil">
        <p class="mb-0 text-muted small">Halo,</p>
        <p class="fw-bold mb-0">{{ Auth::user()->nama_lengkap }}</p>
    </div>
</div>
```

#### 5.2.2 Sidebar — Active Navigation Indicator

Navigation links MUST dynamically apply the active state based on the current URI. The active item is highlighted with a bright green (`success`) Bootstrap class.

```html
<!-- Dynamic active link using request()->is() -->
<a href="{{ route('penulis.index') }}"
   class="nav-link {{ request()->is('penulis*') ? 'active text-success fw-bold' : 'text-white' }}">
    <i class="bi bi-people-fill me-2"></i> Penulis
</a>
```

| Condition | CSS Classes Applied |
|---|---|
| Active route | `active text-success fw-bold` |
| Inactive route | `text-white` |

### 5.3 Flash Message System (PRG Pattern)

After every form submission (create, update, delete), the controller MUST redirect with a session flash message. The view renders this as a Bootstrap Alert component.

**Controller (sets flash):**

```php
// On success
return redirect()->route('artikel.index')
    ->with('success', 'Artikel berhasil disimpan.');

// On failure (e.g., file error)
return redirect()->back()
    ->with('error', 'Gagal menyimpan artikel. Silakan coba lagi.');
```

**View (renders flash — placed in master layout):**

```html
<!-- Flash message block in layouts/app.blade.php or top of content -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
```

### 5.4 Form Validation Design

All form submissions undergo server-side validation. On validation failure, the user is returned to the originating form with:

1. Previous input repopulated via `old()` helper.
2. Affected fields flagged with `is-invalid` Bootstrap CSS class.
3. Error messages rendered in red below each invalid field.

**Validated form field example:**

```html
<div class="mb-3">
    <label for="judul" class="form-label">Judul Artikel</label>
    <input type="text"
           name="judul"
           id="judul"
           class="form-control {{ $errors->has('judul') ? 'is-invalid' : '' }}"
           value="{{ old('judul') }}"
           placeholder="Masukkan judul artikel...">
    @error('judul')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
```

**Validation rules example (ArtikelController):**

```php
$request->validate([
    'judul'       => 'required|string|max:200',
    'isi_artikel' => 'required|string',
    'thumbnail'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    'id_penulis'  => 'required|exists:penulis,id',
    'id_kategori' => 'required|exists:kategori_artikel,id',
]);
```

### 5.5 View Inventory

| View File | Route Name | Description |
|---|---|---|
| `auth/login.blade.php` | `login` | Login form (guest only) |
| `penulis/index.blade.php` | `penulis.index` | Author data table |
| `penulis/create.blade.php` | `penulis.create` | Add new author form |
| `penulis/edit.blade.php` | `penulis.edit` | Edit author form |
| `kategori/index.blade.php` | `kategori.index` | Category data table |
| `kategori/create.blade.php` | `kategori.create` | Add new category form |
| `kategori/edit.blade.php` | `kategori.edit` | Edit category form |
| `artikel/index.blade.php` | `artikel.index` | Article data table |
| `artikel/create.blade.php` | `artikel.create` | Add new article form |
| `artikel/edit.blade.php` | `artikel.edit` | Edit article form |

---

## 6. File Storage & Media Design

### 6.1 Storage Architecture

All user-uploaded media is managed exclusively through the Laravel Storage facade, targeting the `public` disk. Direct file access is served via a symbolic link created by the `php artisan storage:link` command.

```
storage/app/public/     ← Actual file location (server-side)
        ├── foto/       ← Author profile photos
        │   ├── default.png     ← Fallback profile photo (must be seeded)
        │   └── {uniqid}.{ext}  ← Uploaded files
        └── gambar/     ← Article thumbnail images
            └── {uniqid}.{ext}

public/storage/         ← Symbolic link pointing to storage/app/public
```

**Setup command:**

```bash
php artisan storage:link
```

### 6.2 File Naming Convention

To prevent file name collisions when multiple users upload files with identical names, ALL uploaded files MUST have their names transformed using `uniqid()` or `time()` before storage.

```php
// Recommended naming pattern
$namaFile = uniqid() . '_' . time() . '.' . $request->file('thumbnail')->extension();
// Example output: 64f3a9b12c4e5_1693876145.jpg

// Storage call
$request->file('thumbnail')->storeAs('gambar', $namaFile, 'public');
```

### 6.3 Upload Flow — Create

```
User submits form with file
         |
         v
Controller validates file (mime type, max size)
         |
         v
Generate unique filename: uniqid() + time() + extension
         |
         v
Store file: Storage::disk('public')->putFileAs('gambar/', $file, $filename)
         |
         v
Save filename string to database column (e.g., artikel.thumbnail)
         |
         v
Redirect with success flash
```

### 6.4 Upload Flow — Update (Replace)

When updating a record that includes a new file upload, the old file MUST be physically deleted from storage before storing the new file.

```php
// PenulisController / ArtikelController — update() method
if ($request->hasFile('thumbnail')) {
    // 1. Delete old physical file
    if ($artikel->thumbnail) {
        Storage::disk('public')->delete('gambar/' . $artikel->thumbnail);
    }

    // 2. Generate new filename
    $namaFile = uniqid() . '_' . time() . '.' . $request->file('thumbnail')->extension();

    // 3. Store new file
    $request->file('thumbnail')->storeAs('gambar', $namaFile, 'public');

    // 4. Update filename in payload
    $data['thumbnail'] = $namaFile;
}
```

### 6.5 Delete Flow — Cascade File Deletion

When a record is deleted from the database, its associated physical file MUST also be deleted from the server to prevent orphaned file accumulation.

```php
// ArtikelController — destroy() method
public function destroy(Artikel $artikel)
{
    // 1. Delete physical thumbnail file from storage
    if ($artikel->thumbnail) {
        Storage::disk('public')->delete('gambar/' . $artikel->thumbnail);
    }

    // 2. Delete database record
    $artikel->delete();

    return redirect()->route('artikel.index')
        ->with('success', 'Artikel berhasil dihapus.');
}
```

### 6.6 Default Profile Photo Fallback

If a `Penulis` record has no `foto_profil` value (null or empty), the UI MUST fall back to the static `default.png` image. This is enforced in the Blade template using a ternary expression (see Section 5.2.1).

| Condition | Image Served |
|---|---|
| `foto_profil` is set | `storage/foto/{filename}` |
| `foto_profil` is null | `storage/foto/default.png` |

---

## 7. Routing & Resource Controller Design

### 7.1 RESTful Resource Routing

All CRUD operations for the three main entities are managed using Laravel's Resource Routing convention. The `show` method is explicitly excluded from all resource routes as no public article detail page is required.

```php
// routes/web.php

// --- Unauthenticated Routes ---
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// --- Authenticated Routes ---
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Resource Routes — 'show' excluded on all entities
    Route::resource('penulis', PenulisController::class)->except(['show']);
    Route::resource('kategori', KategoriArtikelController::class)->except(['show']);
    Route::resource('artikel', ArtikelController::class)->except(['show']);

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
```

### 7.2 Generated Route Table

The following routes are generated by the `Route::resource(...)->except(['show'])` calls:

#### Entity: `penulis`

| Method | URI | Action | Route Name | Middleware |
|---|---|---|---|---|
| GET | `/penulis` | `index` | `penulis.index` | `auth` |
| GET | `/penulis/create` | `create` | `penulis.create` | `auth` |
| POST | `/penulis` | `store` | `penulis.store` | `auth` |
| GET | `/penulis/{penulis}/edit` | `edit` | `penulis.edit` | `auth` |
| PUT/PATCH | `/penulis/{penulis}` | `update` | `penulis.update` | `auth` |
| DELETE | `/penulis/{penulis}` | `destroy` | `penulis.destroy` | `auth` |

#### Entity: `kategori`

| Method | URI | Action | Route Name | Middleware |
|---|---|---|---|---|
| GET | `/kategori` | `index` | `kategori.index` | `auth` |
| GET | `/kategori/create` | `create` | `kategori.create` | `auth` |
| POST | `/kategori` | `store` | `kategori.store` | `auth` |
| GET | `/kategori/{kategori}/edit` | `edit` | `kategori.edit` | `auth` |
| PUT/PATCH | `/kategori/{kategori}` | `update` | `kategori.update` | `auth` |
| DELETE | `/kategori/{kategori}` | `destroy` | `kategori.destroy` | `auth` |

#### Entity: `artikel`

| Method | URI | Action | Route Name | Middleware |
|---|---|---|---|---|
| GET | `/artikel` | `index` | `artikel.index` | `auth` |
| GET | `/artikel/create` | `create` | `artikel.create` | `auth` |
| POST | `/artikel` | `store` | `artikel.store` | `auth` |
| GET | `/artikel/{artikel}/edit` | `edit` | `artikel.edit` | `auth` |
| PUT/PATCH | `/artikel/{artikel}` | `update` | `artikel.update` | `auth` |
| DELETE | `/artikel/{artikel}` | `destroy` | `artikel.destroy` | `auth` |

### 7.3 HTTP Method Spoofing for PUT/DELETE

HTML forms only support GET and POST methods natively. Laravel uses the `@method` Blade directive to spoof PUT/PATCH/DELETE methods via a hidden `_method` field.

```html
<!-- Edit form -->
<form action="{{ route('artikel.update', $artikel->id) }}" method="POST">
    @csrf
    @method('PUT')
    <!-- fields -->
</form>

<!-- Delete button -->
<form action="{{ route('artikel.destroy', $artikel->id) }}" method="POST"
      onsubmit="return confirm('Yakin ingin menghapus artikel ini?')">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm">
        <i class="bi bi-trash"></i> Hapus
    </button>
</form>
```

### 7.4 Controller Method Responsibility Matrix

| Controller | Method | Responsibility |
|---|---|---|
| `AuthController` | `showLoginForm()` | Render login view |
| `AuthController` | `login()` | Validate credentials, attempt auth, regenerate session, redirect |
| `AuthController` | `logout()` | Invalidate session, regenerate token, redirect to `/login` |
| `PenulisController` | `index()` | Query all penulis, return list view |
| `PenulisController` | `create()` | Return create form view |
| `PenulisController` | `store()` | Validate, hash password, store file, insert record, redirect |
| `PenulisController` | `edit()` | Fetch record, return edit form view |
| `PenulisController` | `update()` | Validate, hash password if changed, swap file if uploaded, update record |
| `PenulisController` | `destroy()` | Delete physical file, delete record, redirect |
| `ArtikelController` | `index()` | Eager-load penulis + kategori, return list view |
| `ArtikelController` | `create()` | Fetch penulis + kategori lists, return form view |
| `ArtikelController` | `store()` | Validate, store thumbnail, insert record, redirect |
| `ArtikelController` | `edit()` | Fetch record + dropdown data, return form view |
| `ArtikelController` | `update()` | Validate, replace file if new upload, update record |
| `ArtikelController` | `destroy()` | Delete thumbnail file, delete record, redirect |

---

## 8. Appendix — Summary Reference

### 8.1 Technology Stack Summary

| Layer | Technology | Version |
|---|---|---|
| Language | PHP | 8.2+ |
| Framework | Laravel | 11.x |
| ORM | Eloquent | (bundled) |
| Template Engine | Blade | (bundled) |
| CSS Framework | Bootstrap | 5.3 |
| Icons | Bootstrap Icons | Latest CDN |
| Database | MySQL / MariaDB | 8.0+ |
| Auth Mechanism | Laravel Session Auth | Custom Guard |
| Password Hashing | Bcrypt | (built-in) |
| File Storage | Laravel Storage | Public Disk |

### 8.2 Security Checklist

| Security Concern | Implementation | Status |
|---|---|---|
| Plaintext passwords | Bcrypt hashing via `bcrypt()` | Required |
| Mass assignment | `$fillable` on all models | Required |
| CSRF attacks | `@csrf` on all forms | Required |
| Unauthorized route access | `auth` middleware on all dashboard routes | Required |
| Login page access for authed users | `guest` middleware on login routes | Required |
| Session fixation | `session()->regenerate()` on login | Required |
| Orphaned media files | Physical delete on record destroy/update | Required |
| File type validation | `mimes:` validation rule on uploads | Required |
| SQL injection | Eloquent ORM (parameterized queries) | Inherent |
| XSS | Blade `{{ }}` auto-escaping | Inherent |

### 8.3 Naming Conventions

| Element | Convention | Example |
|---|---|---|
| Table names | snake_case, plural | `kategori_artikel` |
| Model names | PascalCase, singular | `KategoriArtikel` |
| Controller names | PascalCase + Controller suffix | `ArtikelController` |
| Route names | dot-notation resource | `artikel.index` |
| View files | snake_case | `create.blade.php` |
| Blade layouts | Nested in `layouts/` | `layouts/app.blade.php` |
| Uploaded files | `uniqid()_time().ext` | `64f3a9_1693876145.jpg` |
| Storage folders | lowercase singular | `foto/`, `gambar/` |

---

*End of Document — DESIGN.md v1.0.0*
*Prepared for pre-implementation engineering review.*
