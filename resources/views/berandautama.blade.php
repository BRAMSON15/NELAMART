<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NELA MART - Platform Produk Lokal Terbaik</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/beranda.css') }}?v={{ time() }}" rel="stylesheet">
    <link href="{{ asset('css/pelanggan-theme.css') }}?v={{ time() }}" rel="stylesheet">
</head>

<body>

    <!-- ===== NAVBAR ===== -->
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <a href="/" class="logo"><i class="fas fa-store"></i> NELA MART</a>
            <!-- <ul class="nav-menu">
                <li><a href="#beranda">Beranda</a></li>
                <li><a href="#produk">Produk</a></li>
                <li><a href="#tentang">Tentang</a></li>
                <li><a href="#kontak">Kontak</a></li>
            </ul> -->
            <div class="nav-buttons">
            </div>
            <button class="nav-toggle" id="navToggle"><i class="fas fa-bars"></i></button>
        </div>
    </nav>

    <!-- ===== HERO ===== -->
    <section class="hero" id="beranda">
        <div class="hero-shape hero-shape-1"></div>
        <div class="hero-shape hero-shape-2"></div>
        <div class="hero-shape hero-shape-3"></div>
        <div class="particles">
            <div class="particle" style="left:10%;animation-delay:0s;"></div>
            <div class="particle" style="left:25%;animation-delay:2s;"></div>
            <div class="particle" style="left:50%;animation-delay:4s;"></div>
            <div class="particle" style="left:75%;animation-delay:1s;"></div>
            <div class="particle" style="left:90%;animation-delay:3s;"></div>
        </div>
        <div class="hero-container">
            <div class="hero-badge"><i class="fas fa-certificate"></i> Platform UMKM Negeri Lama</div>
            <h1>Belanja Produk Lokal<br><span class="hero-highlight">UMKM Negeri Lama</span></h1>
            <p>Temukan produk yang ingin kamu cari, untuk mendukung sistem UMKM Negeri Lama</p>
            <div class="hero-buttons">
                <a href="/pelanggan/login" class="btn btn-white btn-hero"><i class="fas fa-shopping-bag"></i> Mulai
                    Belanja</a>
                <a href="#produk" class="btn btn-outline-white btn-hero"><i class="fas fa-search"></i> Jelajahi
                    Produk</a>
            </div>
            <div class="hero-trust">
                <div class="trust-item"><i class="fas fa-shield-alt"></i> Transaksi Aman</div>
                <div class="trust-item"><i class="fas fa-truck"></i> Pengiriman Cepat</div>
                <div class="trust-item"><i class="fas fa-undo"></i> Garansi Produk</div>
            </div>
        </div>
        <a href="#stats" class="scroll-indicator"><span></span><span></span><span></span></a>
    </section>
    <!-- ===== STATS ===== -->
    <section class="stats" id="stats">
        <div class="stats-container">
            <div class="stat-item">
                <div class="stat-icon"><i class="fas fa-box"></i></div>
                <div class="stat-number">{{ \App\Models\Produk::count() }}+</div>
                <div class="stat-label">Produk UMKM</div>
            </div>
            <div class="stat-item">
                <div class="stat-icon"><i class="fas fa-store"></i></div>
                <div class="stat-number">{{ \App\Models\Toko::where('status', 'aktif')->count() }}+</div>
                <div class="stat-label">Toko Aktif</div>
            </div>
            <div class="stat-item">
                <div class="stat-icon"><i class="fas fa-users"></i></div>
                <div class="stat-number">{{ \App\Models\User::where('role', 'pelanggan')->count() }}+</div>
                <div class="stat-label">Pelanggan</div>
            </div>
        </div>
        </div>
    </section>

    <header class="bg-dark py-5" id="produk">
        <div class="container px-4 px-lg-5 my-3">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">Temukan Produk UMKM Terbaik</h1>
                <!-- <p class="lead fw-normal text-white-50 mb-4">Produk berkualitas langsung dari pengrajin lokal Indonesia
                </p> -->
                <form action="/" method="GET" class="d-flex justify-content-center">
                    @if(request('kategori'))
                        <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                    @endif
                    <div class="input-group" style="max-width:480px;">
                        <input type="text" name="cari" class="form-control form-control-lg"
                            placeholder="Cari produk UMKM..." value="{{ request('cari') }}">
                        <button class="btn btn-primary px-4" type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </header>

    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-4">
            {{-- Filter Kategori --}}
            <div class="d-flex justify-content-center gap-2 flex-wrap mb-5">
                <a href="/"
                    class="btn {{ !request('kategori') ? 'btn-dark' : 'btn-outline-dark' }} btn-sm px-4">Semua</a>
                @foreach(['Makanan', 'Minuman', 'Fashion', 'Kerajinan', 'Elektronik', 'Lainnya'] as $kat)
                    <a href="/?kategori={{ $kat }}"
                        class="btn {{ request('kategori') == $kat ? 'btn-dark' : 'btn-outline-dark' }} btn-sm px-4">{{ $kat }}</a>
                @endforeach
            </div>

            <div class="row gx-2 gx-sm-3 row-cols-2 row-cols-md-3 row-cols-lg-4 justify-content-center">
                @forelse($produks as $produk)
                    <div class="col mb-3 mb-sm-5">
                        <div class="card h-100 shadow-sm border-0" style="border-radius:12px;overflow:hidden;">
                            <div class="badge text-white position-absolute"
                                style="top:0.4rem;left:0.4rem;background:#26b99a;z-index:1;font-size:0.65rem;padding:0.25rem 0.4rem;">
                                {{ $produk->kategori }}
                            </div>
                            <a href="{{ route('produk.detail', $produk->id) }}" style="text-decoration:none; color:inherit;">
                                @if($produk->gambar)
                                    <img class="card-img-top product-image-responsive" src="{{ asset('storage/' . $produk->gambar) }}"
                                        alt="{{ $produk->nama_produk }}">
                                @else
                                    <div
                                        class="card-img-top product-image-placeholder d-flex align-items-center justify-content-center">
                                        <i class="fas fa-box fa-2x"></i>
                                    </div>
                                @endif
                            </a>
                            <div class="card-body p-2 p-sm-4">
                                <div class="text-center">
                                    <small class="text-muted d-block mb-1" style="font-size:0.7rem;">
                                        <a href="{{ route('toko.show', $produk->toko->id) }}" style="text-decoration:none; color:inherit;">
                                            <i class="fas fa-store me-1" style="color:#26b99a;"></i>{{ Str::limit($produk->toko->nama_toko, 15) }}
                                        </a>
                                    </small>
                                    <a href="{{ route('produk.detail', $produk->id) }}" style="text-decoration:none; color:inherit;">
                                        <h5 class="fw-bolder mb-1" style="font-size:0.9rem;">{{ Str::limit($produk->nama_produk, 30) }}</h5>
                                    </a>
                                    <p class="text-muted small mb-2 d-none d-sm-block" style="font-size:0.75rem;">{{ Str::limit($produk->deskripsi, 60) }}</p>
                                    <span class="fw-bold d-block mb-1" style="color:#26b99a;font-size:0.9rem;">
                                        Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                    </span>
                                    @if($produk->stok > 0)
                                        <div><small class="text-success" style="font-size:0.7rem;"><i class="fas fa-check-circle"></i> Stok:
                                                {{ $produk->stok }}</small></div>
                                    @else
                                        <div><small class="text-danger" style="font-size:0.7rem;"><i class="fas fa-times-circle"></i> Habis</small></div>
                                    @endif
                                </div>
                            </div>
                            <div class="card-footer p-2 p-sm-3 border-top-0 bg-transparent">
                                <div class="d-grid mobile-hide-btn">
                                    <a href="/pelanggan/login" class="btn btn-outline-dark btn-sm" style="font-size:0.75rem;padding:0.25rem 0.5rem;">
                                        <i class="fas fa-cart-plus me-1"></i> <span class="d-none d-sm-inline">Beli
                                            Sekarang</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-box-open fa-4x text-muted mb-3 d-block"></i>
                        <h5 class="text-muted">Belum ada produk tersedia</h5>
                        <p class="text-muted">Produk akan muncul setelah toko UMKM diverifikasi</p>
                        <a href="/user/register" class="btn btn-primary mt-2">Daftar Sebagai Penjual</a>
                    </div>
                @endforelse
            </div>

            @if($produks->count() >= 8)
                <div class="text-center mt-3 mb-5">
                    <a href="/pelanggan/login" class="btn btn-dark btn-lg px-5">
                        <i class="fas fa-th-large me-2"></i> Lihat Semua Produk
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- ===== TOKO UNGGULAN ===== -->
    <section class="toko-section" id="tentang">
        <div class="section-header">
            <span class="section-badge"><i class="fas fa-award"></i> Toko Terverifikasi</span>
            <h2>UMKM Terpercaya Kami</h2>
            <p>Toko-toko UMKM yang telah terverifikasi dan siap melayani Anda</p>
        </div>
        <div class="toko-grid">
            @forelse(\App\Models\Toko::where('status', 'aktif')->latest()->take(4)->get() as $toko)
                <a href="{{ route('toko.show', $toko->id) }}" style="text-decoration:none; color:inherit;">
                    <div class="toko-card">
                        <div class="toko-status-indicator"></div>
                        <div class="toko-avatar">{{ strtoupper(substr($toko->nama_toko, 0, 2)) }}</div>
                        <div class="toko-info">
                            <div class="toko-name">{{ $toko->nama_toko }}</div>
                            <div class="toko-meta"><i class="fas fa-map-marker-alt"></i> {{ Str::limit($toko->alamat, 30) }}
                            </div>
                            <div class="toko-meta"><i class="fas fa-box-open"></i>
                                {{ \App\Models\Produk::where('toko_id', $toko->id)->count() }} produk</div>
                            <span class="toko-badge"><i class="fas fa-check-circle"></i> Terverifikasi</span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="toko-card">
                    <div class="toko-status-indicator"></div>
                    <div class="toko-avatar">UM</div>
                    <div class="toko-info">
                        <div class="toko-name">Toko UMKM Contoh</div>
                        <div class="toko-meta"><i class="fas fa-map-marker-alt"></i> Jakarta, Indonesia</div>
                        <div class="toko-meta"><i class="fas fa-box-open"></i> 0 produk</div>
                        <span class="toko-badge"><i class="fas fa-check-circle"></i> Terverifikasi</span>
                    </div>
                </div>
            @endforelse
        </div>
    </section>

    <!-- ===== FITUR ===== -->
    <section class="fitur-section">
        <div class="section-header">
            <span class="section-badge"><i class="fas fa-star"></i> Keunggulan Kami</span>
            <h2>Mengapa Pilih NELA MART?</h2>
        </div>
        <div class="fitur-grid">
            <div class="fitur-card">
                <div class="fitur-icon"><i class="fas fa-shield-alt"></i></div>
                <h3>Transaksi Aman</h3>
                <p>Sistem pembayaran terenkripsi dan terpercaya untuk keamanan transaksi Anda.</p>
            </div>
            <div class="fitur-card">
                <div class="fitur-icon"><i class="fas fa-certificate"></i></div>
                <h3>Produk Terverifikasi</h3>
                <p>Semua produk dan toko telah melalui proses verifikasi ketat oleh tim kami.</p>
            </div>
            <div class="fitur-card">
                <div class="fitur-icon"><i class="fas fa-headset"></i></div>
                <h3>Dukungan 24/7</h3>
                <p>Tim customer service kami siap membantu Anda kapan saja dan di mana saja.</p>
            </div>
            <div class="fitur-card">
                <div class="fitur-icon"><i class="fas fa-hand-holding-heart"></i></div>
                <h3>Dukung UMKM Lokal</h3>
                <p>Setiap pembelian Anda berkontribusi langsung pada pertumbuhan UMKM Indonesia.</p>
            </div>
        </div>
    </section>

    <!-- ===== CTA ===== -->
    <section class="cta-section" id="kontak">
        <div class="cta-shape cta-shape-1"></div>
        <div class="cta-shape cta-shape-2"></div>
        <div class="cta-container">
            <div class="cta-icon"><i class="fas fa-store"></i></div>
            <h2>Punya Usaha UMKM?</h2>
            <p>Daftarkan toko Anda dan jangkau lebih banyak pelanggan. Gratis dan mudah!</p>
            <div class="hero-buttons">
                <a href="{{ route('user.register') }}" class="btn btn-white btn-hero"><i class="fas fa-store"></i> Daftar Sebagai
                    Penjual</a>
                 <a href="{{ route('user.login') }}" class="btn btn-white btn-hero"><i class="fas fa-sign-in-alt"></i> Login Sebagai
                    Penjual</a>
                <!-- <a href="{{ route('pelanggan.login') }}" class="btn btn-outline-white btn-hero"><i class="fas fa-shopping-bag"></i>
                    Mulai Belanja</a> -->
            </div>
        </div>
    </section>

    <!-- ===== FOOTER ===== -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-brand">
                <h3><i class="fas fa-store"></i> NELA MART</h3>
                <p>Platform terpercaya untuk menemukan dan membeli produk-produk yang berkualitas.</p>
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
                    <li><a href="#kategori"><i class="fas fa-chevron-right"></i> Kategori</a></li>
                    <li><a href="/pelanggan/login"><i class="fas fa-chevron-right"></i> Login Pelanggan</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h4>Penjual</h4>
                <ul class="footer-links">
                    <li><a href="/user/register"><i class="fas fa-chevron-right"></i> Daftar Toko</a></li>
                    <li><a href="/user/login"><i class="fas fa-chevron-right"></i> Login Penjual</a></li>
                    <li><a href="/admin/login"><i class="fas fa-chevron-right"></i> Admin</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h4>Bantuan</h4>
                <ul class="footer-links">
                    <li><a href="#"><i class="fas fa-chevron-right"></i> FAQ</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Kebijakan Privasi</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Syarat & Ketentuan</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 NELA MART Dibuat dengan <i class="fas fa-heart" style="color:#e74c3c;"></i> untuk UMKM
                Negeri lama.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/app-navbar.js') }}"></script>
</body>

</html>
