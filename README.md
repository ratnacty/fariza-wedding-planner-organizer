# Fariza Wedding Organizer

Website wedding organizer dibangun dengan **Laravel + Blade + Tailwind CSS + Alpine.js + MySQL**. Punya halaman publik yang interaktif (hero slider, katalog paket, galeri, kalender ketersediaan booking) dan panel admin sederhana untuk mengelola konten.

## Fitur

**Publik**
- Hero slider otomatis
- Tentang kami & layanan (Wedding Organizer, Makeup Artist)
- Katalog paket wedding (Silver / Gold / Platinum) + halaman detail
- Galeri foto
- Kalender ketersediaan booking (tersedia / terbooking / penuh) yang terhubung langsung dengan data booking
- Form booking survei — submit via AJAX tanpa reload halaman, lengkap validasi real-time

**Admin** (`/login`)
- Dashboard ringkasan
- CRUD paket wedding, termasuk upload foto cover
- Kelola galeri (upload foto)
- Kelola status booking yang masuk
- Tutup tanggal tertentu di kalender (misal hari libur)

## Tech Stack

| Bagian | Teknologi |
|---|---|
| Backend | Laravel (PHP) |
| Template | Blade |
| Styling | Tailwind CSS |
| Interaktivitas | Alpine.js |
| Database | MySQL |
| Build tool | Vite |

---

## Menjalankan di Lokal

### 1. Prasyarat

Pastikan sudah terinstall di komputer Anda:

- **PHP** >= 8.2 beserta ekstensi umum (`mbstring`, `xml`, `curl`, `pdo_mysql`, `gd`, `zip`, `bcmath`, `intl`)
- **Composer** ([getcomposer.org](https://getcomposer.org))
- **Node.js** & **npm** (versi LTS terbaru disarankan)
- **MySQL** (atau MariaDB) yang sudah berjalan

Cek versi yang terpasang:

```bash
php -v
composer -V
node -v
npm -v
mysql --version
```

### 2. Clone repository

```bash
git clone https://github.com/<username-anda>/fariza-wedding-organizer.git
cd fariza-wedding-organizer
```

### 3. Install dependency

```bash
composer install
npm install
```

### 4. Siapkan file environment

```bash
cp .env.example .env
php artisan key:generate
```

Buka file `.env`, sesuaikan bagian database dengan kredensial MySQL Anda:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fariza_wedding
DB_USERNAME=root
DB_PASSWORD=isi_password_anda
```

> **Catatan port MySQL:** kalau di komputer Anda MySQL berjalan di port lain (misalnya karena bentrok dengan aplikasi lain), sesuaikan `DB_PORT` sesuai kondisi masing-masing.

### 5. Buat database

Login ke MySQL lalu buat database kosong:

```sql
CREATE DATABASE fariza_wedding CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 6. Migrasi & seed data contoh

```bash
php artisan migrate --seed
```

Perintah ini akan membuat semua tabel sekaligus mengisi data contoh: akun admin, layanan, paket wedding, hero slide, dan galeri.

### 7. Buat symlink storage (untuk fitur upload foto)

```bash
php artisan storage:link
```

### 8. Build asset frontend

```bash
npm run build
```

Untuk development dengan auto-reload saat mengubah file CSS/JS, gunakan `npm run dev` di terminal terpisah sebagai gantinya.

### 9. Jalankan server

```bash
php artisan serve
```

Buka **http://localhost:8000** di browser.

---

## Login Admin (default seed)

| | |
|---|---|
| URL | `/login` |
| Email | `admin@farizawedding.test` |
| Password | `password` |

> **Penting:** ganti email & password admin sebelum deploy ke production (`php artisan tinker` lalu update user, atau lewat halaman Profil setelah login).

---

## Struktur Proyek (ringkas)

```
app/
  Http/Controllers/            # controller publik
  Http/Controllers/Admin/      # controller admin (auth + role admin)
  Http/Requests/                # validasi form booking
  Http/Middleware/              # EnsureUserIsAdmin
  Models/                       # Package, Service, Gallery, Booking, HeroSlide, BlockedDate
  Support/BookingCalendar.php   # logika ketersediaan tanggal
database/
  migrations/                   # skema database
  seeders/                      # data contoh (paket, layanan, galeri, admin)
resources/
  views/public/                 # halaman publik (home, packages, gallery)
  views/public/partials/        # section-section halaman beranda
  views/admin/                  # halaman admin
  views/components/             # app-layout, guest-layout, public-layout, photo-placeholder
  js/app.js                     # Alpine.js: hero slider & booking widget (kalender + form)
routes/web.php                  # semua route publik & admin
```

---

## Konfigurasi Tambahan

- **Kapasitas booking per hari** diatur lewat `BOOKING_DAILY_CAPACITY` di `.env` (default `2`). Kalau jumlah booking di suatu tanggal mencapai angka ini, tanggal tersebut otomatis berstatus "Penuh" di kalender.
- **Ukuran maksimal upload foto** divalidasi 2MB di sisi Laravel. Kalau `upload_max_filesize` di `php.ini` server Anda lebih kecil dari itu, naikkan nilainya atau turunkan batas validasi di `app/Http/Controllers/Admin/PackageController.php` dan `GalleryController.php`.

## Troubleshooting Umum

| Masalah | Solusi |
|---|---|
| `SQLSTATE[HY000] [2002] Connection refused` | Pastikan service MySQL sudah jalan (`sudo systemctl start mysql`) dan `DB_HOST`/`DB_PORT` di `.env` sudah benar. |
| Port 8000 sudah dipakai aplikasi lain | Jalankan dengan port lain: `php artisan serve --port=8080`. |
| Foto hasil upload tidak muncul (404) | Pastikan sudah menjalankan `php artisan storage:link`. |
| Error `Class "PDO" not found` / `could not find driver` | Aktifkan ekstensi `pdo_mysql` di `php.ini`. |
| Tampilan CSS/JS tidak berubah setelah edit | Jalankan ulang `npm run build` (atau pakai `npm run dev` saat development). |

---

## Lisensi

Proyek ini dibuat untuk keperluan internal Fariza Wedding Organizer.
