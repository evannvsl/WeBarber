# Dokumentasi Database — WebBarber

Aplikasi **WebBarber** adalah sistem reservasi barbershop berbasis Laravel. Berikut penjelasan lengkap struktur database MySQL yang digunakan.

---

## Daftar Tabel

| Tabel | Deskripsi |
|---|---|
| `users` | Semua pengguna: admin, barber, customer |
| `barbers` | Profil detail barber |
| `services` | Daftar layanan/jasa yang ditawarkan |
| `barber_schedules` | Jadwal kerja harian setiap barber |
| `bookings` | Data reservasi/booking |
| `booking_details` | Detail layanan per booking (pivot) |
| `payments` | Data pembayaran tiap booking |
| `password_reset_tokens` | Token reset password (Laravel default) |
| `sessions` | Sesi login aktif (Laravel default) |
| `cache` | Cache framework (Laravel default) |
| `jobs` | Queue jobs (Laravel default) |

---

## Detail Tiap Tabel

### 1. `users`

Menyimpan semua pengguna sistem. Satu tabel untuk tiga peran: admin, barber, dan customer.

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | BIGINT UNSIGNED, PK, AI | Primary key |
| `name` | VARCHAR(100) | Nama lengkap pengguna |
| `email` | VARCHAR(100), UNIQUE | Email (dipakai untuk login) |
| `email_verified_at` | TIMESTAMP, NULL | Waktu verifikasi email |
| `password` | VARCHAR | Password (bcrypt hash) |
| `role` | ENUM('admin','barber','customer') | Peran pengguna, default: `customer` |
| `phone` | VARCHAR(20), NULL | Nomor telepon |
| `profile_photo_path` | VARCHAR, NULL | Path foto profil (ditambah via migration terpisah) |
| `remember_token` | VARCHAR(100), NULL | Token "remember me" Laravel |
| `created_at` | TIMESTAMP | Waktu dibuat |
| `updated_at` | TIMESTAMP | Waktu diupdate |

**Catatan:** Pemisahan peran dilakukan lewat kolom `role`. Barber punya baris di tabel ini sekaligus di tabel `barbers`.

---

### 2. `barbers`

Menyimpan informasi tambahan khusus untuk pengguna berperan `barber`.

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | BIGINT UNSIGNED, PK, AI | Primary key |
| `user_id` | BIGINT UNSIGNED, FK → `users.id` | Relasi ke tabel users |
| `specialty` | VARCHAR(100), NULL | Keahlian/spesialisasi barber |
| `bio` | TEXT, NULL | Deskripsi/biodata barber |
| `is_active` | BOOLEAN | Status aktif, default: `true` |
| `created_at` | TIMESTAMP | Waktu dibuat |
| `updated_at` | TIMESTAMP | Waktu diupdate |

**Constraint:** `user_id` CASCADE ON DELETE — jika user dihapus, data barber ikut terhapus.

---

### 3. `services`

Katalog layanan yang bisa dipesan oleh customer.

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | BIGINT UNSIGNED, PK, AI | Primary key |
| `name` | VARCHAR(100) | Nama layanan (contoh: "Potong Rambut") |
| `description` | TEXT, NULL | Deskripsi layanan |
| `price` | DECIMAL(10,2) | Harga layanan dalam rupiah |
| `duration_minutes` | INT | Durasi pengerjaan dalam menit |
| `is_active` | BOOLEAN | Status aktif, default: `true` |
| `created_at` | TIMESTAMP | Waktu dibuat |
| `updated_at` | TIMESTAMP | Waktu diupdate |

---

### 4. `barber_schedules`

Jadwal kerja masing-masing barber per hari dalam seminggu.

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | BIGINT UNSIGNED, PK, AI | Primary key |
| `barber_id` | BIGINT UNSIGNED, FK → `barbers.id` | Relasi ke barber |
| `day_of_week` | TINYINT | Hari: 1=Senin, 2=Selasa, ..., 7=Minggu |
| `start_time` | TIME, NULL | Jam mulai kerja |
| `end_time` | TIME, NULL | Jam selesai kerja |
| `is_day_off` | BOOLEAN | Jika `true`, barber libur di hari ini |
| `created_at` | TIMESTAMP | Waktu dibuat |
| `updated_at` | TIMESTAMP | Waktu diupdate |

