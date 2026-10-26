# Dokumentasi Database — WeBarber

Aplikasi **WeBarber** adalah sistem reservasi barbershop berbasis Laravel.
Dokumen ini menjelaskan secara lengkap struktur database MySQL, fungsi setiap tabel,
dan cara menambahkan data ke masing-masing tabel.

---

## Daftar Tabel

| No | Tabel | Deskripsi Singkat |
|----|-------|-------------------|
| 1 | `users` | Semua pengguna: admin, barber, customer |
| 2 | `barbers` | Profil detail barber (1-to-1 dengan `users`) |
| 3 | `services` | Daftar layanan/jasa yang ditawarkan |
| 4 | `barber_schedules` | Jadwal kerja harian setiap barber |
| 5 | `bookings` | Data reservasi/booking utama |
| 6 | `booking_details` | Detail layanan per booking (pivot) |
| 7 | `payments` | Data pembayaran tiap booking |
| 8 | `password_reset_tokens` | Token reset password *(Laravel default)* |
| 9 | `sessions` | Sesi login aktif *(Laravel default)* |
| 10 | `cache` | Cache framework *(Laravel default)* |
| 11 | `jobs` | Queue jobs *(Laravel default)* |

---

## Diagram Relasi (ERD)

```
users (1) ──────────────────── (1) barbers
  │                                   │
  │                                   ├──── (many) barber_schedules
  │                                   │
  └──── (many) bookings ──── (many) ──┘
               │
               ├──── (many) booking_details ──── (many) services
               │
               └──── (1) payments
```

### Penjelasan Relasi Eloquent

| From | Relasi | To | Keterangan |
|------|--------|----|------------|
| `User` | `hasOne` | `Barber` | Satu user barber punya satu profil barber |
| `User` | `hasMany` | `Booking` | Customer bisa punya banyak booking |
| `Barber` | `belongsTo` | `User` | Barber milik satu user |
| `Barber` | `hasMany` | `BarberSchedule` | Barber punya banyak jadwal |
| `Barber` | `hasMany` | `Booking` | Barber bisa menerima banyak booking |
| `Booking` | `belongsTo` | `User` | Booking dimiliki satu customer |
| `Booking` | `belongsTo` | `Barber` | Booking ditangani satu barber |
| `Booking` | `hasMany` | `BookingDetail` | Booking bisa punya banyak detail layanan |
| `Booking` | `hasOne` | `Payment` | Booking punya satu pembayaran |
| `BookingDetail` | `belongsTo` | `Booking` | Detail milik satu booking |
| `BookingDetail` | `belongsTo` | `Service` | Detail mereferensikan satu layanan |
| `Payment` | `belongsTo` | `Booking` | Pembayaran milik satu booking |
| `Service` | `hasMany` | `BookingDetail` | Satu layanan bisa muncul di banyak booking |

---

## Urutan Insert yang Benar

Karena ada foreign key, data **harus** dimasukkan dengan urutan berikut:

```
1. users          ← tidak ada dependensi
2. barbers        ← butuh users.id
3. services       ← tidak ada dependensi
4. barber_schedules ← butuh barbers.id
5. bookings       ← butuh users.id + barbers.id
6. booking_details ← butuh bookings.id + services.id
7. payments       ← butuh bookings.id
```

---

## Detail Tiap Tabel

---

### 1. Tabel `users`

#### Fungsi
Menyimpan **semua pengguna** sistem dalam satu tabel. Satu tabel untuk tiga peran:
- **admin** → mengelola sistem, mengkonfirmasi booking, mencatat pembayaran
- **barber** → melihat jadwal dan booking yang diterima
- **customer** → membuat booking dan melihat riwayat

Pemisahan peran dilakukan lewat kolom `role`, bukan tabel terpisah.

#### Struktur Kolom

| Kolom | Tipe | Default | Keterangan |
|-------|------|---------|------------|
| `id` | BIGINT UNSIGNED, PK, AI | — | Primary key otomatis |
| `name` | VARCHAR(100) | — | Nama lengkap pengguna |
| `email` | VARCHAR(100), UNIQUE | — | Email login, harus unik |
| `email_verified_at` | TIMESTAMP, NULL | `null` | Waktu verifikasi email |
| `password` | VARCHAR | — | Password (bcrypt hash, **bukan plaintext**) |
| `role` | ENUM | `'customer'` | Peran: `admin`, `barber`, atau `customer` |
| `phone` | VARCHAR(20), NULL | `null` | Nomor telepon (opsional) |
| `profile_photo_path` | VARCHAR, NULL | `null` | Path foto profil |
| `remember_token` | VARCHAR(100), NULL | `null` | Token "remember me" Laravel |
| `created_at` | TIMESTAMP | — | Waktu dibuat (otomatis) |
| `updated_at` | TIMESTAMP | — | Waktu diupdate (otomatis) |

#### Cara Menambahkan Data

**A. Lewat UI (Halaman Registrasi)**
- Buka `http://localhost:8000/register`
- Isi form → role default akan menjadi `customer`
- Untuk membuat barber/admin, harus diubah lewat panel admin atau Tinker

**B. Lewat Laravel Tinker**
```bash
php artisan tinker
```
```php
// Tambah customer
App\Models\User::create([
    'name'     => 'Budi Santoso',
    'email'    => 'budi@example.com',
    'password' => bcrypt('password123'),
    'role'     => 'customer',
    'phone'    => '081234567890',
]);

// Tambah admin
App\Models\User::create([
    'name'     => 'Admin Baru',
    'email'    => 'admin@webarber.com',
    'password' => bcrypt('Admin123!'),
    'role'     => 'admin',
]);

// Tambah barber (step 1: buat user dulu)
$user = App\Models\User::create([
    'name'     => 'Joko Barber',
    'email'    => 'joko@webarber.com',
    'password' => bcrypt('password123'),
    'role'     => 'barber',
]);
// Lanjut ke tabel barbers (step 2) untuk lengkapi profil barber
```

