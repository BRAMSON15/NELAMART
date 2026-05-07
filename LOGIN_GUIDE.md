# Panduan Sistem Login Multi-User

Sistem login telah berhasil dibuat untuk 3 tipe user: Admin, User, dan Pelanggan.

## Kredensial Login untuk Testing

### Admin
- URL: `/admin/login`
- Username: `admin`
- Password: `password`
- Dashboard: `/admin/dashboard`

### User
- URL: `/user/login`
- Username: `user`
- Password: `password`
- Dashboard: `/user/dashboard`

### Pelanggan
- URL: `/pelanggan/login`
- Username: `pelanggan`
- Password: `password`
- Dashboard: `/pelanggan/dashboard`

## Fitur yang Telah Dibuat

1. **Model & Migration**
   - Kolom `role` ditambahkan ke tabel users dengan nilai: admin, user, pelanggan
   - Default role: pelanggan

2. **Authentication Controller**
   - `LoginController` dengan method terpisah untuk setiap role
   - Validasi role saat login
   - Redirect otomatis ke dashboard sesuai role

3. **Middleware**
   - `CheckRole` middleware untuk proteksi route berdasarkan role
   - Mencegah akses unauthorized

4. **Views**
   - Login page untuk masing-masing role dengan desain berbeda
   - Dashboard untuk masing-masing role
   - Error handling untuk kredensial salah

5. **Routes**
   - Route terpisah untuk login dan dashboard setiap role
   - Protected routes dengan middleware auth dan role

## Cara Menggunakan

1. Jalankan aplikasi Laravel:
   ```bash
   php artisan serve
   ```

2. Akses halaman login sesuai role:
   - Admin: `http://localhost:8000/admin/login`
   - User: `http://localhost:8000/user/login`
   - Pelanggan: `http://localhost:8000/pelanggan/login`

3. Login dengan kredensial di atas

4. Setelah login, Anda akan diarahkan ke dashboard sesuai role

## Keamanan

- Password di-hash menggunakan bcrypt
- Session regeneration setelah login
- CSRF protection pada semua form
- Role-based access control
- Logout akan menghapus session dan regenerate token

## Customisasi

Anda dapat mengcustomize:
- Desain halaman login di `resources/views/login{role}/`
- Desain dashboard di `resources/views/{Role}/`
- Logic autentikasi di `app/Http/Controllers/Auth/LoginController.php`
- Middleware di `app/Http/Middleware/CheckRole.php`