**Constraint:** `barber_id` CASCADE ON DELETE.

---

### 5. `bookings`

Tabel utama reservasi. Setiap baris adalah satu sesi booking dari seorang customer ke satu barber.

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | BIGINT UNSIGNED, PK, AI | Primary key |
| `user_id` | BIGINT UNSIGNED, FK → `users.id` | Customer yang booking |
| `barber_id` | BIGINT UNSIGNED, FK → `barbers.id` | Barber yang dipilih |
| `booking_date` | DATE | Tanggal booking |
| `start_time` | TIME | Jam mulai sesi |
| `end_time` | TIME | Jam selesai sesi (dihitung otomatis dari total durasi layanan) |
| `status` | ENUM('pending','confirmed','completed','cancelled') | Status booking, default: `pending` |
| `notes` | TEXT, NULL | Catatan tambahan dari customer |
| `created_at` | TIMESTAMP | Waktu dibuat |
| `updated_at` | TIMESTAMP | Waktu diupdate |

**Constraint:** `user_id` dan `barber_id` CASCADE ON DELETE.

---

### 6. `booking_details`

Tabel pivot antara `bookings` dan `services`. Satu booking bisa punya banyak layanan.

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | BIGINT UNSIGNED, PK, AI | Primary key |
| `booking_id` | BIGINT UNSIGNED, FK → `bookings.id` | Relasi ke booking |
| `service_id` | BIGINT UNSIGNED, FK → `services.id` | Relasi ke layanan |
| `quantity` | INT | Jumlah layanan, default: `1` |
| `price` | DECIMAL(10,2) | **Snapshot harga saat booking dilakukan** (bukan harga current di tabel services) |
| `created_at` | TIMESTAMP | Waktu dibuat |
| `updated_at` | TIMESTAMP | Waktu diupdate |

**Constraint:** `booking_id` CASCADE ON DELETE. `service_id` RESTRICT ON DELETE (layanan tidak bisa dihapus jika masih ada booking detail yang mereferensikannya).

**Penting:** Kolom `price` sengaja disimpan sebagai snapshot agar perubahan harga layanan di masa depan tidak mempengaruhi riwayat transaksi lama.

---

### 7. `payments`

Menyimpan data pembayaran untuk setiap booking.

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | BIGINT UNSIGNED, PK, AI | Primary key |
| `booking_id` | BIGINT UNSIGNED, FK → `bookings.id` | Relasi ke booking |
| `amount` | DECIMAL(10,2) | Jumlah yang dibayar |
| `payment_method` | ENUM('cash','transfer','qris') | Metode pembayaran, default: `cash` |
| `payment_status` | ENUM('pending','paid','failed','refunded') | Status pembayaran, default: `pending` |
| `paid_at` | TIMESTAMP, NULL | Waktu pembayaran berhasil |
| `created_at` | TIMESTAMP | Waktu dibuat |
| `updated_at` | TIMESTAMP | Waktu diupdate |

**Constraint:** `booking_id` CASCADE ON DELETE.

---

## Diagram Relasi (ERD)

```
users (1) ──────────── (1) barbers
  │                          │
  │                          ├────────── (many) barber_schedules
  │                          │
  └── (many) bookings (many)─┘
                │
                ├────────── (many) booking_details ──── (many) services
                │
                └────────── (many) payments
```

### Penjelasan Relasi Eloquent

| From | Relasi | To | Keterangan |
|---|---|---|---|
| `User` | `hasOne` | `Barber` | Satu user barber punya satu profil barber |
| `User` | `hasMany` | `Booking` | Customer bisa punya banyak booking |
| `Barber` | `belongsTo` | `User` | Barber milik satu user |
| `Barber` | `hasMany` | `BarberSchedule` | Barber punya banyak jadwal |
| `Barber` | `hasMany` | `Booking` | Barber bisa menerima banyak booking |
| `Booking` | `belongsTo` | `User` | Booking dimiliki satu customer |
| `Booking` | `belongsTo` | `Barber` | Booking ditangani satu barber |
| `Booking` | `hasMany` | `BookingDetail` | Booking bisa punya banyak detail layanan |
| `Booking` | `hasMany` | `Payment` | Booking bisa punya banyak pembayaran |
| `BookingDetail` | `belongsTo` | `Booking` | Detail milik satu booking |
| `BookingDetail` | `belongsTo` | `Service` | Detail mereferensikan satu layanan |
| `Payment` | `belongsTo` | `Booking` | Pembayaran milik satu booking |
| `Service` | `hasMany` | `BookingDetail` | Satu layanan bisa muncul di banyak booking |