**C. Lewat SQL Langsung (MySQL)**
```sql
INSERT INTO users (name, email, password, role, phone, created_at, updated_at)
VALUES (
    'Budi Santoso',
    'budi@example.com',
    '$2y$12$...hash_bcrypt...', -- gunakan hash, bukan plaintext!
    'customer',
    '081234567890',
    NOW(),
    NOW()
);
```

> ⚠️ **Jangan masukkan password plaintext lewat SQL.** Gunakan Tinker/Seeder agar password otomatis di-hash dengan `bcrypt()`.

**D. Lewat Seeder**

Edit file `database/seeders/DatabaseSeeder.php` atau buat seeder baru:
```bash
php artisan make:seeder UserSeeder
```
```php
// database/seeders/UserSeeder.php
public function run(): void
{
    User::create([
        'name'     => 'Budi Santoso',
        'email'    => 'budi@example.com',
        'password' => Hash::make('password123'),
        'role'     => 'customer',
    ]);
}
```
```bash
php artisan db:seed --class=UserSeeder
```

---

### 2. Tabel `barbers`

#### Fungsi
Menyimpan **informasi profil tambahan** khusus untuk pengguna berperan `barber`.
Setiap barber **wajib** punya satu baris di tabel `users` (dengan `role = 'barber'`)
terlebih dahulu, baru kemudian dibuat entri di tabel ini.

#### Struktur Kolom

| Kolom | Tipe | Default | Keterangan |
|-------|------|---------|------------|
| `id` | BIGINT UNSIGNED, PK, AI | — | Primary key otomatis |
| `user_id` | BIGINT UNSIGNED, FK → `users.id` | — | **Wajib** ada di tabel users terlebih dahulu |
| `specialty` | VARCHAR(100), NULL | `null` | Keahlian (contoh: "Fade", "Pompadour") |
| `bio` | TEXT, NULL | `null` | Deskripsi/biodata barber |
| `is_active` | BOOLEAN | `true` | Jika `false`, barber tidak muncul di pilihan customer |
| `created_at` | TIMESTAMP | — | Otomatis |
| `updated_at` | TIMESTAMP | — | Otomatis |

**Constraint:** `user_id` CASCADE ON DELETE — jika user dihapus, data barber ikut terhapus.

#### Cara Menambahkan Data

**A. Lewat UI (Panel Admin)**
- Login sebagai admin → menu **Barber** → **Tambah Barber**
- Form akan otomatis membuat user + barber sekaligus

**B. Lewat Laravel Tinker**
```bash
php artisan tinker
```
```php
// Pastikan user sudah ada terlebih dahulu!
$user = App\Models\User::where('email', 'joko@webarber.com')->first();

App\Models\Barber::create([
    'user_id'   => $user->id,
    'specialty' => 'Fade & Undercut',
    'bio'       => 'Barber berpengalaman 5 tahun, spesialis fade.',
    'is_active' => true,
]);
```

**C. Lewat SQL**
```sql
-- Pastikan user_id = 5 sudah ada di tabel users
INSERT INTO barbers (user_id, specialty, bio, is_active, created_at, updated_at)
VALUES (5, 'Fade & Undercut', 'Barber berpengalaman 5 tahun.', 1, NOW(), NOW());
```

**D. Lewat Seeder**
```php
// Buat user barber dulu, lalu buat profil barber
$user = User::create([
    'name'     => 'Joko Barber',
    'email'    => 'joko@webarber.com',
    'password' => Hash::make('password123'),
    'role'     => 'barber',
]);

Barber::create([
    'user_id'   => $user->id,
    'specialty' => 'Fade & Undercut',
    'bio'       => 'Spesialis fade dan undercut.',
    'is_active' => true,
]);
```

---

### 3. Tabel `services`

#### Fungsi
Katalog **semua layanan** yang bisa dipesan oleh customer (contoh: Potong Rambut, Cukur Jenggot, Creambath).
Tabel ini berdiri sendiri, tidak bergantung pada tabel lain.

#### Struktur Kolom

| Kolom | Tipe | Default | Keterangan |
|-------|------|---------|------------|
| `id` | BIGINT UNSIGNED, PK, AI | — | Primary key otomatis |
| `name` | VARCHAR(100) | — | Nama layanan |
| `description` | TEXT, NULL | `null` | Deskripsi layanan |
| `price` | DECIMAL(10,2) | — | Harga dalam rupiah (contoh: `35000.00`) |
| `duration_minutes` | INT | — | Durasi pengerjaan dalam menit |
| `category` | VARCHAR/ENUM | — | Kategori layanan (ditambah via migration terpisah) |
| `is_active` | BOOLEAN | `true` | Jika `false`, layanan tidak tampil ke customer |
| `created_at` | TIMESTAMP | — | Otomatis |
| `updated_at` | TIMESTAMP | — | Otomatis |

#### Cara Menambahkan Data

**A. Lewat UI (Panel Admin)**
- Login sebagai admin → menu **Layanan** → **Tambah Layanan**

**B. Lewat Laravel Tinker**
```bash
php artisan tinker
```
```php
App\Models\Service::create([
    'name'             => 'Potong Rambut',
    'description'      => 'Potong rambut reguler sesuai keinginan pelanggan.',
    'price'            => 35000,
    'duration_minutes' => 30,
    'is_active'        => true,
]);

App\Models\Service::create([
    'name'             => 'Cukur Jenggot',
    'description'      => 'Penataan dan pencukuran jenggot.',
    'price'            => 25000,
    'duration_minutes' => 20,
    'is_active'        => true,
]);
```

