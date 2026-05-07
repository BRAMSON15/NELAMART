<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function (\Illuminate\Http\Request $request) {
    $query = \App\Models\Produk::with('toko')
        ->whereHas('toko', fn($q) => $q->where('status', 'aktif'));

    if ($request->filled('kategori')) {
        $query->where('kategori', $request->kategori);
    }

    if ($request->filled('cari')) {
        $query->where('nama_produk', 'like', '%' . $request->cari . '%');
    }

    $produks = $query->latest()->take(8)->get();

    return view('berandautama', compact('produks'));
});

// Default Login Route (redirect to home so users can choose login type)
Route::get('/login', function () {
    return redirect('/');
})->name('login');

// Admin Routes
Route::get('/admin/login', [LoginController::class, 'showAdminLogin'])->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'adminLogin'])->name('admin.login.submit');
Route::get('/admin/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])
    ->middleware(['auth', 'role:admin'])->name('admin.dashboard');

// Admin - Kelola Toko & User
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/kelola-toko', [App\Http\Controllers\AdminController::class, 'kelolaTokoIndex'])->name('admin.kelola-toko');
    Route::post('/admin/toko/{id}/approve', [App\Http\Controllers\AdminController::class, 'approveToko'])->name('admin.toko.approve');
    Route::post('/admin/toko/{id}/reject', [App\Http\Controllers\AdminController::class, 'rejectToko'])->name('admin.toko.reject');
    Route::get('/admin/toko/{id}/detail', [App\Http\Controllers\AdminController::class, 'detailToko'])->name('admin.toko.detail');
    
    // Kelola User
    Route::get('/admin/kelola-user', [App\Http\Controllers\AdminController::class, 'kelolaUserIndex'])->name('admin.kelola-user');
    Route::get('/admin/user/{id}/detail', [App\Http\Controllers\AdminController::class, 'detailUser'])->name('admin.user.detail');
    Route::get('/admin/user/{id}/edit', [App\Http\Controllers\AdminController::class, 'editUser'])->name('admin.user.edit');
    Route::put('/admin/user/{id}', [App\Http\Controllers\AdminController::class, 'updateUser'])->name('admin.user.update');
    Route::delete('/admin/user/{id}', [App\Http\Controllers\AdminController::class, 'deleteUser'])->name('admin.user.delete');
});

Route::get('/admin/kelola-produk', function () {
    return view('Admin.kelola-produk');
})->middleware(['auth', 'role:admin'])->name('admin.kelola-produk');

Route::get('/admin/kelola-pesanan', function () {
    return view('Admin.kelola-pesanan');
})->middleware(['auth', 'role:admin'])->name('admin.kelola-pesanan');

Route::get('/admin/laporan-transaksi', function () {
    return view('Admin.laporan-transaksi');
})->middleware(['auth', 'role:admin'])->name('admin.laporan-transaksi');

    Route::get('/admin/statistik', [App\Http\Controllers\AdminController::class, 'statistik'])
        ->middleware(['auth', 'role:admin'])->name('admin.statistik');
    
    // Admin Chat
    Route::get('/admin/chat', [App\Http\Controllers\ChatController::class, 'adminIndex'])
        ->middleware(['auth', 'role:admin'])->name('admin.chat.index');
    Route::get('/admin/chat/{userId}', [App\Http\Controllers\ChatController::class, 'adminShow'])
        ->middleware(['auth', 'role:admin'])->name('admin.chat.show');

// User Routes
Route::get('/user/login', [LoginController::class, 'showUserLogin'])->name('user.login');
Route::post('/user/login', [LoginController::class, 'userLogin'])->name('user.login.submit');

// User Registration
Route::get('/user/register', [App\Http\Controllers\RegistrasiController::class, 'showRegistrationForm'])->name('user.register');
Route::post('/user/register', [App\Http\Controllers\RegistrasiController::class, 'register'])->name('user.register.submit');

// RajaOngkir untuk form registrasi (tanpa auth)
Route::get('/rajaongkir/provinces', [App\Http\Controllers\RajaongkirController::class, 'getProvinces'])->name('rajaongkir.provinces.public');
Route::get('/rajaongkir/cities/{provinceId}', [App\Http\Controllers\RajaongkirController::class, 'getCities'])->name('rajaongkir.cities.public');

