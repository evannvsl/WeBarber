# WebBarber

**WebBarber** adalah aplikasi web sistem reservasi barbershop yang dibangun sebagai **Proyek Akhir Mata Kuliah Pemrograman Web dan Basis Data**. Aplikasi ini memungkinkan customer memesan jadwal ke barber secara online, lengkap dengan manajemen layanan, jadwal, dan pembayaran.

---

## Fitur Utama

### Customer
- Registrasi dan login akun
- Melihat daftar barber aktif dan layanan yang tersedia
- Membuat booking dengan memilih barber, layanan, tanggal, dan jam
- Riwayat booking beserta status pembayaran
- Edit profil dan ganti password

### Barber
- Dashboard dengan ringkasan booking hari ini
- Melihat jadwal dan riwayat pelayanan

### Admin
- Dashboard statistik (total customer, barber, booking, pendapatan)
- Manajemen user (CRUD)
- Manajemen barber dan jadwal kerja
- Manajemen layanan/servis
- Manajemen booking dan perubahan status
- Pencatatan pembayaran (cash, transfer, QRIS)
- Laporan pendapatan harian & bulanan
- Statistik layanan dan barber terpopuler

---

## Teknologi yang Digunakan

| Komponen | Teknologi |
|---|---|
| Backend Framework | Laravel 11 (PHP) |
| Database | MySQL |
| Frontend | Blade Template + Tailwind CSS |
| Build Tool | Vite |
| Authentication | Laravel built-in Auth |
| Package Manager | Composer + npm |

---

## Struktur Peran (Role)

Sistem menggunakan **single-table inheritance** pada tabel `users` dengan kolom `role`:

| Role | Akses |
|---|---|
| `admin` | Kelola semua data, lihat laporan, catat pembayaran |
| `barber` | Lihat jadwal dan booking yang ditugaskan |
| `customer` | Buat booking, lihat riwayat, kelola profil |

---

## Instalasi & Menjalankan Proyek

### Prasyarat
- PHP >= 8.2
- Composer
- MySQL
- Node.js & npm

### Langkah Instalasi

**1. Clone repositori**
```bash
git clone <url-repo>
cd webarber
```

**2. Install dependensi PHP**
```bash
composer install
```

**3. Install dependensi JavaScript**
```bash
npm install
```

**4. Salin dan konfigurasi environment**
```bash
cp .env.example .env
php artisan key:generate
```


**5. Jalankan migrasi database**
```bash
php artisan migrate
```

**6. Buat symlink storage**
```bash
php artisan storage:link
```

**7. Build asset frontend**
```bash
npm run dev
```

**8. Jalankan server**
```bash
php artisan serve
```

Aplikasi dapat diakses di **http://localhost:8000**

---

## Struktur Database

Aplikasi menggunakan 7 tabel utama:

```
users ──── barbers ──── barber_schedules
               │
          bookings ──── booking_details ──── services
               │
           payments
```

| Tabel | Fungsi |
|---|---|
| `users` | Semua pengguna (admin, barber, customer) |
| `barbers` | Profil dan status barber |
| `services` | Katalog layanan beserta harga dan durasi |
| `barber_schedules` | Jadwal kerja barber per hari |
| `bookings` | Data reservasi customer |
| `booking_details` | Detail layanan per booking (snapshot harga) |
| `payments` | Pencatatan pembayaran |

Dokumentasi lengkap database tersedia di [`DATABASE.md`](DATABASE.md).

---

## Struktur Direktori Utama

```
webarber/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/          # Controller untuk role admin
│   │   ├── Barber/         # Controller untuk role barber
│   │   └── Customer/       # Controller untuk role customer
│   └── Models/             # Eloquent models
├── database/
│   └── migrations/         # Skema database
├── resources/
│   └── views/
│       ├── admin/          # Halaman admin
│       ├── barber/         # Halaman barber
│       ├── customer/       # Halaman customer
│       ├── auth/           # Halaman login & register
│       └── layouts/        # Layout utama
└── routes/
    └── web.php             # Definisi semua route
```

---

## Lisensi

Proyek ini dibuat untuk keperluan akademik — Proyek Akhir Mata Kuliah Pemrograman Web dan Basis Data.