**C. Lewat SQL**
```sql
INSERT INTO services (name, description, price, duration_minutes, is_active, created_at, updated_at)
VALUES
    ('Potong Rambut', 'Potong rambut reguler.', 35000.00, 30, 1, NOW(), NOW()),
    ('Cukur Jenggot', 'Penataan jenggot.', 25000.00, 20, 1, NOW(), NOW()),
    ('Creambath', 'Perawatan rambut dengan krim.', 50000.00, 45, 1, NOW(), NOW());
```

**D. Lewat Seeder**
```php
$services = [
    ['name' => 'Potong Rambut', 'price' => 35000, 'duration_minutes' => 30],
    ['name' => 'Cukur Jenggot', 'price' => 25000, 'duration_minutes' => 20],
    ['name' => 'Creambath',     'price' => 50000, 'duration_minutes' => 45],
];

foreach ($services as $s) {
    Service::create(array_merge($s, ['is_active' => true]));
}
```

---

### 4. Tabel `barber_schedules`

#### Fungsi
Menyimpan **jadwal kerja** setiap barber untuk setiap hari dalam seminggu (7 hari).
Digunakan sistem untuk menentukan kapan barber tersedia saat customer ingin booking.
Setiap barber idealnya punya **7 baris** (satu per hari), dengan hari libur ditandai `is_day_off = true`.

#### Struktur Kolom

| Kolom | Tipe | Default | Keterangan |
|-------|------|---------|------------|
| `id` | BIGINT UNSIGNED, PK, AI | — | Primary key otomatis |
| `barber_id` | BIGINT UNSIGNED, FK → `barbers.id` | — | **Wajib** ada di tabel barbers |
| `day_of_week` | TINYINT | — | `1`=Senin, `2`=Selasa, ..., `7`=Minggu |
| `start_time` | TIME, NULL | `null` | Jam mulai (contoh: `08:00:00`) |
| `end_time` | TIME, NULL | `null` | Jam selesai (contoh: `17:00:00`) |
| `is_day_off` | BOOLEAN | `false` | `true` = barber libur di hari ini |
| `created_at` | TIMESTAMP | — | Otomatis |
| `updated_at` | TIMESTAMP | — | Otomatis |

**Constraint:** `barber_id` CASCADE ON DELETE.

#### Cara Menambahkan Data

**A. Lewat UI (Panel Admin)**
- Login sebagai admin → menu **Barber** → pilih barber → **Atur Jadwal**

**B. Lewat Laravel Tinker**
```bash
php artisan tinker
```
```php
$barber = App\Models\Barber::first(); // ambil barber pertama

// Buat jadwal Senin-Jumat kerja, Sabtu-Minggu libur
for ($day = 1; $day <= 7; $day++) {
    App\Models\BarberSchedule::create([
        'barber_id'  => $barber->id,
        'day_of_week'=> $day,
        'start_time' => ($day <= 5) ? '08:00:00' : null,
        'end_time'   => ($day <= 5) ? '17:00:00' : null,
        'is_day_off' => ($day >= 6),  // Sabtu & Minggu = libur
    ]);
}
```

**C. Lewat SQL**
```sql
-- Jadwal untuk barber_id = 1 (Senin-Jumat kerja, Sabtu-Minggu libur)
INSERT INTO barber_schedules (barber_id, day_of_week, start_time, end_time, is_day_off, created_at, updated_at)
VALUES
    (1, 1, '08:00:00', '17:00:00', 0, NOW(), NOW()),  -- Senin
    (1, 2, '08:00:00', '17:00:00', 0, NOW(), NOW()),  -- Selasa
    (1, 3, '08:00:00', '17:00:00', 0, NOW(), NOW()),  -- Rabu
    (1, 4, '08:00:00', '17:00:00', 0, NOW(), NOW()),  -- Kamis
    (1, 5, '08:00:00', '17:00:00', 0, NOW(), NOW()),  -- Jumat
    (1, 6, NULL,        NULL,       1, NOW(), NOW()),  -- Sabtu (libur)
    (1, 7, NULL,        NULL,       1, NOW(), NOW());  -- Minggu (libur)
```

---

### 5. Tabel `bookings`

#### Fungsi
Tabel **utama reservasi**. Setiap baris merepresentasikan satu sesi booking dari
seorang customer ke satu barber pada tanggal dan jam tertentu.
Tabel ini membutuhkan `users.id` (customer) dan `barbers.id` yang sudah ada.

#### Struktur Kolom

| Kolom | Tipe | Default | Keterangan |
|-------|------|---------|------------|
| `id` | BIGINT UNSIGNED, PK, AI | — | Primary key otomatis |
| `user_id` | BIGINT UNSIGNED, FK → `users.id` | — | Customer yang booking |
| `barber_id` | BIGINT UNSIGNED, FK → `barbers.id` | — | Barber yang dipilih |
| `booking_date` | DATE | — | Tanggal booking (format: `YYYY-MM-DD`) |
| `start_time` | TIME | — | Jam mulai sesi (format: `HH:MM:SS`) |
| `end_time` | TIME | — | Jam selesai (dihitung dari total durasi layanan) |
| `status` | ENUM | `'pending'` | Status: `pending`, `confirmed`, `completed`, `cancelled` |
| `notes` | TEXT, NULL | `null` | Catatan tambahan dari customer |
| `created_at` | TIMESTAMP | — | Otomatis |
| `updated_at` | TIMESTAMP | — | Otomatis |

**Status Flow:**
```
pending → confirmed → completed
       ↘              ↗
         cancelled
```

**Constraint:** `user_id` dan `barber_id` CASCADE ON DELETE.

#### Cara Menambahkan Data

