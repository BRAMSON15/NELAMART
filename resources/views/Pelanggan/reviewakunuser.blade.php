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
            <a href="#" class="shop-tab active">Produk</a>
            <a href="#" class="shop-tab">Tentang Toko</a>
            <a href="#" class="shop-tab">Ulasan</a>
        </div>
    </div>

    <!-- Content -->
    <div class="content">
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
            <a href="#" class="product-card" onclick="addToCart({{ $produk->id }}); return false;">
                <div class="product-image">
                    @if($produk->gambar)
                        <img src="{{ Storage::url($produk->gambar) }}" alt="{{ $produk->nama_produk }}">
                    @else
                        📦
                    @endif
                    @if($produk->stok < 10)
                        <span class="product-badge">Stok Terbatas</span>
                    @endif
                </div>
                <div class="product-info">
                    <h3 class="product-name">{{ $produk->nama_produk }}</h3>
                    <div class="product-price">Rp {{ number_format($produk->harga, 0, ',', '.') }}</div>
                    <div class="product-meta">
                        <span class="product-sold">
                            <i class="fas fa-shopping-bag"></i>
                            {{ rand(10, 500) }} Terjual
                        </span>
                        <span class="product-rating">
                            <i class="fas fa-star"></i>
                            {{ number_format(rand(40, 50) / 10, 1) }}
                        </span>
                        <span class="product-stok">stok: {{ $produk->stok }}</span>
                        <!-- <span class="product-view">view: {{ $produk->view }}</span> -->
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

    <script src="{{ asset('js/cart-utils.js') }}"></script>
    <script>
        function addToCartHandler(productId) {
            addToCart(productId, '{{ csrf_token() }}', '{{ route("keranjang.tambah") }}');
        }
        
        // Filter products
        document.querySelector('.filter-select')?.addEventListener('change', function() {
            alert('Fitur sorting: ' + this.value);
        });
    </script>
</body>
</html>

