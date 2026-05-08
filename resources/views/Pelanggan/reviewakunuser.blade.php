<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $toko->nama_toko }} - NELA MART</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/toko-pelanggan.css') }}?v={{ time() }}" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="/" class="navbar-brand">NELA MART</a>
            <div class="navbar-menu">
                <a href="{{ route('pelanggan.dashboard') }}"><i class="fas fa-home"></i> Beranda</a>
                <a href="{{ route('keranjang.index') }}"><i class="fas fa-shopping-cart"></i> Keranjang</a>
                <a href="{{ route('profil.index') }}"><i class="fas fa-user"></i> Profil</a>
            </div>
        </div>
    </nav>

    <!-- Shop Header -->
    <div class="shop-header">
        <div class="shop-header-container">
            <div class="shop-avatar">
                🏪
            </div>
            <div class="shop-info">
                <h1 class="shop-name">{{ $toko->nama_toko }}</h1>
                <div class="shop-stats">
                    <div class="shop-stat">
                        <i class="fas fa-box"></i>
                        <span>{{ $toko->produks->count() }} Produk</span>
                    </div>
                    <div class="shop-stat">
                        <i class="fas fa-star"></i>
                        <span>4.8 Rating</span>
                    </div>
                    <div class="shop-stat">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>{{ Str::limit($toko->alamat, 30) }}</span>
                    </div>
                </div>
                @if($toko->deskripsi)
                <p class="shop-description">{{ $toko->deskripsi }}</p>
                @endif
                <div class="shop-actions">
                    <a href="{{ route('chat.user', $toko->user_id) }}" class="btn btn-white">
                        <i class="fas fa-comment"></i> Chat Penjual
                    </a>
                    <button class="btn btn-outline" onclick="alert('Fitur follow akan segera hadir!')">
                        <i class="fas fa-plus"></i> Follow
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Shop Tabs -->
    <div class="shop-tabs">
        <div class="shop-tabs-container">
            <a href="#produk" class="shop-tab active" onclick="switchTab(event, 'produk')">Produk</a>
            <a href="#tentang" class="shop-tab" onclick="switchTab(event, 'tentang')">Tentang Toko</a>
            <a href="#ulasan" class="shop-tab" onclick="switchTab(event, 'ulasan')">Ulasan</a>
        </div>
    </div>

    <!-- Content -->
    <div class="content">
        <!-- Tab: Produk -->
        <div id="produk" class="tab-content active">
            <!-- Products Header -->
            <div class="products-header">
                <h2 class="products-title">Semua Produk ({{ $produks->count() }})</h2>
                <div class="products-filter">
                    <select class="filter-select">
                        <option>Terbaru</option>
                        <option>Harga Terendah</option>
                        <option>Harga Tertinggi</option>
                        <option>Terlaris</option>
                    </select>
                </div>
            </div>

            <!-- Products Grid -->
            @if($produks->count() > 0)
            <div class="products-grid">
                @foreach($produks as $produk)
                <a href="{{ route('produk.detail', $produk->id) }}" class="product-card">
                    <div class="product-image">
                        @if($produk->gambar)
                            <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama_produk }}">
                        @else
                            <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:48px;background:#f5f5f5;">📦</div>
                        @endif
                        @if($produk->stok < 10 && $produk->stok > 0)
                            <span class="product-badge">Stok Terbatas</span>
                        @elseif($produk->stok == 0)
                            <span class="product-badge" style="background:#ef4444;">Habis</span>
                        @endif
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">{{ $produk->nama_produk }}</h3>
                        <div class="product-price">Rp {{ number_format($produk->harga, 0, ',', '.') }}</div>
                        <div class="product-meta">
                            @php 
                                $avgRating = $produk->ulasans->avg('rating') ?? 0;
                                $totalTerjual = $produk->pesananDetails->sum('jumlah') ?? 0;
                            @endphp
                            <span class="product-sold">
                                <i class="fas fa-shopping-bag"></i>
                                {{ $totalTerjual }} Terjual
                            </span>
                            <span class="product-rating">
                                <i class="fas fa-star"></i>
                                {{ number_format($avgRating, 1) }}
                            </span>
                            <span class="product-stok">Stok: {{ $produk->stok }}</span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            @else
            <div class="empty-state">
                <i class="fas fa-box-open"></i>
                <h3>Belum Ada Produk</h3>
                <p>Toko ini belum menambahkan produk untuk dijual</p>
            </div>
            @endif
        </div>

        <!-- Tab: Tentang Toko -->
        <div id="tentang" class="tab-content">
            <div style="background:white;border-radius:16px;padding:32px;box-shadow:0 4px 16px rgba(0,0,0,0.08);">
                <h2 style="font-size:1.5rem;font-weight:800;color:#2a3f54;margin-bottom:24px;border-bottom:2px solid #f1f5f9;padding-bottom:12px;">
                    <i class="fas fa-store me-2" style="color:#26b99a;"></i>Tentang {{ $toko->nama_toko }}
                </h2>

                <div style="margin-bottom:24px;">
                    <h3 style="font-size:1rem;font-weight:700;color:#2a3f54;margin-bottom:12px;">
                        <i class="fas fa-info-circle me-2" style="color:#26b99a;"></i>Deskripsi Toko
                    </h3>
                    @if($toko->deskripsi)
                        <p style="color:#555;line-height:1.8;white-space:pre-line;">{{ $toko->deskripsi }}</p>
                    @else
                        <p style="color:#888;font-style:italic;">Toko ini belum menambahkan deskripsi.</p>
                    @endif
                </div>

                <div style="margin-bottom:24px;">
                    <h3 style="font-size:1rem;font-weight:700;color:#2a3f54;margin-bottom:12px;">
                        <i class="fas fa-map-marker-alt me-2" style="color:#26b99a;"></i>Alamat
                    </h3>
                    <p style="color:#555;line-height:1.8;">{{ $toko->alamat }}</p>
                </div>

                <div style="margin-bottom:24px;">
                    <h3 style="font-size:1rem;font-weight:700;color:#2a3f54;margin-bottom:12px;">
                        <i class="fas fa-phone me-2" style="color:#26b99a;"></i>Kontak
                    </h3>
                    <p style="color:#555;line-height:1.8;">{{ $toko->telepon }}</p>
                </div>

                <div style="margin-bottom:24px;">
                    <h3 style="font-size:1rem;font-weight:700;color:#2a3f54;margin-bottom:12px;">
                        <i class="fas fa-chart-line me-2" style="color:#26b99a;"></i>Statistik Toko
                    </h3>
                    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px;">
                        <div style="background:#f8fafc;border-radius:12px;padding:20px;border-left:4px solid #26b99a;">
                            <div style="font-size:2rem;font-weight:800;color:#26b99a;">{{ $toko->produks->count() }}</div>
                            <div style="font-size:0.9rem;color:#888;margin-top:4px;">Total Produk</div>
                        </div>
                        <div style="background:#f8fafc;border-radius:12px;padding:20px;border-left:4px solid #3b82f6;">
                            @php
                                $totalTerjual = $toko->produks->sum(function($p) {
                                    return $p->pesananDetails->sum('jumlah');
                                });
                            @endphp
                            <div style="font-size:2rem;font-weight:800;color:#3b82f6;">{{ $totalTerjual }}</div>
                            <div style="font-size:0.9rem;color:#888;margin-top:4px;">Produk Terjual</div>
                        </div>
                        <div style="background:#f8fafc;border-radius:12px;padding:20px;border-left:4px solid #ffc107;">
                            @php
                                $avgRating = 0;
                                $totalUlasan = 0;
                                foreach($toko->produks as $produk) {
                                    $totalUlasan += $produk->ulasans->count();
                                    $avgRating += $produk->ulasans->sum('rating');
                                }
                                $avgRating = $totalUlasan > 0 ? $avgRating / $totalUlasan : 0;
                            @endphp
                            <div style="font-size:2rem;font-weight:800;color:#ffc107;">{{ number_format($avgRating, 1) }}</div>
                            <div style="font-size:0.9rem;color:#888;margin-top:4px;">Rating Rata-rata</div>
                        </div>
                    </div>
                </div>

                @if($toko->gunakan_rajaongkir)
                <div style="margin-bottom:24px;">
                    <h3 style="font-size:1rem;font-weight:700;color:#2a3f54;margin-bottom:12px;">
                        <i class="fas fa-shipping-fast me-2" style="color:#26b99a;"></i>Pengiriman
                    </h3>
                    <div style="background:#e0f2fe;border:1px solid #bae6fd;border-radius:10px;padding:16px;">
                        <div style="display:flex;align-items:center;gap:12px;">
                            <div style="width:48px;height:48px;background:#26b99a;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-truck" style="color:white;font-size:20px;"></i>
                            </div>
                            <div>
                                <div style="font-weight:600;color:#2a3f54;margin-bottom:4px;">Menggunakan Jasa Pengiriman</div>
                                <div style="font-size:0.9rem;color:#555;">Dikirim dari: {{ $toko->kota_asal_nama ?? 'Tidak diketahui' }}</div>
                                <div style="font-size:0.85rem;color:#888;margin-top:4px;">Tersedia: JNE, TIKI, POS Indonesia</div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Tab: Ulasan -->
        <div id="ulasan" class="tab-content">
            <div style="background:white;border-radius:16px;padding:32px;box-shadow:0 4px 16px rgba(0,0,0,0.08);">
                <h2 style="font-size:1.5rem;font-weight:800;color:#2a3f54;margin-bottom:24px;border-bottom:2px solid #f1f5f9;padding-bottom:12px;">
                    <i class="fas fa-star me-2" style="color:#ffc107;"></i>Ulasan Toko
                </h2>

                @php
                    $allUlasans = collect();
                    foreach($toko->produks as $produk) {
                        foreach($produk->ulasans as $ulasan) {
                            $ulasan->produk_nama = $produk->nama_produk;
                            $allUlasans->push($ulasan);
                        }
                    }
                    $allUlasans = $allUlasans->sortByDesc('created_at');
                @endphp

                @if($allUlasans->count() > 0)
                    <!-- Rating Summary -->
                    <div style="background:#f8fafc;border-radius:12px;padding:24px;margin-bottom:24px;">
                        <div style="display:flex;align-items:center;gap:32px;flex-wrap:wrap;">
                            <div style="text-align:center;">
                                <div style="font-size:3rem;font-weight:800;color:#26b99a;">{{ number_format($avgRating, 1) }}</div>
                                <div style="margin:8px 0;">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star" style="color:{{ $i <= round($avgRating) ? '#ffc107' : '#ddd' }};font-size:18px;"></i>
                                    @endfor
                                </div>
                                <div style="font-size:0.9rem;color:#888;">{{ $allUlasans->count() }} Ulasan</div>
                            </div>
                            <div style="flex:1;min-width:250px;">
                                @for($star = 5; $star >= 1; $star--)
                                    @php
                                        $count = $allUlasans->where('rating', $star)->count();
                                        $percentage = $allUlasans->count() > 0 ? ($count / $allUlasans->count()) * 100 : 0;
                                    @endphp
                                    <div style="display:flex;align-items:center;gap:12px;margin-bottom:8px;">
                                        <div style="display:flex;gap:2px;min-width:80px;">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star" style="color:{{ $i <= $star ? '#ffc107' : '#ddd' }};font-size:12px;"></i>
                                            @endfor
                                        </div>
                                        <div style="flex:1;height:8px;background:#e2e8f0;border-radius:4px;overflow:hidden;">
                                            <div style="height:100%;background:#ffc107;width:{{ $percentage }}%;transition:width 0.3s;"></div>
                                        </div>
                                        <div style="min-width:40px;text-align:right;font-size:0.85rem;color:#888;">{{ $count }}</div>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>

                    <!-- Ulasan List -->
                    @foreach($allUlasans as $ulasan)
                    <div style="border-bottom:1px solid #f1f5f9;padding:20px 0;">
                        <div style="display:flex;gap:16px;">
                            <div style="width:48px;height:48px;border-radius:50%;background:linear-gradient(135deg,#2a3f54,#26b99a);display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:18px;flex-shrink:0;">
                                {{ strtoupper(substr($ulasan->user->name ?? 'U', 0, 1)) }}
                            </div>
                            <div style="flex:1;">
                                <div style="display:flex;justify-content:space-between;align-items:start;margin-bottom:8px;">
                                    <div>
                                        <div style="font-weight:600;color:#2a3f54;margin-bottom:4px;">{{ $ulasan->user->name ?? 'Pengguna' }}</div>
                                        <div style="font-size:0.85rem;color:#888;margin-bottom:6px;">{{ $ulasan->created_at->format('d M Y') }}</div>
                                        <div style="margin-bottom:6px;">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star" style="color:{{ $i <= $ulasan->rating ? '#ffc107' : '#ddd' }};font-size:14px;"></i>
                                            @endfor
                                        </div>
                                        <div style="display:inline-block;background:#f0fdf9;color:#26b99a;padding:4px 10px;border-radius:6px;font-size:0.8rem;font-weight:600;">
                                            <i class="fas fa-box me-1"></i>{{ $ulasan->produk_nama }}
                                        </div>
                                    </div>
                                </div>
                                @if($ulasan->komentar)
                                    <p style="color:#555;line-height:1.6;margin-top:12px;">{{ $ulasan->komentar }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="empty-state">
                        <i class="fas fa-comment-slash"></i>
                        <h3>Belum Ada Ulasan</h3>
                        <p>Toko ini belum memiliki ulasan dari pembeli</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="{{ asset('js/cart-utils.js') }}"></script>
    <script>
        // Tab Switching
        function switchTab(event, tabId) {
            event.preventDefault();
            
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Remove active class from all tabs
            document.querySelectorAll('.shop-tab').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Show selected tab content
            document.getElementById(tabId).classList.add('active');
            
            // Add active class to clicked tab
            event.target.classList.add('active');
            
            // Scroll to content
            document.querySelector('.content').scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
        
        // Filter products
        document.querySelector('.filter-select')?.addEventListener('change', function() {
            alert('Fitur sorting: ' + this.value);
        });
    </script>
</body>
</html>