**A. Lewat UI (Halaman Customer)**
- Login sebagai customer → **Buat Booking** → pilih barber, tanggal, jam, layanan

**B. Lewat Laravel Tinker**
```bash
php artisan tinker
```
```php
$customer = App\Models\User::where('role', 'customer')->first();
$barber   = App\Models\Barber::first();

App\Models\Booking::create([
    'user_id'      => $customer->id,
    'barber_id'    => $barber->id,
    'booking_date' => '2026-11-01',
    'start_time'   => '10:00:00',
    'end_time'     => '10:30:00',  // start + total durasi layanan
    'status'       => 'pending',
    'notes'        => 'Tolong rapikan sisi kiri lebih pendek.',
]);
```

**C. Lewat SQL**
```sql
INSERT INTO bookings (user_id, barber_id, booking_date, start_time, end_time, status, notes, created_at, updated_at)
VALUES (3, 1, '2026-11-01', '10:00:00', '10:30:00', 'pending', NULL, NOW(), NOW());
```

> ⚠️ Setelah insert ke `bookings`, **wajib** insert juga ke `booking_details` agar data layanan tercatat.

---

### 6. Tabel `booking_details`

#### Fungsi
Tabel **pivot** antara `bookings` dan `services`. Satu booking bisa memiliki lebih dari satu layanan.
Kolom `price` adalah **snapshot harga saat booking dilakukan** — bukan mengacu langsung ke `services.price`.
Ini memastikan riwayat transaksi lama tidak berubah meski harga layanan di-update kemudian.

#### Struktur Kolom

| Kolom | Tipe | Default | Keterangan |
|-------|------|---------|------------|
| `id` | BIGINT UNSIGNED, PK, AI | — | Primary key otomatis |
| `booking_id` | BIGINT UNSIGNED, FK → `bookings.id` | — | **Wajib** ada di tabel bookings |
| `service_id` | BIGINT UNSIGNED, FK → `services.id` | — | **Wajib** ada di tabel services |
| `quantity` | INT | `1` | Jumlah layanan (biasanya selalu 1) |
| `price` | DECIMAL(10,2) | — | **Snapshot harga** saat booking dibuat |
| `created_at` | TIMESTAMP | — | Otomatis |
| `updated_at` | TIMESTAMP | — | Otomatis |

**Constraint:**
- `booking_id` CASCADE ON DELETE (booking dihapus → detail ikut terhapus)
- `service_id` RESTRICT ON DELETE (layanan tidak bisa dihapus jika masih ada di booking detail)

#### Cara Menambahkan Data

**A. Otomatis lewat UI**
- Saat customer submit booking, sistem otomatis insert ke tabel ini

**B. Lewat Laravel Tinker**
```bash
php artisan tinker
```
```php
$booking = App\Models\Booking::latest()->first();
$service = App\Models\Service::where('name', 'Potong Rambut')->first();

App\Models\BookingDetail::create([
    'booking_id' => $booking->id,
    'service_id' => $service->id,
    'quantity'   => 1,
    'price'      => $service->price,  // snapshot harga saat ini
]);
```

**C. Lewat SQL**
```sql
-- booking_id = 1, service_id = 1, harga snapshot 35000
INSERT INTO booking_details (booking_id, service_id, quantity, price, created_at, updated_at)
VALUES (1, 1, 1, 35000.00, NOW(), NOW());

-- Tambah layanan kedua ke booking yang sama
INSERT INTO booking_details (booking_id, service_id, quantity, price, created_at, updated_at)
VALUES (1, 2, 1, 25000.00, NOW(), NOW());
```

**D. Dalam Transaksi (Cara yang Benar di Aplikasi)**
```php
// Dibungkus transaksi agar atomik
DB::transaction(function () use ($data, $services) {
    $booking = Booking::create([
        'user_id'      => $data['user_id'],
        'barber_id'    => $data['barber_id'],
        'booking_date' => $data['date'],
        'start_time'   => $data['start'],
        'end_time'     => $data['end'],
        'status'       => 'pending',
    ]);

    foreach ($services as $service) {
        BookingDetail::create([
            'booking_id' => $booking->id,
            'service_id' => $service->id,
            'quantity'   => 1,
            'price'      => $service->price, // snapshot harga
        ]);
    }
});
```

---

### 7. Tabel `payments`

#### Fungsi
Menyimpan **data pembayaran** untuk setiap booking yang sudah selesai atau sedang diproses.
Satu booking memiliki satu data payment. Biasanya dibuat oleh admin setelah barber menyelesaikan layanan.

#### Struktur Kolom

| Kolom | Tipe | Default | Keterangan |
|-------|------|---------|------------|
| `id` | BIGINT UNSIGNED, PK, AI | — | Primary key otomatis |
| `booking_id` | BIGINT UNSIGNED, FK → `bookings.id` | — | **Wajib** ada di tabel bookings |
| `amount` | DECIMAL(10,2) | — | Total jumlah yang dibayar |
| `payment_method` | ENUM | `'cash'` | Metode: `cash`, `transfer`, `qris` |
| `payment_status` | ENUM | `'pending'` | Status: `pending`, `paid`, `failed`, `refunded` |
| `paid_at` | TIMESTAMP, NULL | `null` | Waktu pembayaran berhasil (diisi saat `payment_status = 'paid'`) |
| `created_at` | TIMESTAMP | — | Otomatis |
| `updated_at` | TIMESTAMP | — | Otomatis |

**Constraint:** `booking_id` CASCADE ON DELETE.

#### Cara Menambahkan Data

**A. Lewat UI (Panel Admin)**
- Login sebagai admin → menu **Booking** → pilih booking → **Catat Pembayaran**

