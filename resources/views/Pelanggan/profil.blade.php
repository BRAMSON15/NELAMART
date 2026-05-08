<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - NELA MART</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/beranda.css') }}?v={{ time() }}" rel="stylesheet">
    <link href="{{ asset('css/pelanggan-theme.css') }}?v={{ time() }}" rel="stylesheet">
    <link href="{{ asset('css/pelanggan.css') }}?v={{ time() }}" rel="stylesheet">
</head>
<body>
<!-- ===== NAVBAR ===== -->
<nav class="navbar" id="navbar" style="position:sticky;top:0;z-index:999;">
    <div class="nav-container">
        <a href="/" class="logo"><i class="fas fa-store"></i> NELA MART</a>
        <ul class="nav-menu">
            <li><a href="{{ route('pelanggan.dashboard') }}">Beranda</a></li>
            <li><a href="{{ route('keranjang.index') }}">Keranjang</a></li>
            <li><a href="{{ route('profil.index') }}" class="active">Profil</a></li>
        </ul>
        <div class="nav-buttons">
            <a href="{{ route('keranjang.index') }}" class="btn btn-outline btn-sm">
                <i class="fas fa-shopping-cart"></i> Keranjang
                @php $jumlahKeranjang = \App\Models\Keranjang::where('user_id', Auth::id())->count(); @endphp
                @if($jumlahKeranjang > 0)
                    <span class="badge bg-danger ms-1" style="font-size:10px;">{{ $jumlahKeranjang }}</span>
                @endif
            </a>
            <div class="dropdown" style="position:relative;display:inline-block;">
                <button class="btn btn-primary btn-sm" onclick="toggleDropdown()" style="cursor:pointer;">
                    <i class="fas fa-user"></i> {{ Auth::user()->name }}
                    <i class="fas fa-chevron-down ms-1" style="font-size:10px;"></i>
                </button>
                <div id="userDropdown" style="display:none;position:absolute;right:0;top:110%;background:white;border-radius:10px;box-shadow:0 8px 24px rgba(0,0,0,0.12);min-width:180px;z-index:1000;overflow:hidden;">
                    <a href="{{ route('profil.index') }}" style="display:block;padding:12px 16px;color:#333;text-decoration:none;font-size:14px;border-bottom:1px solid #f1f5f9;">
                        <i class="fas fa-user me-2" style="color:#26b99a;"></i> Profil Saya
                    </a>
                    <a href="{{ route('pelanggan.dashboard') }}" style="display:block;padding:12px 16px;color:#333;text-decoration:none;font-size:14px;border-bottom:1px solid #f1f5f9;">
                        <i class="fas fa-star me-2" style="color:#26b99a;"></i> Ulasan Saya
                    </a>
                    <a href="{{ route('chat.admin') }}" style="display:block;padding:12px 16px;color:#333;text-decoration:none;font-size:14px;border-bottom:1px solid #f1f5f9;">
                        <i class="fas fa-comment me-2" style="color:#26b99a;"></i> Chat Admin
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" style="width:100%;padding:12px 16px;background:none;border:none;text-align:left;color:#ef4444;font-size:14px;cursor:pointer;">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <button class="nav-toggle" id="navToggle"><i class="fas fa-bars"></i></button>
    </div>
</nav>

<!-- ===== HERO ===== -->
<section class="hero" style="min-height:260px;padding:50px 20px;">
    <div class="hero-shape hero-shape-1"></div>
    <div class="hero-shape hero-shape-2"></div>
    <div class="hero-container">
        <div class="hero-badge"><i class="fas fa-user-circle"></i> Akun Saya</div>
        <h1 style="font-size:2rem;">Profil <span class="hero-highlight">{{ Auth::user()->name }}</span></h1>
        <p>Kelola informasi akun dan keamanan password Anda.</p>
    </div>
</section>

<!-- ===== STATS PESANAN ===== -->
<section class="stats">
    <div class="stats-container">
        <div class="stat-item">
            <div class="stat-icon"><i class="fas fa-shopping-bag"></i></div>
            <div class="stat-number">{{ \App\Models\Pesanan::where('user_id', Auth::id())->count() }}</div>
            <div class="stat-label">Total Pesanan</div>
        </div>
        <div class="stat-item">
            <div class="stat-icon"><i class="fas fa-clock"></i></div>
            <div class="stat-number">{{ \App\Models\Pesanan::where('user_id', Auth::id())->where('status','pending')->count() }}</div>
            <div class="stat-label">Menunggu Konfirmasi</div>
        </div>
        <div class="stat-item">
            <div class="stat-icon"><i class="fas fa-truck"></i></div>
            <div class="stat-number">{{ \App\Models\Pesanan::where('user_id', Auth::id())->where('status','dikirim')->count() }}</div>
            <div class="stat-label">Dalam Pengiriman</div>
        </div>
        <div class="stat-item">
            <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
            <div class="stat-number">{{ \App\Models\Pesanan::where('user_id', Auth::id())->where('status','selesai')->count() }}</div>
            <div class="stat-label">Pesanan Selesai</div>
        </div>
    </div>
