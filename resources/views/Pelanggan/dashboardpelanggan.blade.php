<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pelanggan - NELA MART</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/beranda.css') }}?v={{ time() }}" rel="stylesheet">
    <link href="{{ asset('css/pelanggan-theme.css') }}?v={{ time() }}" rel="stylesheet">
</head>
<body>

<!-- ===== NAVBAR ===== -->
<nav class="navbar" id="navbar" style="position:sticky;top:0;z-index:999;">
    <div class="nav-container">
        {{-- Logo --}}
        <a href="/" class="logo"><i class="fas fa-store"></i> NELA MART</a>

        {{-- Nav Buttons (Keranjang + User dropdown) --}}
        <div class="nav-buttons">
            <a href="{{ route('keranjang.index') }}" class="btn btn-outline btn-sm">
                <i class="fas fa-shopping-cart"></i>
                <span class="btn-text">Keranjang</span>
                @php $jumlahKeranjang = \App\Models\Keranjang::where('user_id', Auth::id())->count(); @endphp
                @if($jumlahKeranjang > 0)
                    <span class="badge bg-danger" style="font-size:10px;margin-left:4px;">{{ $jumlahKeranjang }}</span>
                @endif
            </a>
            <div class="dropdown" style="position:relative;display:inline-block;">
                <button class="btn btn-primary btn-sm" onclick="toggleDropdown()" style="cursor:pointer;white-space:nowrap;">
                    <i class="fas fa-user"></i>
                    <span class="btn-text">{{ Str::limit(Auth::user()->name, 15) }}</span>
                    <i class="fas fa-chevron-down" style="font-size:10px;margin-left:6px;"></i>
                </button>
                <div id="userDropdown" style="display:none;position:absolute;right:0;top:110%;background:white;border-radius:10px;box-shadow:0 8px 24px rgba(0,0,0,0.12);min-width:200px;z-index:1000;overflow:hidden;">
                    <a href="{{ route('profil.index') }}" style="display:block;padding:12px 16px;color:#333;text-decoration:none;font-size:14px;border-bottom:1px solid #f1f5f9;transition:background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='white'">
                        <i class="fas fa-user me-2" style="color:#26b99a;width:20px;"></i> Profil Saya
                    </a>
                    <a href="{{ route('pelanggan.dashboard') }}" style="display:block;padding:12px 16px;color:#333;text-decoration:none;font-size:14px;border-bottom:1px solid #f1f5f9;transition:background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='white'">
                        <i class="fas fa-star me-2" style="color:#26b99a;width:20px;"></i> Ulasan Saya
                    </a>
                    <a href="{{ route('chat.admin') }}" style="display:block;padding:12px 16px;color:#333;text-decoration:none;font-size:14px;border-bottom:1px solid #f1f5f9;transition:background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='white'">
                        <i class="fas fa-comment me-2" style="color:#26b99a;width:20px;"></i> Chat Admin
                    </a>
                    <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                        @csrf
                        <button type="submit" style="width:100%;padding:12px 16px;background:none;border:none;text-align:left;color:#ef4444;font-size:14px;cursor:pointer;transition:background 0.2s;" onmouseover="this.style.background='#fef2f2'" onmouseout="this.style.background='white'">
                            <i class="fas fa-sign-out-alt me-2" style="width:20px;"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Hamburger button (visible on mobile only) --}}
        <button class="nav-toggle" id="navToggle" aria-label="Toggle menu">
            <i class="fas fa-bars"></i>
        </button>

        {{-- Nav Menu (slides down on mobile when .open) --}}
        <ul class="nav-menu" id="navMenu">
            <li><a href="#beranda">Beranda</a></li>
            <li><a href="#produk">Produk</a></li>
            <li><a href="#pesanan">Pesanan Saya</a></li>
        </ul>
    </div>
</nav>

<!-- ===== HERO / WELCOME ===== -->
<section class="hero" id="beranda" style="min-height:320px;padding:60px 20px;">
    <div class="hero-shape hero-shape-1"></div>
    <div class="hero-shape hero-shape-2"></div>
    <div class="hero-container">
        <div class="hero-badge"><i class="fas fa-user-check"></i> Selamat Datang, {{ Auth::user()->name }}</div>
        <h1 style="font-size:2.2rem;">Temukan Produk UMKM<br><span class="hero-highlight">terbaikmu</span></h1>
        <p>Belanja produk lokal berkualitas, untuk mendukung sistem UMKM Negeri lama.</p>
        <div class="hero-buttons">
            <a href="#produk" class="btn btn-white btn-hero"><i class="fas fa-search"></i> Jelajahi Produk</a>
            <a href="{{ route('keranjang.index') }}" class="btn btn-outline-white btn-hero"><i class="fas fa-shopping-cart"></i> Keranjang Saya</a>
        </div>
    </div>
</section>

<!-- ===== STATS PESANAN ===== -->
<section class="stats" id="pesanan">
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