**B. Lewat Laravel Tinker**
```bash
php artisan tinker
```
```php
$booking = App\Models\Booking::find(1);

// Catat pembayaran tunai yang sudah lunas
App\Models\Payment::create([
    'booking_id'     => $booking->id,
    'amount'         => 60000,   // total dari semua layanan
    'payment_method' => 'cash',
    'payment_status' => 'paid',
    'paid_at'        => now(),
]);

// Update status booking menjadi completed
$booking->update(['status' => 'completed']);
```

**C. Lewat SQL**
```sql
-- Catat pembayaran untuk booking_id = 1
INSERT INTO payments (booking_id, amount, payment_method, payment_status, paid_at, created_at, updated_at)
VALUES (1, 60000.00, 'cash', 'paid', NOW(), NOW(), NOW());

-- Update status booking menjadi completed
UPDATE bookings SET status = 'completed', updated_at = NOW() WHERE id = 1;
```

---

---

## Tabel-Tabel Laravel Default (8–11)

Tabel-tabel berikut dibuat otomatis oleh Laravel melalui migration bawaan
dan **tidak perlu diisi secara manual**. Data di dalamnya dikelola sepenuhnya
oleh framework. Namun penting untuk memahami fungsi dan isi setiap tabel agar
bisa men-debug masalah autentikasi, performa, dan background job.

Ringkasan konfigurasi di `.env` project ini:

```env
SESSION_DRIVER=database   → sesi login disimpan di tabel `sessions`
CACHE_STORE=database      → cache disimpan di tabel `cache` & `cache_locks`
QUEUE_CONNECTION=database → antrian job disimpan di tabel `jobs` & turunannya
```

---

### 8. Tabel `password_reset_tokens`

#### Fungsi
Menyimpan **token sementara** yang dikirim ke email user ketika mereka klik
tombol "Lupa Password". Token ini digunakan untuk memverifikasi identitas user
sebelum mengizinkan reset password.

#### Struktur Kolom

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `email` | VARCHAR, **Primary Key** | Email user yang meminta reset. Satu email = satu token aktif |
| `token` | VARCHAR | Token acak (sudah di-hash bcrypt), dikirim via link di email |
| `created_at` | TIMESTAMP, NULL | Waktu token dibuat, digunakan untuk cek kadaluarsa |

#### Cara Kerja

```
1. User klik "Lupa Password" → isi email
        │
        ▼
2. Laravel buat token acak → hash dengan bcrypt → simpan di tabel ini
        │
        ▼
3. Laravel kirim email berisi link:
   http://localhost:8000/reset-password/{token}?email=user@example.com
        │
        ▼
4. User klik link → masukkan password baru
        │
        ▼
5. Laravel verifikasi token (compare hash) → jika cocok, password diupdate
        │
        ▼
6. Baris di tabel ini DIHAPUS otomatis (token sudah terpakai)
```

#### Kapan Data Ditambah & Dihapus

| Kejadian | Aksi pada Tabel |
|----------|----------------|
| User submit form "Lupa Password" | **INSERT** baris baru (atau UPDATE jika email sudah ada) |
| User berhasil reset password | **DELETE** baris (token dipakai sekali lalu hangus) |
| Token kedaluarsa (default 60 menit) | **DELETE** saat `php artisan auth:clear-resets` dijalankan |

#### Isi Data Contoh

```sql
SELECT * FROM password_reset_tokens;
-- +----------------------+--------------------------------------------------------------+---------------------+
-- | email                | token                                                        | created_at          |
-- +----------------------+--------------------------------------------------------------+---------------------+
-- | budi@example.com     | $2y$12$abc...hash_token...xyz                               | 2026-10-27 05:00:00 |
-- +----------------------+--------------------------------------------------------------+---------------------+
```

> ⚠️ Token yang tersimpan **sudah di-hash** (bukan token asli). Token asli hanya ada di link email yang dikirim ke user.

#### Perintah Berguna

```bash
# Hapus semua token yang sudah kedaluarsa (jalankan via scheduler)
php artisan auth:clear-resets

# Lihat isi tabel via Tinker
php artisan tinker
>>> DB::table('password_reset_tokens')->get();
```

#### Konfigurasi Kadaluarsa (config/auth.php)

```php
'passwords' => [
    'users' => [
        'expire' => 60,    // token kedaluarsa setelah 60 menit
        'throttle' => 60,  // user hanya bisa minta ulang setelah 60 detik
    ],
],
```

---

### 9. Tabel `sessions`

#### Fungsi
Menyimpan **sesi login aktif** setiap pengguna. Karena di `.env` diatur
`SESSION_DRIVER=database`, Laravel menyimpan session ke tabel ini alih-alih ke file.
Setiap kali user login, Laravel membuat satu baris di sini. Saat logout atau
session expired, baris tersebut dihapus.

#### Struktur Kolom

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id` | VARCHAR, **Primary Key** | ID sesi unik (string acak panjang, bukan auto-increment) |
| `user_id` | BIGINT UNSIGNED, NULL | ID user yang login (NULL jika guest/belum login) |
| `ip_address` | VARCHAR(45), NULL | IP address perangkat yang login |
| `user_agent` | TEXT, NULL | Browser/device info (contoh: `Mozilla/5.0 ...`) |
| `payload` | LONGTEXT | Data sesi (di-encrypt & di-encode base64): berisi user ID, token CSRF, flash messages, dll |
| `last_activity` | INT | Unix timestamp terakhir kali sesi diakses, dipakai untuk cek expired |

#### Cara Kerja

```
1. User buka website → Laravel cek cookie "laravel_session" di browser
        │
        ▼
2a. Cookie ADA & valid → Laravel ambil data dari tabel sessions (WHERE id = cookie_value)
2b. Cookie TIDAK ADA  → Laravel buat baris baru di tabel sessions (sesi guest)
        │
        ▼
