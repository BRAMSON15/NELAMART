# Bug Fix: Admin 403 Unauthorized

## Tanggal: 6 Mei 2026

## Masalah
Error **403 UNAUTHORIZED ACTION** saat mengakses halaman admin seperti:
- `/admin/kelola-toko`
- `/admin/kelola-user`
- `/admin/dashboard`
- Dan halaman admin lainnya

## Penyebab
User yang login **tidak memiliki role 'admin'** di database. Middleware `CheckRole` memeriksa role user dan jika tidak sesuai akan mengembalikan error 403.

## Solusi

### Opsi 1: Jalankan Seeder Admin (Recommended)
Cara tercepat untuk membuat user admin:

```bash
php artisan db:seed --class=AdminSeeder
```

**Kredensial Admin Default:**
- Email: `admin@nelamart.com`
- Password: `admin123`
- Username: `admin`

⚠️ **PENTING:** Ganti password setelah login pertama kali!

### Opsi 2: Jalankan Script Create Admin
Jika ingin membuat admin dengan kredensial custom:

```bash
php create_admin.php
```

Script akan meminta input:
- Name
- Email
- Username (optional)
- Password

### Opsi 3: Update Manual via Database
Jika sudah ada user yang ingin dijadikan admin:

```sql
UPDATE users 
SET role = 'admin' 
WHERE email = 'email@anda.com';
```

### Opsi 4: Via Tinker
```bash
php artisan tinker
```

Kemudian jalankan:
```php
$user = \App\Models\User::where('email', 'email@anda.com')->first();
$user->role = 'admin';
$user->save();
```

## Verifikasi

### 1. Cek User di Database
```bash
php artisan tinker
```

```php
\App\Models\User::where('role', 'admin')->get(['id', 'name', 'email', 'role']);
```

### 2. Test Login Admin
1. Buka browser
2. Navigasi ke `/admin/login`
3. Login dengan kredensial admin
4. Akses `/admin/dashboard`
5. Verifikasi tidak ada error 403 ✅

### 3. Test Akses Halaman Admin
- ✅ `/admin/dashboard` - Dashboard admin
- ✅ `/admin/kelola-toko` - Kelola toko UMKM
- ✅ `/admin/kelola-user` - Kelola user
- ✅ `/admin/statistik` - Statistik
- ✅ `/admin/chat` - Chat dengan pelanggan

## Penjelasan Teknis

### Middleware CheckRole
File: `app/Http/Middleware/CheckRole.php`

```php
public function handle(Request $request, Closure $next, string $role): Response
{
    if (!auth()->check()) {
        return redirect('/');
    }

    if (auth()->user()->role !== $role) {
        abort(403, 'Unauthorized action.');
    }

    return $next($request);
}
```

Middleware ini memeriksa:
1. User sudah login (`auth()->check()`)
2. Role user sesuai dengan yang diminta (`auth()->user()->role !== $role`)

Jika tidak sesuai → Error 403

### Route Protection
File: `routes/web.php`

```php
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/kelola-toko', [AdminController::class, 'kelolaTokoIndex']);
    // ... routes lainnya
});
```

Semua route admin dilindungi dengan:
- `auth` - Harus login
- `role:admin` - Harus memiliki role admin

## Files Created/Modified

### Created:
1. `database/seeders/AdminSeeder.php` - Seeder untuk membuat admin
2. `create_admin.php` - Script standalone untuk membuat admin
3. `BUGFIX_ADMIN_403_UNAUTHORIZED.md` - Dokumentasi ini

### Modified:
1. `database/seeders/DatabaseSeeder.php` - Menambahkan AdminSeeder

## Troubleshooting

### Masalah: Seeder gagal
**Error:** "Admin sudah ada"
**Solusi:** Admin sudah dibuat sebelumnya, cek dengan:
```bash
php artisan tinker
\App\Models\User::where('role', 'admin')->get();
```

### Masalah: Lupa password admin
**Solusi:** Reset password via tinker:
```bash
php artisan tinker
```
```php
$admin = \App\Models\User::where('email', 'admin@nelamart.com')->first();
$admin->password = \Hash::make('password_baru');
$admin->save();
```

### Masalah: Masih error 403 setelah login
**Kemungkinan:**
1. Login dengan user yang bukan admin
2. Session belum di-refresh (logout dan login lagi)
3. Cache route belum di-clear

**Solusi:**
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

## Security Notes

⚠️ **PENTING untuk Production:**

1. **Ganti Password Default**
   - Password `admin123` hanya untuk development
   - Gunakan password yang kuat untuk production

2. **Ganti Email Default**
   - Email `admin@nelamart.com` mudah ditebak
   - Gunakan email yang tidak mudah ditebak

3. **Hapus Script create_admin.php**
   - Setelah admin dibuat, hapus file `create_admin.php`
   - File ini bisa digunakan untuk membuat admin tanpa authorization

4. **Disable Seeder di Production**
   - Jangan jalankan seeder di production
   - Buat admin manual via database

## Status
✅ **FIXED** - Admin seeder dan script sudah dibuat
📝 **ACTION REQUIRED** - Jalankan seeder atau script untuk membuat admin