---

## Query Penting

### 1. Eager Loading Booking Lengkap

Digunakan di halaman admin dan riwayat customer untuk menampilkan data booking beserta relasi-relasinya dalam satu query yang efisien.

```php
// Eager load: user, barber (beserta user-nya), detail layanan, dan pembayaran
$bookings = Booking::with('user', 'barber.user', 'details.service', 'payments')
    ->latest()
    ->paginate(15);
```

SQL yang dihasilkan (4 query):
```sql
SELECT * FROM bookings ORDER BY created_at DESC LIMIT 15;
SELECT * FROM users WHERE id IN (...);
SELECT * FROM barbers WHERE id IN (...);
SELECT * FROM users WHERE id IN (...);         -- user dari barber
SELECT * FROM booking_details WHERE booking_id IN (...);
SELECT * FROM services WHERE id IN (...);
SELECT * FROM payments WHERE booking_id IN (...);
```

---

### 2. Cek Konflik Jadwal Barber

Digunakan saat customer membuat booking baru untuk memastikan barber tidak double-booking.

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

SQL yang dihasilkan:
```sql
SELECT EXISTS (
  SELECT 1 FROM bookings
  WHERE barber_id = ?
    AND booking_date = ?
    AND status NOT IN ('cancelled')
    AND (
      start_time BETWEEN ? AND ?
      OR end_time BETWEEN ? AND ?
      OR (start_time <= ? AND end_time >= ?)
    )
) AS `exists`;
```

---

### 3. Layanan Paling Populer (JOIN Eksplisit)

Digunakan di dashboard admin dan halaman laporan.

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

SQL yang dihasilkan:
```sql
SELECT s.name, SUM(bd.quantity) AS total_dipesan
FROM booking_details AS bd
INNER JOIN services AS s ON bd.service_id = s.id
INNER JOIN bookings AS b ON bd.booking_id = b.id
WHERE b.status IN ('confirmed', 'completed')
GROUP BY s.id, s.name
ORDER BY total_dipesan DESC
LIMIT 5;
```

---

### 4. Barber Terbaik Berdasarkan Jumlah Pelayanan

Digunakan di halaman laporan admin.

```php
$topBarbers = DB::table('bookings as b')
    ->join('barbers as br', 'b.barber_id', '=', 'br.id')
    ->join('users as u', 'br.user_id', '=', 'u.id')
    ->whereIn('b.status', ['confirmed', 'completed'])
    ->selectRaw('u.name, COUNT(b.id) as total_pelayanan')
    ->groupBy('br.id', 'u.name')
    ->orderByDesc('total_pelayanan')
    ->take(5)
    ->get();
```

SQL yang dihasilkan:
```sql
SELECT u.name, COUNT(b.id) AS total_pelayanan
FROM bookings AS b
INNER JOIN barbers AS br ON b.barber_id = br.id
INNER JOIN users AS u ON br.user_id = u.id
WHERE b.status IN ('confirmed', 'completed')
GROUP BY br.id, u.name
ORDER BY total_pelayanan DESC
LIMIT 5;
```

---

### 5. Pendapatan Bulanan (6 Bulan Terakhir)

Digunakan untuk grafik di dashboard admin.

```php
$monthlyRevenue = Payment::where('payment_status', 'paid')
    ->where('paid_at', '>=', now()->subMonths(6))
    ->selectRaw("DATE_FORMAT(paid_at, '%Y-%m') as month, SUM(amount) as total")
    ->groupBy('month')
    ->orderBy('month')
    ->get();
```

SQL yang dihasilkan:
```sql
SELECT DATE_FORMAT(paid_at, '%Y-%m') AS month, SUM(amount) AS total
FROM payments
WHERE payment_status = 'paid'
  AND paid_at >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
GROUP BY month
ORDER BY month ASC;
```

---

### 6. Pendapatan Harian (30 Hari Terakhir)

Digunakan di halaman laporan admin.