3. User berhasil login → kolom user_id diupdate dengan ID user
        │
        ▼
4. Setiap request → kolom last_activity diupdate (Unix timestamp)
        │
        ▼
5a. User logout → baris sessions DIHAPUS
5b. Tidak ada aktivitas > 120 menit (SESSION_LIFETIME) → sesi dianggap expired
```

#### Kapan Data Ditambah & Dihapus

| Kejadian | Aksi pada Tabel |
|----------|----------------|
| User pertama kali buka website | **INSERT** baris baru (sesi guest, `user_id = null`) |
| User berhasil login | **UPDATE** `user_id` di baris yang sudah ada |
| Setiap page request | **UPDATE** `last_activity` |
| User klik Logout | **DELETE** baris sesi tersebut |
| Sesi expired (timeout) | **DELETE** saat Laravel menjalankan pembersihan sesi |

#### Isi Data Contoh

```sql
SELECT id, user_id, ip_address, last_activity FROM sessions;
-- +------------------+---------+---------------+---------------+
-- | id               | user_id | ip_address    | last_activity |
-- +------------------+---------+---------------+---------------+
-- | xKj8f2LmNpQrSt.. |    NULL | 192.168.1.10  |  1761523200   | ← guest
-- | aB3cD4eF5gH6iJ.. |       1 | 192.168.1.10  |  1761523500   | ← admin login
-- | mN7oP8qR9sT0uV.. |       3 | 192.168.1.25  |  1761523800   | ← customer login
-- +------------------+---------+---------------+---------------+
```

#### Perintah Berguna

```bash
# Paksa logout SEMUA user (hapus semua sesi) — berguna saat deploy/update besar
php artisan session:clear

# Lihat semua sesi aktif via Tinker
php artisan tinker
>>> DB::table('sessions')->whereNotNull('user_id')->get(['user_id','ip_address','last_activity']);

# Lihat jumlah user yang sedang online
>>> DB::table('sessions')->whereNotNull('user_id')->distinct('user_id')->count();
```

#### Konfigurasi di `.env`

```env
SESSION_DRIVER=database    # simpan ke tabel sessions (bukan file/cookie/redis)
SESSION_LIFETIME=120       # sesi expired setelah 120 menit tidak aktif
SESSION_ENCRYPT=false      # payload tidak dienkripsi tambahan (sudah aman di server)
SESSION_PATH=/             # cookie berlaku untuk semua path
SESSION_DOMAIN=null        # cookie berlaku untuk domain yang sama
```

> 💡 **Keuntungan `SESSION_DRIVER=database`** dibanding `file`:
> - Bisa lihat siapa saja yang sedang online lewat query SQL
> - Aman di environment multi-server (tidak ada masalah sesi hilang saat pindah server)
> - Mudah di-invalidate secara massal (cukup `DELETE FROM sessions`)

---

### 10. Tabel `cache` & `cache_locks`

#### Fungsi
Karena `.env` mengatur `CACHE_STORE=database`, Laravel menyimpan semua
**data cache** ke tabel ini. Cache digunakan untuk menyimpan hasil komputasi
yang mahal agar tidak perlu diulang setiap request.

Contoh data yang dicache di WeBarber:
- Daftar layanan aktif (agar tidak query ke DB setiap halaman booking dibuka)
- Statistik dashboard (total customer, total revenue, dll)
- Rate limiting data (pembatasan login gagal)

#### Struktur Tabel `cache`

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `key` | VARCHAR, **Primary Key** | Kunci unik cache (contoh: `services_active`, `dashboard_stats`) |
| `value` | MEDIUMTEXT | Nilai yang dicache (di-serialize PHP) |
| `expiration` | BIGINT | Unix timestamp kapan cache ini kedaluarsa |

#### Struktur Tabel `cache_locks`

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `key` | VARCHAR, **Primary Key** | Nama lock unik |
| `owner` | VARCHAR | ID proses yang memegang lock |
| `expiration` | BIGINT | Unix timestamp kapan lock otomatis dilepas |

> `cache_locks` dipakai untuk **atomic locks** — mencegah race condition saat dua request
> bersamaan mencoba menjalankan proses yang sama (contoh: dua request booking barber di waktu yang sama).

#### Cara Kerja Cache

```
Request 1: GET /dashboard
        │
        ▼
Laravel cek tabel cache WHERE key = 'dashboard_stats' AND expiration > NOW()
        │
        ├── Ditemukan & belum expired → ambil value dari cache (cepat!)
        │
        └── Tidak ditemukan / expired → jalankan query ke DB
                │
                ▼
            Hasil query DISIMPAN ke tabel cache
            dengan expiration = NOW() + durasi cache
```

#### Cara Kerja di Kode Laravel

```php
// Simpan ke cache selama 10 menit
Cache::put('dashboard_stats', $stats, now()->addMinutes(10));

// Ambil dari cache (atau jalankan query jika belum ada)
$stats = Cache::remember('dashboard_stats', now()->addMinutes(10), function () {
    return [
        'total_customers' => User::where('role', 'customer')->count(),
        'total_revenue'   => Payment::where('payment_status', 'paid')->sum('amount'),
    ];
});

// Hapus cache tertentu (misal setelah data diupdate)
Cache::forget('dashboard_stats');

// Hapus semua cache
Cache::flush();
```

#### Isi Data Contoh

```sql
SELECT key, expiration FROM cache;
-- +----------------------------------+------------+
-- | key                              | expiration |
-- +----------------------------------+------------+
-- | laravel_cache_dashboard_stats    | 1761524400 |
-- | laravel_cache_services_active    | 1761524700 |
-- | laravel_cache_rate_limit:login:1 | 1761523260 |
-- +----------------------------------+------------+
```

#### Perintah Berguna

```bash
# Hapus semua cache (wajib dijalankan setelah ubah konfigurasi!)
php artisan cache:clear