Route::get('/user/dashboard', function () {
    return view('User.dashboarduser');
})->middleware(['auth', 'role:user'])->name('user.dashboard');

// User - Toko
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/toko', [App\Http\Controllers\TokoController::class, 'index'])->name('user.toko.index');
    Route::get('/user/toko/create', [App\Http\Controllers\TokoController::class, 'create'])->name('user.toko.create');
    Route::post('/user/toko/store', [App\Http\Controllers\TokoController::class, 'store'])->name('user.toko.store');
    Route::get('/user/toko/edit', [App\Http\Controllers\TokoController::class, 'edit'])->name('user.toko.edit');
    Route::put('/user/toko/update', [App\Http\Controllers\TokoController::class, 'update'])->name('user.toko.update');
    
    // Produk
    Route::get('/user/produk', [App\Http\Controllers\ProdukController::class, 'index'])->name('user.produk.index');
    Route::get('/user/produk/create', [App\Http\Controllers\ProdukController::class, 'create'])->name('user.produk.create');
    Route::post('/user/produk/store', [App\Http\Controllers\ProdukController::class, 'store'])->name('user.produk.store');
    Route::get('/user/produk/{id}/edit', [App\Http\Controllers\ProdukController::class, 'edit'])->name('user.produk.edit');
    Route::put('/user/produk/{id}', [App\Http\Controllers\ProdukController::class, 'update'])->name('user.produk.update');
    Route::delete('/user/produk/{id}', [App\Http\Controllers\ProdukController::class, 'destroy'])->name('user.produk.destroy');
    
    // Pesanan
    Route::get('/user/pesanan', [App\Http\Controllers\PesananController::class, 'index'])->name('user.pesanan.index');
    Route::get('/user/pesanan/{id}', [App\Http\Controllers\PesananController::class, 'show'])->name('user.pesanan.show');
    Route::put('/user/pesanan/{id}/status', [App\Http\Controllers\PesananController::class, 'updateStatus'])->name('user.pesanan.updateStatus');
    
    // Laporan
    Route::get('/user/laporan', [App\Http\Controllers\PesananController::class, 'laporan'])->name('user.laporan');
});

// Pelanggan Routes
Route::get('/pelanggan/login', [LoginController::class, 'showPelangganLogin'])->name('pelanggan.login');
Route::post('/pelanggan/login', [LoginController::class, 'pelangganLogin'])->name('pelanggan.login.submit');
Route::get('/pelanggan/register', [App\Http\Controllers\RegistrasiController::class, 'showPelangganRegistrationForm'])->name('pelanggan.register');
Route::post('/pelanggan/register', [App\Http\Controllers\RegistrasiController::class, 'registerPelanggan'])->name('pelanggan.register.submit');

