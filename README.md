# 🏫 Sistem Inventaris Sekolah (Full Stack Laravel 11)

Aplikasi Web Full-Stack **Sistem Inventaris Sekolah** yang dibangun sesuai dengan spesifikasi dan standar kualitas dari **Gamelab Indonesia**.

Aplikasi ini mengatasi masalah pencatatan inventaris manual dengan mengelola data barang, kategori barang, transaksi peminjaman, serta verifikasi pengembalian barang berbasis **Role Management (Admin & User)**.

---

## 🛠️ Tech Stack & Modul Utama

- **Framework Backend:** Laravel 11 (PHP 8.2+)
- **View Engine:** Blade + TailwindCSS + Alpine.js
- **Autentikasi:** Laravel Breeze
- **Database:** MySQL / SQLite (Eloquent Relationships + Soft Deletes)
- **Role Management:** Admin & User (Role Middleware)
- **Audit Trail:** Activity Logs System

---

## 🔑 Kredensial Akun Testing (Hasil Seeder)

Gunakan kredensial berikut untuk login dan menguji coba hak akses:

| Role | Email | Password | Akses & Hak Otoritas |
| :--- | :--- | :--- | :--- |
| **Admin** | `admin@sekolah.sch.id` | `password` | **Full Access:** Dashboard Statistik, CRUD Kategori, CRUD Barang (Soft Delete & Restore), Verifikasi Peminjaman/Pengembalian, Activity Log Audit Trail, User Management. |
| **User (Siswa)** | `siswa@sekolah.sch.id` | `password` | **User Access:** Katalog Barang, Form Pengajuan Peminjaman, Riwayat Peminjaman Pribadi. |
| **User (Guru)** | `guru@sekolah.sch.id` | `password` | **User Access:** Katalog Barang, Form Pengajuan Peminjaman, Riwayat Peminjaman Pribadi. |

---

## 🚀 Panduan Instalasi Project

### 1. Clone Repository
```bash
git clone <URL_REPOSITORY_ANDA>
cd Sistem-Inventaris-Sekolah
```

### 2. Install Dependency PHP & Node
```bash
composer install
npm install # atau pnpm install
```

### 3. Setup File Environment (`.env`)
Salin file `.env.example` menjadi `.env`:
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Database & Seeder
Jalankan migrasi database beserta seeder bawaan:
```bash
php artisan migrate:fresh --seed
```

### 5. Compile Frontend Assets & Jalankan Server
```bash
npm run build # Kompilasi CSS & JS
php artisan serve
```

Aplikasi siap diakses melalui browser di `http://127.0.0.1:8000`.

---

## 🗄️ Struktur Relasi Tabel Database (ERD)

1. **`users`**: Menyimpan akun pengguna beserta role (`admin` / `user`).
2. **`categories`**: Kategori inventaris (`hasMany` ke `items`).
3. **`items`**: Data barang inventaris (`belongsTo` ke `categories`, `hasMany` ke `loans`, `SoftDeletes`).
4. **`loans`**: Catatan transaksi peminjaman (`belongsTo` ke `users` & `items`, `hasOne` ke `return_logs`, `SoftDeletes`).
5. **`return_logs`**: Catatan verifikasi pengembalian barang (`belongsTo` ke `loans`, `SoftDeletes`).
6. **`activity_logs`**: Jejak audit (audit trail) seluruh aksi pengguna (`belongsTo` ke `users`).

---

## ✨ Fitur Standar Kualitas Gamelab

- [x] **Form Request Validation** di backend untuk seluruh form.
- [x] **Auto-focus** pada input pertama setiap form.
- [x] **Placeholder & Tanda Bintang (*)** pada required field.
- [x] **Format Ribuan Indonesia** pada jumlah stok & barang (contoh: `1.000`).
- [x] **Format Tanggal Indonesia** (contoh: `1 Feb 2026`).
- [x] **Soft Delete & Restore** data barang dan transaksi.
- [x] **Dashboard Statistik & Chart** barang populer & user aktif.
- [x] **Fitur Cetak Laporan** transaksi peminjaman.

---

*Dikembangkan untuk Tugas Akhir Magang di Gamelab Indonesia.*