# Hapus cache tertentu via Tinker
php artisan tinker
>>> Cache::forget('dashboard_stats');

# Lihat semua isi cache
>>> DB::table('cache')->get(['key','expiration']);

# Hapus cache yang sudah expired
>>> DB::table('cache')->where('expiration', '<', now()->timestamp)->delete();
```

---

### 11. Tabel `jobs`, `job_batches`, & `failed_jobs`

#### Fungsi
Karena `.env` mengatur `QUEUE_CONNECTION=database`, Laravel menyimpan semua
**pekerjaan background (queue jobs)** ke tabel-tabel ini.

Queue digunakan untuk menjalankan tugas berat di latar belakang agar user
tidak perlu menunggu. Contoh penggunaan di WeBarber:
- Kirim email konfirmasi booking (tidak ingin user nunggu proses kirim email)
- Kirim notifikasi ke barber saat ada booking baru
- Proses laporan bulanan yang berat

---

#### 11a. Tabel `jobs` — Antrian Pekerjaan

Menyimpan pekerjaan yang **menunggu untuk dieksekusi**.

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id` | BIGINT, PK, AI | Primary key otomatis |
| `queue` | VARCHAR | Nama antrian (contoh: `default`, `emails`, `notifications`) |
| `payload` | LONGTEXT | Data job yang di-serialize (berisi nama class + parameter) |
| `attempts` | SMALLINT UNSIGNED | Sudah berapa kali dicoba dieksekusi |
| `reserved_at` | INT UNSIGNED, NULL | Unix timestamp kapan job mulai diproses oleh worker. NULL = belum diambil |
| `available_at` | INT UNSIGNED | Unix timestamp kapan job boleh mulai diambil worker |
| `created_at` | INT UNSIGNED | Unix timestamp saat job dibuat |

#### Cara Kerja Job

```
Kode aplikasi dispatch job:
    SendBookingConfirmationEmail::dispatch($booking);
            │
            ▼
    Laravel INSERT ke tabel jobs
    (payload berisi: class name + data booking)
            │
            ▼
    Worker (php artisan queue:work) berjalan di background
            │
            ├── Ambil job dari tabel jobs (UPDATE reserved_at)
            │
            ├── Eksekusi job (kirim email, dll)
            │
            ├── Berhasil → DELETE baris dari tabel jobs ✅
            │
            └── Gagal & attempts < max → UPDATE attempts, reset reserved_at (coba lagi)
                Gagal & attempts >= max → PINDAH ke tabel failed_jobs ❌
```

---

#### 11b. Tabel `job_batches` — Kumpulan Job

Digunakan saat banyak job dijalankan **sekaligus sebagai satu batch** dan
ingin memantau progress keseluruhannya.

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id` | VARCHAR, PK | UUID unik untuk batch |
| `name` | VARCHAR | Nama deskriptif batch (contoh: `SendMonthlyReport`) |
| `total_jobs` | INT | Total job dalam batch |
| `pending_jobs` | INT | Sisa job yang belum selesai |
| `failed_jobs` | INT | Jumlah job yang gagal |
| `failed_job_ids` | LONGTEXT | JSON array berisi UUID job yang gagal |
| `options` | MEDIUMTEXT, NULL | Opsi callback (then, catch, finally) |
| `cancelled_at` | INT, NULL | Unix timestamp jika batch dibatalkan |
| `created_at` | INT | Waktu batch dibuat |
| `finished_at` | INT, NULL | Waktu batch selesai seluruhnya |

```php
// Contoh dispatch batch job
Bus::batch([
    new SendBookingReminder($booking1),
    new SendBookingReminder($booking2),
    new SendBookingReminder($booking3),
])->name('SendDailyReminders')
  ->then(fn() => Log::info('Semua reminder terkirim'))
  ->catch(fn() => Log::error('Ada reminder yang gagal'))
  ->dispatch();
```

---

#### 11c. Tabel `failed_jobs` — Job yang Gagal

Menyimpan job yang **gagal dieksekusi** setelah mencapai batas maksimal percobaan.
Berguna untuk investigasi dan retry manual.

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id` | BIGINT, PK, AI | Primary key otomatis |
| `uuid` | VARCHAR, UNIQUE | UUID unik job (untuk identifikasi saat retry) |
| `connection` | VARCHAR | Nama koneksi queue (`database`, `redis`, dll) |
| `queue` | VARCHAR | Nama antrian job ini berasal |
| `payload` | LONGTEXT | Data job lengkap (untuk keperluan retry) |
| `exception` | LONGTEXT | Pesan error + stack trace lengkap kenapa gagal |
| `failed_at` | TIMESTAMP | Waktu job dinyatakan gagal |

#### Perintah Berguna untuk Queue

```bash
# Jalankan worker (memproses job dari tabel jobs)
php artisan queue:work

# Jalankan worker terus-menerus (tidak berhenti setelah job habis)
php artisan queue:work --daemon

# Lihat semua job yang gagal
php artisan queue:failed

# Coba ulang job yang gagal berdasarkan UUID
php artisan queue:retry {uuid}

# Coba ulang SEMUA job yang gagal
php artisan queue:retry all

# Hapus semua job yang gagal
php artisan queue:flush

# Lihat antrian job yang sedang menunggu via Tinker
php artisan tinker
>>> DB::table('jobs')->count();               // total job menunggu
>>> DB::table('failed_jobs')->count();        // total job gagal
>>> DB::table('failed_jobs')->latest('failed_at')->first(); // job gagal terbaru
```

---

### Ringkasan Tabel Laravel Default