```php
$dailyRevenue = Payment::where('payment_status', 'paid')
    ->where('paid_at', '>=', now()->subDays(30))
    ->selectRaw("DATE(paid_at) as tanggal, SUM(amount) as total_pendapatan")
    ->groupBy('tanggal')
    ->orderBy('tanggal', 'desc')
    ->get();
```

SQL yang dihasilkan:
```sql
SELECT DATE(paid_at) AS tanggal, SUM(amount) AS total_pendapatan
FROM payments
WHERE payment_status = 'paid'
  AND paid_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
GROUP BY tanggal
ORDER BY tanggal DESC;
```

---

### 7. Statistik Dashboard Admin

```php
$stats = [
    'total_customers' => User::where('role', 'customer')->count(),
    'total_barbers'   => Barber::where('is_active', true)->count(),
    'total_bookings'  => Booking::count(),
    'total_revenue'   => Payment::where('payment_status', 'paid')->sum('amount'),
];
```

SQL yang dihasilkan:
```sql
SELECT COUNT(*) FROM users WHERE role = 'customer';
SELECT COUNT(*) FROM barbers WHERE is_active = 1;
SELECT COUNT(*) FROM bookings;
SELECT SUM(amount) FROM payments WHERE payment_status = 'paid';
```

---

### 8. Booking Hari Ini untuk Barber

Digunakan di dashboard barber untuk menampilkan jadwal hari ini.

```php
$todayBookings = Booking::with('user', 'details.service')
    ->where('barber_id', $barber->id)
    ->whereDate('booking_date', today())
    ->whereNotIn('status', ['cancelled'])
    ->orderBy('start_time')
    ->get();
```

SQL yang dihasilkan:
```sql
SELECT * FROM bookings
WHERE barber_id = ?
  AND DATE(booking_date) = CURDATE()
  AND status NOT IN ('cancelled')
ORDER BY start_time ASC;
```

---

### 9. Membuat Booking dengan Transaksi

Proses booking dibungkus `DB::transaction()` untuk menjamin atomicity — jika salah satu insert gagal, semua dibatalkan.

```php
DB::transaction(function () use ($data, $services, $start, $end) {
    // 1. Insert ke tabel bookings
    $booking = Booking::create([...]);

    // 2. Insert setiap layanan ke booking_details
    foreach ($services as $service) {
        BookingDetail::create([
            'booking_id' => $booking->id,
            'service_id' => $service->id,
            'quantity'   => 1,
            'price'      => $service->price,  // snapshot harga
        ]);
    }
});
```

SQL yang dihasilkan (dalam satu transaksi):
```sql
START TRANSACTION;

INSERT INTO bookings (user_id, barber_id, booking_date, start_time, end_time, status, notes, ...)
VALUES (?, ?, ?, ?, ?, 'pending', ?, ...);

INSERT INTO booking_details (booking_id, service_id, quantity, price, ...)
VALUES (?, ?, 1, ?), (?, ?, 1, ?), ...;

COMMIT;
```

---

## Alur Data Bisnis

```
Customer membuat booking
        │
        ▼
[bookings] status = 'pending'
        │
        ▼
[booking_details] (snapshot harga layanan)
        │
        ▼
Admin mengkonfirmasi
        │
        ▼
[bookings] status = 'confirmed'
        │
        ▼
Barber menyelesaikan layanan
        │
        ▼
Admin mencatat pembayaran → [payments] payment_status = 'paid'
        │
        ▼
[bookings] status = 'completed'
```

---

## Catatan Desain

- **Snapshot harga:** Kolom `price` di `booking_details` menyimpan harga saat booking, bukan mengacu langsung ke `services.price`. Ini memastikan laporan keuangan historis tetap akurat meski harga layanan berubah kemudian.
- **Soft delete tidak digunakan:** Penghapusan data menggunakan CASCADE, artinya hapus `user` → hapus `barber` → hapus `booking` → hapus `booking_details` dan `payments`.
- **Role dalam satu tabel:** Desain single-table inheritance untuk `users` memudahkan autentikasi karena Laravel Auth hanya butuh satu guard, cukup cek kolom `role` untuk otorisasi.
- **Conflict detection:** Pengecekan tumpang-tindih jadwal dilakukan di level aplikasi (PHP/Laravel) sebelum insert ke database, bukan menggunakan trigger SQL.