<!-- ===== PRODUK ===== -->
<header class="bg-dark py-5" id="produk">
    <div class="container px-4 px-lg-5 my-3">
        <div class="text-center text-white">
            <h1 class="display-5 fw-bolder">Produk Rekomendasi</h1>
            <p class="lead fw-normal text-white-50 mb-4">Produk pilihan dari toko UMKM terverifikasi</p>
            <form action="{{ route('pelanggan.dashboard') }}" method="GET" class="d-flex justify-content-center gap-2 flex-wrap">
                <div class="input-group search-group" style="max-width:100%; width: 400px;">
                    <input type="text" name="cari" class="form-control form-control-lg"
                           placeholder="Cari produk UMKM..." value="{{ request('cari') }}">
                    <button class="btn btn-primary px-4" type="submit"><i class="fas fa-search"></i></button>
                </div>
                <select name="kategori" class="form-select form-select-lg filter-select" style="max-width:100%; width: 200px;" onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    @foreach(['Makanan', 'Minuman', 'Fashion', 'Kerajinan', 'Elektronik', 'Lainnya'] as $kat)
                        <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>
</header>

<section class="py-5" style="background:#f8f9fa;">
    <div class="container px-4 px-lg-5">
        @if($produks->count() > 0)
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4">
            @foreach($produks as $produk)
            <div class="col mb-4">
                <div class="card h-100 border-0 shadow-sm" style="border-radius:12px;overflow:hidden;transition:transform 0.2s,box-shadow 0.2s;"
                     onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 12px 30px rgba(0,0,0,0.12)'"
                     onmouseout="this.style.transform='translateY(0)';this.style.boxShadow=''">
                    <!-- Gambar -->
                    <a href="{{ route('produk.detail', $produk->id) }}" style="display:block;">
                    <div style="height:190px;overflow:hidden;background:#f0f0f0;display:flex;align-items:center;justify-content:center;">
                        @if($produk->gambar)
                            <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama_produk }}"
                                 style="width:100%;height:100%;object-fit:cover;">
                        @else
                            <span style="font-size:48px;">📦</span>
                        @endif
                    </div>
                    </a>
                    <!-- Info -->
                    <div class="card-body p-3">
                        @if($produk->kategori)
                            <span class="badge mb-1" style="background:rgba(38,185,154,0.12);color:#26b99a;font-size:11px;font-weight:600;">
                                {{ $produk->kategori }}
                            </span>
                        @endif
                        <h6 class="fw-bold mb-1 mt-1" style="color:#2a3f54;font-size:14px;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;line-height:1.4;">
                            <a href="{{ route('produk.detail', $produk->id) }}" style="color:#2a3f54;text-decoration:none;">{{ $produk->nama_produk }}</a>
                        </h6>
                        <p class="mb-1" style="font-size:12px;color:#888;">
                            <i class="fas fa-store me-1" style="color:#26b99a;"></i>{{ $produk->toko->nama_toko ?? '-' }}
                        </p>
                        <p class="fw-bold mb-1" style="color:#26b99a;font-size:15px;">
                            Rp {{ number_format($produk->harga, 0, ',', '.') }}
                        </p>
                        @if($produk->stok == 0)
                            <small class="text-danger"><i class="fas fa-times-circle me-1"></i>Stok habis</small>
                        @elseif($produk->stok < 10)
                            <small class="text-warning"><i class="fas fa-exclamation-triangle me-1"></i>Stok terbatas ({{ $produk->stok }})</small>
                        @endif
                    </div>
                    <!-- Tombol -->
                    <div class="card-footer bg-transparent border-0 p-3 pt-0">
                        <form action="{{ route('keranjang.tambah') }}" method="POST" class="mb-1">
                            @csrf
                            <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                            <input type="hidden" name="jumlah" value="1">
                        </form>
                        <div class="d-flex gap-1">
                            <a href="{{ route('produk.detail', $produk->id) }}"
                               class="btn fw-semibold flex-fill"
                               style="background:#f8f9fa;color:#2a3f54;border:1px solid #dee2e6;border-radius:8px;font-size:12px;padding:7px 4px;text-decoration:none;text-align:center;">
                                <i class="fas fa-eye me-1" style="color:#26b99a;"></i> Detail
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-3">
            {{ $produks->appends(request()->query())->links() }}
        </div>

        @else
        <div class="text-center py-5">
            <i class="fas fa-box-open fa-3x mb-3" style="color:#ddd;"></i>
            <h5 style="color:#666;">Belum ada produk tersedia</h5>
            <p class="text-muted">
                @if(request('cari') || request('kategori'))
                    Tidak ada produk yang cocok dengan pencarian Anda.
                    <a href="{{ route('pelanggan.dashboard') }}" class="text-decoration-none" style="color:#26b99a;">Reset filter</a>
                @else
                    Produk akan muncul di sini setelah toko mendaftarkan produknya.
                @endif
            </p>
        </div>
        @endif
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
                <li><a href="#produk"><i class="fas fa-chevron-right"></i> Semua Produk</a></li>
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
<script src="{{ asset('js/app-navbar.js') }}"></script>
</body>
</html>