</section>

<!-- ===== PROFIL FORMS ===== -->
<section style="padding:50px 20px;background:#f5f5f5;">
    <div class="container" style="max-width:960px;">

        @if(session('success'))
            <div class="alert alert-success mb-4 rounded-3">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger mb-4 rounded-3">{{ session('error') }}</div>
        @endif

        <div class="row g-4">
            <!-- Informasi Profil -->
            <div class="col-lg-6">
                <div class="profile-card h-100">
                    <h4 class="mb-4" style="color:#2a3f54;font-weight:700;">
                        <i class="fas fa-id-card me-2" style="color:#26b99a;"></i> Informasi Profil
                    </h4>
                    <form method="POST" action="{{ route('profil.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="color:#2a3f54;">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                            @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="color:#2a3f54;">Username</label>
                            <input type="text" name="username" class="form-control" value="{{ $user->username }}" required>
                            @error('username')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="color:#2a3f54;">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                            @error('email')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold" style="color:#2a3f54;">Role</label>
                            <input type="text" class="form-control" value="{{ ucfirst($user->role) }}" disabled style="background:#f8fafc;">
                        </div>

                        <button type="submit" class="btn w-100 py-2 fw-semibold text-white"
                            style="background:linear-gradient(135deg,#26b99a,#1abb9c);border:none;border-radius:10px;">
                            <i class="fas fa-save me-2"></i> Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>

            <!-- Ubah Password -->
            <div class="col-lg-6">
                <div class="profile-card h-100">
                    <h4 class="mb-4" style="color:#2a3f54;font-weight:700;">
                        <i class="fas fa-lock me-2" style="color:#26b99a;"></i> Ubah Password
                    </h4>
                    <form method="POST" action="{{ route('profil.update-password') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="color:#2a3f54;">Password Lama</label>
                            <input type="password" name="password_lama" class="form-control" required>
                            @error('password_lama')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="color:#2a3f54;">Password Baru</label>
                            <input type="password" name="password_baru" class="form-control" required>
                            @error('password_baru')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold" style="color:#2a3f54;">Konfirmasi Password Baru</label>
                            <input type="password" name="password_baru_confirmation" class="form-control" required>
                        </div>

                        <button type="submit" class="btn w-100 py-2 fw-semibold text-white"
                            style="background:linear-gradient(135deg,#2a3f54,#3d5a73);border:none;border-radius:10px;">
                            <i class="fas fa-key me-2"></i> Ubah Password
                        </button>
                    </form>
                </div>
            </div>

            <!-- ===== ALAMAT & LOKASI ===== -->
            <div class="col-12">
                <div class="profile-card">
                    <h4 class="mb-1" style="color:#2a3f54;font-weight:700;">
                        <i class="fas fa-map-marker-alt me-2" style="color:#26b99a;"></i> Alamat Pengiriman
                    </h4>
                    <p class="text-muted mb-4" style="font-size:13px;">Alamat ini akan digunakan sebagai tujuan pengiriman pesanan Anda.</p>

                    <form method="POST" action="{{ route('profil.update') }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="name"     value="{{ $user->name }}">
                        <input type="hidden" name="email"    value="{{ $user->email }}">
                        <input type="hidden" name="username" value="{{ $user->username }}">

                        <div class="row g-3">
                            <div class="col-lg-8">
                                <label class="form-label fw-semibold" style="color:#2a3f54;font-size:13px;">Alamat Lengkap</label>
                                <textarea name="alamat" id="alamatInput" class="form-control" rows="3"
                                    placeholder="Contoh: Jl. Merdeka No. 10, Kel. Sukamaju, Kec. Cibeunying, Bandung, Jawa Barat 40123"
                                    style="border-radius:10px;border:2px solid #e2e8f0;font-size:14px;resize:vertical;">{{ $user->alamat }}</textarea>
                                @error('alamat')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>

                            <div class="col-lg-4">
                                <label class="form-label fw-semibold" style="color:#2a3f54;font-size:13px;">Koordinat GPS</label>
                                <div class="d-flex gap-2 mb-2">
                                    <input type="number" name="latitude" id="latInput" class="form-control form-control-sm"
                                        placeholder="Latitude" step="any" value="{{ $user->latitude }}"
                                        style="border-radius:8px;border:2px solid #e2e8f0;font-size:13px;">
                                    <input type="number" name="longitude" id="lngInput" class="form-control form-control-sm"
                                        placeholder="Longitude" step="any" value="{{ $user->longitude }}"
                                        style="border-radius:8px;border:2px solid #e2e8f0;font-size:13px;">
                                </div>
                                <button type="button" onclick="getGPS()" id="gpsBtn"
                                    class="btn w-100 fw-semibold"
                                    style="background:rgba(38,185,154,0.1);color:#26b99a;border:2px solid #26b99a;border-radius:10px;font-size:13px;padding:9px;">
                                    <i class="fas fa-location-arrow me-2"></i> Gunakan Lokasi Saya
                                </button>
                                <div id="gpsStatus" class="mt-2" style="font-size:12px;display:none;"></div>
                            </div>
                        </div>

                        {{-- Peta --}}
                        <div id="mapContainer" class="mt-3" style="display:{{ $user->latitude ? 'block' : 'none' }};">
                            <div id="map" style="height:260px;border-radius:12px;border:2px solid #e2e8f0;overflow:hidden;"></div>
                            <small class="text-muted mt-1 d-block">
                                <i class="fas fa-info-circle me-1" style="color:#26b99a;"></i>
                                Klik pada peta untuk mengubah titik lokasi
                            </small>
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn fw-semibold text-white px-4 py-2"
                                style="background:linear-gradient(135deg,#26b99a,#1abb9c);border:none;border-radius:10px;font-size:14px;">
                                <i class="fas fa-save me-2"></i> Simpan Alamat
                            </button>
                            @if($user->alamat)
                                <span class="ms-3" style="font-size:13px;color:#26b99a;">
                                    <i class="fas fa-check-circle me-1"></i> Alamat tersimpan
                                </span>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Kembali -->
        <div class="text-center mt-4">
            <a href="{{ route('pelanggan.dashboard') }}" class="btn px-4 py-2 fw-semibold"
                style="background:#f1f5f9;color:#2a3f54;border-radius:10px;text-decoration:none;">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>