| Tabel | Dikontrol via `.env` | Diisi oleh | Dihapus oleh | Perlu disentuh manual? |
|-------|----------------------|------------|--------------|------------------------|
| `password_reset_tokens` | *(config/auth.php)* | Laravel Auth saat user klik "Lupa Password" | Laravel setelah token dipakai / `auth:clear-resets` | ❌ Tidak |
| `sessions` | `SESSION_DRIVER=database` | Laravel setiap ada request/login | Laravel saat logout / session expired | ❌ Tidak (kecuali force logout: `session:clear`) |
| `cache` | `CACHE_STORE=database` | Laravel saat `Cache::put()` / `Cache::remember()` | Laravel saat cache expired / `cache:clear` | ❌ Tidak (kecuali debug: `cache:clear`) |
| `cache_locks` | `CACHE_STORE=database` | Laravel saat atomic lock digunakan | Laravel saat lock dilepas / expired | ❌ Tidak |
| `jobs` | `QUEUE_CONNECTION=database` | Laravel saat job di-dispatch | Worker setelah job berhasil dieksekusi | ❌ Tidak (jalankan `queue:work`) |
| `job_batches` | `QUEUE_CONNECTION=database` | Laravel saat `Bus::batch()` digunakan | Tidak otomatis (perlu manual atau scheduler) | ⚠️ Bisa (untuk monitor progress) |
| `failed_jobs` | `QUEUE_CONNECTION=database` | Laravel saat job gagal melebihi batas retry | Manual via `queue:flush` atau `queue:retry` | ✅ Ya (untuk investigasi & retry) |

---

## Alur Data Bisnis Lengkap

```
1. Admin menambah layanan
        │ INSERT services
        ▼
2. Admin menambah barber (user + profil barber + jadwal)
        │ INSERT users → barbers → barber_schedules
        ▼
3. Customer registrasi
        │ INSERT users (role='customer')
        ▼
4. Customer membuat booking
        │ INSERT bookings (status='pending')
        │ INSERT booking_details (snapshot harga)
        ▼
5. Admin mengkonfirmasi booking
        │ UPDATE bookings SET status='confirmed'
        ▼
6. Barber melayani customer
        ▼
7. Admin mencatat pembayaran
        │ INSERT payments (payment_status='paid', paid_at=NOW())
        │ UPDATE bookings SET status='completed'
        ▼
8. Selesai — data tersimpan untuk laporan & riwayat
```

---

## Query Penting

### Eager Loading Booking Lengkap

```php
$bookings = Booking::with('user', 'barber.user', 'details.service', 'payments')
    ->latest()
    ->paginate(15);
```

### Cek Konflik Jadwal Barber (Double-Booking)

```php
$conflict = Booking::where('barber_id', $barberId)
    ->where('booking_date', $bookingDate)
    ->whereNotIn('status', ['cancelled'])
    ->where(function ($q) use ($start, $end) {
        $q->whereBetween('start_time', [$start, $end])
          ->orWhereBetween('end_time', [$start, $end])
          ->orWhere(function ($q2) use ($start, $end) {
              $q2->where('start_time', '<=', $start)
                 ->where('end_time', '>=', $end);
          });
    })->exists();
```

### Layanan Paling Populer

```php
$popularServices = DB::table('booking_details as bd')
    ->join('services as s', 'bd.service_id', '=', 's.id')
    ->join('bookings as b', 'bd.booking_id', '=', 'b.id')
    ->whereIn('b.status', ['confirmed', 'completed'])
    ->selectRaw('s.name, SUM(bd.quantity) as total_dipesan')
    ->groupBy('s.id', 's.name')
    ->orderByDesc('total_dipesan')
    ->take(5)
    ->get();
```

### Pendapatan Bulanan (6 Bulan Terakhir)

```php
$monthlyRevenue = Payment::where('payment_status', 'paid')
    ->where('paid_at', '>=', now()->subMonths(6))
    ->selectRaw("DATE_FORMAT(paid_at, '%Y-%m') as month, SUM(amount) as total")
    ->groupBy('month')
    ->orderBy('month')
    ->get();
```

### Statistik Dashboard Admin

```php
$stats = [
    'total_customers' => User::where('role', 'customer')->count(),
    'total_barbers'   => Barber::where('is_active', true)->count(),
    'total_bookings'  => Booking::count(),
    'total_revenue'   => Payment::where('payment_status', 'paid')->sum('amount'),
];
```

### Booking Hari Ini untuk Barber

```php
$todayBookings = Booking::with('user', 'details.service')
    ->where('barber_id', $barber->id)
    ->whereDate('booking_date', today())
    ->whereNotIn('status', ['cancelled'])
    ->orderBy('start_time')
    ->get();
```

---

## Catatan Desain

- **Snapshot harga:** Kolom `price` di `booking_details` menyimpan harga saat booking, bukan mengacu langsung ke `services.price`. Ini memastikan laporan keuangan historis tetap akurat meski harga layanan berubah kemudian.
- **Soft delete tidak digunakan:** Penghapusan data menggunakan CASCADE. Hapus `user` → hapus `barber` → hapus `booking` → hapus `booking_details` dan `payments`.
- **Role dalam satu tabel:** Desain single-table inheritance untuk `users` memudahkan autentikasi karena Laravel Auth hanya butuh satu guard, cukup cek kolom `role` untuk otorisasi.
- **Conflict detection:** Pengecekan tumpang-tindih jadwal dilakukan di level aplikasi (PHP/Laravel) sebelum insert ke database, bukan menggunakan trigger SQL.
- **Atomicity booking:** Proses insert `bookings` + `booking_details` selalu dibungkus `DB::transaction()` agar jika salah satu gagal, keduanya dibatalkan (rollback).
