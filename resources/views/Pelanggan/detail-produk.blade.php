<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $produk->nama_produk }} - NELA MART</title>
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

<!-- ===== BREADCRUMB ===== -->
<div style="background:white;border-bottom:1px solid #f1f5f9;padding:12px 20px;">
    <div class="container" style="max-width:1100px;">
        <nav style="font-size:13px;color:#888;">
            <a href="{{ route('pelanggan.dashboard') }}" style="color:#26b99a;text-decoration:none;">Beranda</a>
            <span class="mx-2">/</span>
            @if($produk->toko)
                <a href="{{ route('toko.show', $produk->toko->id) }}" style="color:#26b99a;text-decoration:none;">{{ $produk->toko->nama_toko }}</a>
                <span class="mx-2">/</span>
            @endif
            <span style="color:#333;">{{ Str::limit($produk->nama_produk, 40) }}</span>
        </nav>
    </div>
</div>

<!-- ===== DETAIL PRODUK ===== -->
<section style="padding:40px 20px;background:#f5f5f5;">
    <div class="container" style="max-width:1100px;">

        @if(session('success'))
            <div class="alert alert-success rounded-3 mb-4">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger rounded-3 mb-4">{{ session('error') }}</div>
        @endif

        <div class="row g-4">
            <!-- Gambar Produk -->
            <div class="col-lg-5">
                <div style="background:white;border-radius:16px;overflow:hidden;box-shadow:0 4px 16px rgba(0,0,0,0.08);">
                    @if($produk->gambar)
                        <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama_produk }}"
                             style="width:100%;height:420px;object-fit:cover;">
                    @else
                        <div style="width:100%;height:420px;background:linear-gradient(135deg,#2a3f54,#26b99a);display:flex;align-items:center;justify-content:center;font-size:80px;">
                            📦
                        </div>
                    @endif
                </div>
            </div>

            <!-- Info Produk -->
            <div class="col-lg-7">
                <div style="background:white;border-radius:16px;padding:32px;box-shadow:0 4px 16px rgba(0,0,0,0.08);">

                    @if($produk->kategori)
                        <span class="badge mb-2" style="background:rgba(38,185,154,0.12);color:#26b99a;font-size:12px;font-weight:600;padding:6px 12px;border-radius:20px;">
                            {{ $produk->kategori }}
                        </span>
                    @endif

                    <h1 style="font-size:1.6rem;font-weight:800;color:#2a3f54;margin-bottom:8px;">
                        {{ $produk->nama_produk }}
                    </h1>

                    <!-- Rating ringkas -->
                    @php $avgRating = $produk->ulasans->avg('rating'); @endphp
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div>
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star" style="color:{{ $i <= round($avgRating) ? '#ffc107' : '#ddd' }};font-size:14px;"></i>
                            @endfor
                        </div>
                        <span style="font-size:13px;color:#888;">
                            {{ $avgRating ? number_format($avgRating, 1) : '0.0' }} ({{ $produk->ulasans->count() }} ulasan)
                        </span>
                    </div>

                    <!-- Harga -->
                    <div style="font-size:2rem;font-weight:800;color:#26b99a;margin-bottom:16px;" id="hargaTampil">
                        Rp {{ number_format($produk->harga, 0, ',', '.') }}
                    </div>

                    <!-- Stok -->
                    <div class="mb-3" style="font-size:14px;">
                        @if($produk->stok > 10)
                            <span style="color:#26b99a;"><i class="fas fa-check-circle me-1"></i>Stok tersedia ({{ $produk->stok }})</span>
                        @elseif($produk->stok > 0)
                            <span style="color:#f59e0b;"><i class="fas fa-exclamation-triangle me-1"></i>Stok terbatas ({{ $produk->stok }})</span>
                        @else
                            <span style="color:#ef4444;"><i class="fas fa-times-circle me-1"></i>Stok habis</span>
                        @endif
                    </div>

                    <!-- Toko -->
                    @if($produk->toko)
                    <div class="mb-4 p-3" style="background:#f8fafc;border-radius:10px;border-left:3px solid #26b99a;">
                        <div style="font-size:13px;color:#888;margin-bottom:4px;">Dijual oleh</div>
                        <a href="{{ route('toko.show', $produk->toko->id) }}" style="color:#2a3f54;text-decoration:none;font-weight:700;font-size:15px;">
                            <i class="fas fa-store me-2" style="color:#26b99a;"></i>{{ $produk->toko->nama_toko }}
                        </a>
                        @if($produk->toko->alamat)
                            <div style="font-size:12px;color:#888;margin-top:4px;">
                                <i class="fas fa-map-marker-alt me-1"></i>{{ $produk->toko->alamat }}
                            </div>
                        @endif
                    </div>
                    @endif

                    <!-- Varian -->
                    @if($produk->varians->count() > 0)
                    <div class="mb-4">
                        <div style="font-size:14px;font-weight:600;color:#2a3f54;margin-bottom:10px;">Pilih Varian:</div>
                        <div class="d-flex flex-wrap gap-2" id="varianButtons">
                            @foreach($produk->varians as $varian)
                            <button type="button" class="btn varian-btn"
                                data-harga="{{ $produk->harga + $varian->harga_tambahan }}"
                                data-stok="{{ $varian->stok }}"
                                data-id="{{ $varian->id }}"
                                onclick="pilihVarian(this)"
                                style="border:2px solid #dee2e6;border-radius:8px;padding:8px 16px;font-size:13px;font-weight:600;color:#2a3f54;background:white;transition:all 0.2s;">
                                {{ $varian->nama_varian }}
                                @if($varian->harga_tambahan > 0)
                                    <span style="color:#26b99a;font-size:11px;">+Rp {{ number_format($varian->harga_tambahan, 0, ',', '.') }}</span>
                                @endif
                            </button>
                            @endforeach
                        </div>
                        <input type="hidden" id="selectedVarian" value="">
                    </div>
                    @endif

                    <!-- Jumlah & Aksi -->
                    @if($produk->stok > 0)
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="d-flex align-items-center" style="border:2px solid #dee2e6;border-radius:10px;overflow:hidden;">
                            <button type="button" onclick="changeQty(-1)"
                                style="width:40px;height:40px;border:none;background:#f8fafc;font-size:18px;font-weight:700;color:#2a3f54;cursor:pointer;">−</button>
                            <input type="number" id="jumlahInput" value="1" min="1" max="{{ $produk->stok }}"
                                style="width:56px;height:40px;border:none;text-align:center;font-weight:700;font-size:15px;color:#2a3f54;">
                            <button type="button" onclick="changeQty(1)"
                                style="width:40px;height:40px;border:none;background:#f8fafc;font-size:18px;font-weight:700;color:#2a3f54;cursor:pointer;">+</button>
                        </div>
                        <span style="font-size:13px;color:#888;">Maks. {{ $produk->stok }}</span>
                    </div>

                    <div class="d-flex gap-2 flex-wrap">
                        <form action="{{ route('keranjang.tambah') }}" method="POST" id="formKeranjang">
                            @csrf
                            <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                            <input type="hidden" name="jumlah" id="jumlahKeranjang" value="1">
                            <button type="submit" class="btn fw-semibold"
                                style="background:#f1f5f9;color:#2a3f54;border:2px solid #dee2e6;border-radius:10px;padding:12px 24px;">
                                <i class="fas fa-cart-plus me-2"></i> Keranjang
                            </button>
                        </form>
                        <form action="{{ route('produk.beli', $produk->id) }}" method="POST" id="formBeli">
                            @csrf
                            <input type="hidden" name="jumlah" id="jumlahBeli" value="1">
                            <button type="submit" class="btn fw-semibold text-white"
                                style="background:linear-gradient(135deg,#26b99a,#1abb9c);border:none;border-radius:10px;padding:12px 28px;">
                                <i class="fas fa-bolt me-2"></i> Beli Sekarang
                            </button>
                        </form>
                    </div>
                    @else
                    <div class="alert alert-danger rounded-3">
                        <i class="fas fa-times-circle me-2"></i> Produk ini sedang tidak tersedia.
                    </div>
                    @endif

                </div>
            </div>
        </div>

        <!-- ===== DESKRIPSI ===== -->
        <div class="row mt-4">
            <div class="col-12">
                <div style="background:white;border-radius:16px;padding:28px;box-shadow:0 4px 16px rgba(0,0,0,0.08);">
                    <h5 class="fw-bold mb-3" style="color:#2a3f54;border-bottom:2px solid #f1f5f9;padding-bottom:12px;">
                        <i class="fas fa-info-circle me-2" style="color:#26b99a;"></i> Deskripsi Produk
                    </h5>
                    <p style="color:#555;line-height:1.8;white-space:pre-line;">{{ $produk->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
                </div>
            </div>
        </div>

        <!-- ===== ULASAN ===== -->
        <div class="row mt-4" id="ulasan">
            <div class="col-12">
                <div style="background:white;border-radius:16px;padding:28px;box-shadow:0 4px 16px rgba(0,0,0,0.08);">
                    <h5 class="fw-bold mb-4" style="color:#2a3f54;border-bottom:2px solid #f1f5f9;padding-bottom:12px;">
                        <i class="fas fa-star me-2" style="color:#ffc107;"></i> Ulasan Pembeli ({{ $produk->ulasans->count() }})
                    </h5>
                    {{-- Form Tulis Ulasan --}}
                    @auth
                    @if(!$sudahDiulas)
                    <div class="mb-4 p-4" style="background:linear-gradient(135deg,#f8fafc,#f0fdf9);border-radius:14px;border:1px solid #d1fae5;">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div style="width:36px;height:36px;background:linear-gradient(135deg,#26b99a,#1abb9c);border-radius:50%;display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-pen" style="color:white;font-size:14px;"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0" style="color:#2a3f54;">Tulis Ulasan Anda</h6>
                                <small style="color:#888;">Bagikan pengalaman Anda dengan produk ini</small>
                            </div>
                        </div>
                        <form action="{{ route('review.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="produk_id" value="{{ $produk->id }}">

                            {{-- Star Rating --}}
                            <div class="mb-4">
                                <label class="form-label fw-semibold mb-2" style="color:#2a3f54;font-size:14px;">Berikan Rating</label>
                                <div class="d-flex flex-column align-items-start gap-2">
                                    <div class="d-flex gap-1" id="dpStarRow">
                                        @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star dp-star"
                                           data-val="{{ $i }}"
                                           style="font-size:32px;color:#ddd;cursor:pointer;transition:color 0.15s,transform 0.1s;"
                                           onclick="dpSetRating({{ $i }})"
                                           onmouseover="dpHover({{ $i }})"
                                           onmouseout="dpResetHover()"></i>
                                        @endfor
                                    </div>
                                    <div id="dpRatingBadge" style="display:none;padding:4px 14px;border-radius:20px;font-size:13px;font-weight:600;background:rgba(38,185,154,0.12);color:#26b99a;">
                                        <i class="fas fa-star me-1"></i><span id="dpRatingLabel">Pilih rating</span>
                                    </div>
                                </div>
                                <input type="hidden" name="rating" id="dpRatingInput" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold" style="color:#2a3f54;font-size:14px;">
                                    Komentar <span class="text-muted fw-normal">(opsional)</span>
                                </label>
                                <textarea name="komentar" class="form-control" rows="3"
                                          placeholder="Ceritakan pengalaman Anda dengan produk ini..."
                                          style="border-radius:10px;border:2px solid #e2e8f0;font-size:14px;resize:vertical;transition:border-color 0.2s;"
                                          onfocus="this.style.borderColor='#26b99a'"
                                          onblur="this.style.borderColor='#e2e8f0'"></textarea>
                            </div>
                            <button type="submit" class="btn fw-semibold text-white px-4 py-2"
                                style="background:linear-gradient(135deg,#26b99a,#1abb9c);border:none;border-radius:10px;font-size:14px;transition:opacity 0.2s;"
                                onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                                <i class="fas fa-paper-plane me-2"></i> Kirim Ulasan
                            </button>
                        </form>
                    </div>
                    @else
                    <div class="mb-4 p-3 rounded-3 d-flex align-items-center gap-3" style="background:rgba(38,185,154,0.08);border:1px solid rgba(38,185,154,0.2);">
                        <div style="width:40px;height:40px;background:rgba(38,185,154,0.15);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="fas fa-check" style="color:#26b99a;font-size:16px;"></i>
                        </div>
                        <div>
                            <div style="color:#26b99a;font-weight:600;font-size:14px;">Ulasan sudah dikirim</div>
                            <div style="color:#888;font-size:13px;">Terima kasih telah memberikan ulasan untuk produk ini.</div>
                        </div>
                    </div>
                    @endif
                    @endauth

                    {{-- Daftar Ulasan --}}
                    @forelse($produk->ulasans as $ulasan)
                    <div class="d-flex gap-3 mb-4 pb-4" style="border-bottom:1px solid #f1f5f9;">
                        <div style="width:42px;height:42px;border-radius:50%;background:linear-gradient(135deg,#2a3f54,#26b99a);display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:16px;flex-shrink:0;">
                            {{ strtoupper(substr($ulasan->user->name ?? 'U', 0, 1)) }}
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <span class="fw-semibold" style="color:#2a3f54;font-size:14px;">{{ $ulasan->user->name ?? 'Pengguna' }}</span>
                                    <div class="mt-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star" style="color:{{ $i <= $ulasan->rating ? '#ffc107' : '#ddd' }};font-size:13px;"></i>
                                        @endfor
                                    </div>
                                </div>
                                <small class="text-muted">{{ $ulasan->created_at->format('d M Y') }}</small>
                            </div>
                            @if($ulasan->komentar)
                                <p class="mt-2 mb-0" style="color:#555;font-size:14px;line-height:1.6;">{{ $ulasan->komentar }}</p>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <i class="fas fa-comment-slash fa-2x mb-2" style="color:#ddd;"></i>
                        <p class="text-muted mb-0">Belum ada ulasan untuk produk ini.</p>
                    </div>
                    @endforelse

                </div>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('pelanggan.dashboard') }}" class="btn px-4 py-2 fw-semibold"
               style="background:#f1f5f9;color:#2a3f54;border-radius:10px;text-decoration:none;">
                <i class="fas fa-arrow-left me-2"></i> Kembali
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
                <li><a href="{{ route('chat.admin') }}"><i class="fas fa-chevron-right"></i> Chat Admin</a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2026 NELA MART. Dibuat dengan <i class="fas fa-heart" style="color:#e74c3c;"></i> untuk UMKM Indonesia.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/app-navbar.js') }}"></script>
<script src="{{ asset('js/product-detail.js') }}"></script>
</body>
</html>