// Password Reset Routes for Pelanggan
Route::get('/pelanggan/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordPelangganController::class, 'showLinkRequestForm'])->name('pelanggan.password.request');
Route::post('/pelanggan/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordPelangganController::class, 'sendResetLinkEmail'])->name('pelanggan.password.email');
Route::get('/pelanggan/reset-password/{token}', [App\Http\Controllers\Auth\ForgotPasswordPelangganController::class, 'showResetForm'])->name('password.reset'); // Must be named password.reset for default Laravel mailables
Route::post('/pelanggan/reset-password', [App\Http\Controllers\Auth\ForgotPasswordPelangganController::class, 'reset'])->name('pelanggan.password.update');

Route::get('/pelanggan/dashboard', function (\Illuminate\Http\Request $request) {
    $query = \App\Models\Produk::with('toko');

    if ($request->filled('cari')) {
        $query->where('nama_produk', 'like', '%' . $request->cari . '%');
    }

    if ($request->filled('kategori')) {
        $query->where('kategori', $request->kategori);
    }

    $produks = $query->latest()->paginate(12);

    return view('Pelanggan.dashboardpelanggan', compact('produks'));
})->middleware(['auth', 'role:pelanggan'])->name('pelanggan.dashboard');

    // Pelanggan - View Public
    Route::get('/toko/{id}', [App\Http\Controllers\TokoController::class, 'show'])->name('toko.show');
    Route::get('/produk/{id}', [App\Http\Controllers\KeranjangController::class, 'detailProduk'])->name('produk.detail');

    Route::middleware(['auth', 'role:pelanggan'])->group(function () {
        Route::get('/keranjang', [App\Http\Controllers\KeranjangController::class, 'index'])->name('keranjang.index');
        Route::post('/keranjang/tambah', [App\Http\Controllers\KeranjangController::class, 'tambah'])->name('keranjang.tambah');
        Route::put('/keranjang/{id}', [App\Http\Controllers\KeranjangController::class, 'update'])->name('keranjang.update');
        Route::delete('/keranjang/{id}', [App\Http\Controllers\KeranjangController::class, 'hapus'])->name('keranjang.hapus');
        Route::get('/checkout', [App\Http\Controllers\KeranjangController::class, 'checkout'])->name('checkout.index');
        Route::post('/checkout/proses', [App\Http\Controllers\KeranjangController::class, 'prosesCheckout'])->name('checkout.proses');
        Route::get('/pesanan/{id}/detail', [App\Http\Controllers\KeranjangController::class, 'detailPesanan'])->name('pelanggan.pesanan.detail');
        Route::post('/pesanan/{id}/upload-bukti', [App\Http\Controllers\KeranjangController::class, 'uploadBuktiBayar'])->name('pelanggan.pesanan.upload-bukti');
        
        // RajaOngkir API Routes
        Route::get('/rajaongkir/provinces', [App\Http\Controllers\RajaongkirController::class, 'getProvinces'])->name('rajaongkir.provinces');
        Route::get('/rajaongkir/cities/{provinceId}', [App\Http\Controllers\RajaongkirController::class, 'getCities'])->name('rajaongkir.cities');
        Route::post('/rajaongkir/cost', [App\Http\Controllers\RajaongkirController::class, 'getCost'])->name('rajaongkir.cost');

        // Purchase Actions
        Route::post('/produk/{id}/beli', [App\Http\Controllers\KeranjangController::class, 'beliSekarang'])->name('produk.beli');

    
    // Profil
    Route::get('/profil', [App\Http\Controllers\ProfilController::class, 'index'])->name('profil.index');
    Route::put('/profil/update', [App\Http\Controllers\ProfilController::class, 'update'])->name('profil.update');
    Route::put('/profil/update-password', [App\Http\Controllers\ProfilController::class, 'updatePassword'])->name('profil.update-password');
    
    // Review
    Route::post('/review', [App\Http\Controllers\ProfilController::class, 'reviewStore'])->name('review.store');
    
    // Chat
    Route::get('/chat/user/{userId}', [App\Http\Controllers\ChatController::class, 'chatUser'])->name('chat.user');
    Route::get('/chat/admin', [App\Http\Controllers\ChatController::class, 'chatAdmin'])->name('chat.admin');
    
    // Tracking Pengiriman
    Route::get('/tracking/{id}', [App\Http\Controllers\TrackingController::class, 'show'])->name('tracking.show');
    Route::get('/tracking/{id}/location', [App\Http\Controllers\TrackingController::class, 'getLocation'])->name('tracking.location');
});

// Chat - Available for all authenticated users (pelanggan, user, admin)
Route::middleware(['auth'])->group(function () {
    Route::post('/chat/kirim', [App\Http\Controllers\ChatController::class, 'kirimPesan'])->name('chat.kirim');
});

// Tracking untuk Kurir/Toko
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/kurir/tracking/{id}', function($id) {
        $pesanan = \App\Models\Pesanan::with(['user', 'details.produk', 'toko'])->findOrFail($id);
        
        // Pastikan pesanan milik toko user yang login
        if ($pesanan->toko->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
        
        return view('User.kurir-tracking', compact('pesanan'));
    })->name('kurir.tracking');
    
    Route::post('/tracking/{id}/update', [App\Http\Controllers\TrackingController::class, 'updateLocation'])->name('tracking.update');
});

// Logout Route
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
