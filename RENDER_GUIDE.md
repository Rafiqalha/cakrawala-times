# Panduan Deploy ke Render.com (Gratis)

## Persiapan

Pastikan project sudah di-push ke GitHub.

---

## 1. Buat Akun Render

1. Buka [render.com](https://render.com)
2. Klik **"Get Started"** → Login via **GitHub**

---

## 2. Buat Database PostgreSQL (Free Tier)

```text
Dashboard → New → PostgreSQL
```

Isi:

| Field | Value |
|-------|-------|
| Name | `cakrawala-db` |
| Database | `cakrawala` |
| User | `cakrawala_user` |
| Region | `Singapore` (terdekat) |

Klik **"Create Database"**. Tunggu hingga status `Available`.

Setelah jadi, simpan **Internal Database URL** (nantinya dipakai untuk koneksi dari Web Service).

---

## 3. Buat Web Service

```text
Dashboard → New → Web Service
```

Pilih repository GitHub **cakrawala-times**.

### Konfigurasi Web Service

| Field | Value |
|-------|-------|
| **Name** | `cakrawala-times` |
| **Region** | `Singapore` |
| **Branch** | `main` |
| **Runtime** | `Docker` (Render otomatis deteksi Laravel) |
| **Build Command** | `composer install --no-dev --optimize-autoloader` |
| **Start Command** | `bash start.sh` |
| **Plan** | **Free** |

---

## 4. Set Environment Variables

Di tab **Environment** Web Service, tambahkan:

```env
APP_KEY=base64:xxxxxxxxxxxxx     # Generate: php artisan key:generate --show
APP_ENV=production
APP_DEBUG=false
APP_URL=https://cakrawala-times.onrender.com

DB_CONNECTION=pgsql
DB_DATABASE=cakrawala
DB_HOST=<Internal Database URL dari PostgreSQL>
DB_PORT=5432
DB_USERNAME=cakrawala_user
DB_PASSWORD=<password dari PostgreSQL>

LOG_CHANNEL=stack
LOG_LEVEL=warning
```

> **Catatan:** Render PostgreSQL gratis. Karena project ini pakai MySQL, saya sudah konfirmasi migration compatible dengan PostgreSQL. Semua tipe data (`id()`, `string()`, `text()`, `date()`, `foreignId()`) work.

---

## 5. Deploy

Klik **"Create Web Service"**.

Render akan otomatis:
- Clone repo dari GitHub
- Install Composer dependencies
- Jalankan `bash start.sh` → migrate + storage:link + serve

---

## 6. Storage Link untuk Gambar

`start.sh` sudah otomatis menjalankan `php artisan storage:link`.

Tapi di Render, file upload akan hilang setiap redeploy karena filesystem ephemeral. Solusi:

**Opsi A: Pakai Cloudinary (Gratis 25GB)**

```bash
composer require cloudinary-labs/cloudinary-laravel
```

Set `CLOUDINARY_URL` di env Render.

**Opsi B: Upload via Render Dashboard → Disk → Persistent Disk** (mulai $0.04/jam)

Untuk demo/mahasiswa, Opsi A lebih praktis.

---

## 7. Verifikasi

- Buka `https://cakrawala-times.onrender.com` — Beranda publik
- Buka `https://cakrawala-times.onrender.com/login` — Login admin
- Buat penulis pertama via Shell: `php artisan tinker` → `Penulis::create([...])`

---

## Catatan Penting

| Hal | Detail |
|-----|--------|
| **Free tier limit** | 750 jam/bulan (≈ 24/24 sebulan penuh) |
| **Sleep policy** | Web Service akan sleep jika tidak ada request 15 menit |
| **DB storage** | 1 GB gratis |
| **Redeploy** | Auto-deploy setiap push ke branch `main` |
| **File upload** | Hilang saat redeploy — pakai Cloudinary |
| **Domain** | `*.onrender.com` gratis (bisa custom domain) |

---

## Troubleshooting

**Q: App gagal start?**
→ Cek log di Render Dashboard → Logs. Pastikan `start.sh` ada dan executable.

**Q: Migration error?**
→ Jalankan manual via Render Shell: `php artisan migrate --force`

**Q: Storage link error?**
→ `php artisan storage:link || true` di `start.sh` sudah meng-handle ini.

**Q: PostgreSQL connection refused?**
→ Pastikan Web Service dan PostgreSQL di Region yang sama (Singapore).

---

## Quick Compare: Render vs Railway

| Aspek | Render | Railway |
|-------|--------|---------|
| Free DB | PostgreSQL 1GB | MySQL 1GB |
| Build | Nixpacks / Docker | Nixpacks |
| Sleep | 15 menit idle | Tidak sleep |
| File upload | Perlu Cloudinary | Perlu Cloudinary |
| Setup | Sederhana | Lebih sederhana |
| Region | Singapore | US/Europe |