</section>

<!-- ===== FOOTER ===== -->
<footer class="footer">
    <div class="footer-container">
        <div class="footer-brand">
            <h3><i class="fas fa-store"></i> NELA MART</h3>
            <p>Platform terpercaya untuk menemukan dan membeli produk-produk UMKM berkualitas dari seluruh Indonesia.</p>
            <div class="social-links">
                <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                <a href="#" class="social-link"><i class="fab fa-whatsapp"></i></a>
            </div>
        </div>
        <div class="footer-column">
            <h4>Belanja</h4>
            <ul class="footer-links">
                <li><a href="{{ route('pelanggan.dashboard') }}"><i class="fas fa-chevron-right"></i> Dashboard</a></li>
                <li><a href="{{ route('keranjang.index') }}"><i class="fas fa-chevron-right"></i> Keranjang</a></li>
            </ul>
        </div>
        <div class="footer-column">
            <h4>Akun Saya</h4>
            <ul class="footer-links">
                <li><a href="{{ route('profil.index') }}"><i class="fas fa-chevron-right"></i> Profil</a></li>
                <li><a href="{{ route('pelanggan.dashboard') }}"><i class="fas fa-chevron-right"></i> Ulasan Saya</a></li>
                <li><a href="{{ route('chat.admin') }}"><i class="fas fa-chevron-right"></i> Chat Admin</a></li>
            </ul>
        </div>
        <div class="footer-column">
            <h4>Lainnya</h4>
            <ul class="footer-links">
                <li><a href="/"><i class="fas fa-chevron-right"></i> Beranda Utama</a></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                        @csrf
                        <button type="submit" style="background:none;border:none;padding:0;color:rgba(255,255,255,0.7);font-size:14px;cursor:pointer;">
                            <i class="fas fa-chevron-right"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2026 NELA MART. Dibuat dengan <i class="fas fa-heart" style="color:#e74c3c;"></i> untuk UMKM Indonesia.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Leaflet Maps -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="{{ asset('js/app-navbar.js') }}"></script>
<script src="{{ asset('js/map-gps.js') }}"></script>
<script>
    const savedLat = {{ $user->latitude ?? 'null' }};
    const savedLng = {{ $user->longitude ?? 'null' }};

    // Init map jika sudah ada koordinat tersimpan
    if (savedLat && savedLng) {
        document.addEventListener('DOMContentLoaded', function() {
            initMap(savedLat, savedLng);
        });
    }
</script>
</body>
</html>

