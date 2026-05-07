# ✅ Solusi Error 403 - Admin Kelola Toko

## Masalah
Error **403 UNAUTHORIZED ACTION** saat mengakses `/admin/kelola-toko`

## Penyebab
User yang login **bukan admin** atau belum login sebagai admin.

## ✅ SOLUSI - Admin Sudah Ada!

Admin sudah tersedia di database dengan kredensial:

### 🔑 Kredensial Admin
```
Email: admin@example.com
Username: admin
Password: (cek di UserSeeder.php atau tanya developer)
```

## Cara Login Admin

### 1. Logout dari akun sekarang
Jika sedang login sebagai pelanggan atau user UMKM:
- Klik tombol **Logout** di navbar

### 2. Login sebagai Admin
1. Buka browser
2. Navigasi ke: `http://127.0.0.1:8000/admin/login`
3. Masukkan kredensial:
   - **Email:** `admin@example.com`
   - **Password:** (password yang sudah diset)
4. Klik **Login**

### 3. Akses Halaman Admin
Setelah login, Anda bisa mengakses:
- ✅ `/admin/dashboard` - Dashboard admin
- ✅ `/admin/kelola-toko` - Kelola toko UMKM
- ✅ `/admin/kelola-user` - Kelola user
- ✅ `/admin/statistik` - Statistik
- ✅ `/admin/chat` - Chat dengan pelanggan

## Cek Admin di Database

Untuk melihat admin yang ada, jalankan:
```bash
php check_admin.php
```

Output:
```
=== ADMIN USERS ===

✅ Ditemukan 1 admin:

ID: 1
Name: Admin
Email: admin@example.com
Username: admin
```

## Troubleshooting

### ❌ Masalah: Lupa Password Admin

**Solusi 1: Reset via Script**
Buat file `reset_admin_password.php`:
```php
<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$admin = User::where('email', 'admin@example.com')->first();
$admin->password = Hash::make('admin123'); // Password baru
$admin->save();

echo "✅ Password admin berhasil direset!\n";
echo "Email: admin@example.com\n";
echo "Password baru: admin123\n";
```

Jalankan:
```bash
php reset_admin_password.php
```

**Solusi 2: Reset via Database**
```sql
-- Buka database SQLite atau MySQL
UPDATE users 
SET password = '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5GyYqR4Qs3Omi' 
WHERE email = 'admin@example.com';
-- Password di atas adalah hash untuk: admin123
```

### ❌ Masalah: Masih Error 403 Setelah Login

**Kemungkinan Penyebab:**
1. Login dengan user yang bukan admin
2. Session belum di-refresh

**Solusi:**
1. **Logout** dari akun sekarang
2. **Clear cache:**
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan route:clear
   ```
3. **Login ulang** dengan kredensial admin
4. **Akses** `/admin/kelola-toko` lagi

### ❌ Masalah: Tidak Bisa Login

**Cek apakah admin ada:**
```bash
php check_admin.php
```

**Jika tidak ada admin, buat dengan:**
```bash
php artisan db:seed --class=AdminSeeder
```

## Membuat Admin Baru (Opsional)

Jika ingin membuat admin tambahan:

### Cara 1: Via Script
```bash
php create_admin.php
```

### Cara 2: Via Seeder
Edit `database/seeders/AdminSeeder.php`, tambahkan:
```php
User::create([
    'name' => 'Admin Baru',
    'email' => 'admin2@example.com',
    'username' => 'admin2',
    'password' => Hash::make('password123'),
    'role' => 'admin',
]);
```

Jalankan:
```bash
php artisan db:seed --class=AdminSeeder
```

### Cara 3: Via Database
```sql
INSERT INTO users (name, email, username, password, role, created_at, updated_at)
VALUES (
    'Admin Baru',
    'admin2@example.com',
    'admin2',
    '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5GyYqR4Qs3Omi',
    'admin',
    datetime('now'),
    datetime('now')
);
```

## Files Helper yang Dibuat

1. **check_admin.php** - Cek admin yang ada
2. **create_admin.php** - Buat admin baru interaktif
3. **database/seeders/AdminSeeder.php** - Seeder admin

## Kesimpulan

✅ **Admin sudah ada di database**
✅ **Email:** admin@example.com
✅ **Username:** admin

**Langkah selanjutnya:**
1. Logout dari akun sekarang
2. Login ke `/admin/login` dengan kredensial admin
3. Akses `/admin/kelola-toko` ✅

---

**Catatan Keamanan:**
- Ganti password default untuk production
- Jangan share kredensial admin
- Hapus file helper setelah selesai setup
