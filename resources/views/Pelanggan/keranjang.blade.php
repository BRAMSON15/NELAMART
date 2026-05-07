<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - NELA MART</title>
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
                @if($keranjangs->count() > 0)
                    <span class="badge bg-danger ms-1" style="font-size:10px;">{{ $keranjangs->count() }}</span>
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
            <span style="color:#333;">Keranjang Belanja</span>
        </nav>
    </div>
</div>

<!-- ===== KERANJANG ===== -->
<section style="padding:40px 20px;background:#f5f5f5;min-height:60vh;">
    <div class="container" style="max-width:1100px;">

        @if(session('success'))
            <div class="alert alert-success rounded-3 mb-4">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger rounded-3 mb-4">{{ session('error') }}</div>
        @endif

        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4 class="fw-bold mb-0" style="color:#2a3f54;">
                <i class="fas fa-shopping-cart me-2" style="color:#26b99a;"></i> Keranjang Belanja
            </h4>
            @if($keranjangs->count() > 0)
            <label style="font-size:13px;color:#555;cursor:pointer;display:flex;align-items:center;gap:8px;">
                <input type="checkbox" id="selectAll" style="width:16px;height:16px;accent-color:#26b99a;cursor:pointer;">
                Pilih Semua
            </label>
            @endif
        </div>

        <div class="row g-4">
            <!-- Daftar Item -->
            <div class="col-lg-8">
                @forelse($keranjangs as $item)
                <div class="cart-item-card"
                     data-id="{{ $item->id }}"
                     data-harga="{{ $item->produk->harga }}"
                     data-jumlah="{{ $item->jumlah }}"
                     style="background:white;border-radius:14px;padding:20px;margin-bottom:16px;box-shadow:0 2px 12px rgba(0,0,0,0.07);border:2px solid transparent;transition:border-color 0.2s;">
                    <div class="row align-items-center g-2 cart-item-row">
                        <!-- Checkbox -->
                        <div class="col-auto">
                            <input type="checkbox" class="item-checkbox"
                                   value="{{ $item->id }}"
                                   style="width:18px;height:18px;accent-color:#26b99a;cursor:pointer;">
                        </div>

                        <!-- Gambar -->
                        <div class="col-auto">
                            <div style="width:70px;height:70px;border-radius:10px;overflow:hidden;background:#f0f0f0;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                @if($item->produk->gambar)
                                    <img src="{{ Storage::url($item->produk->gambar) }}"
                                         style="width:100%;height:100%;object-fit:cover;" alt="">
                                @else
                                    <span style="font-size:24px;">📦</span>
                                @endif
                            </div>
                        </div>

                        <!-- Info -->
                        <div class="col cart-item-info" style="min-width: 0;">
                            <h6 class="fw-bold mb-1" style="color:#2a3f54; font-size: 15px;">{{ $item->produk->nama_produk }}</h6>
                            <p class="mb-1" style="font-size:12px;color:#888;">
                                <i class="fas fa-store me-1" style="color:#26b99a;"></i>
                                {{ $item->produk->toko->nama_toko ?? '-' }}
                            </p>
                            <div class="cart-item-price fw-bold" style="color:#26b99a; font-size:14px;">
                                Rp {{ number_format($item->produk->harga, 0, ',', '.') }}
                            </div>
                        </div>

                        <!-- Qty & Subtotal -->
                        <div class="col-auto text-end">
                            <div class="cart-item-qty mb-2">
                                <form method="POST" action="{{ route('keranjang.update', $item->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="d-flex align-items-center justify-content-end" style="border:1.5px solid #e2e8f0;border-radius:6px;overflow:hidden;width:fit-content;margin-left:auto;">
                                        <button type="button" onclick="changeItemQty(this, -1)"
                                            style="width:28px;height:28px;border:none;background:#f8fafc;font-size:14px;font-weight:700;color:#2a3f54;cursor:pointer;">−</button>
                                        <input type="number" name="jumlah" value="{{ $item->jumlah }}" min="1"
                                            style="width:34px;height:28px;border:none;text-align:center;font-weight:700;font-size:13px;color:#2a3f54;"
                                            onchange="this.form.submit()">
                                        <button type="button" onclick="changeItemQty(this, 1)"
                                            style="width:28px;height:28px;border:none;background:#f8fafc;font-size:14px;font-weight:700;color:#2a3f54;cursor:pointer;">+</button>
                                    </div>
                                </form>
                            </div>

                            <form method="POST" action="{{ route('keranjang.hapus', $item->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Hapus item ini?')"
                                    style="background:none;border:none;color:#ef4444;font-size:12px;cursor:pointer;padding:0;">
                                    <i class="fas fa-trash me-1"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div style="background:white;border-radius:14px;padding:60px 20px;text-align:center;box-shadow:0 2px 12px rgba(0,0,0,0.07);">
                    <i class="fas fa-shopping-cart fa-3x mb-3" style="color:#ddd;"></i>
                    <h6 style="color:#666;">Keranjang belanja Anda kosong</h6>
                    <p class="text-muted" style="font-size:14px;">Yuk, temukan produk UMKM pilihan Anda!</p>
                    <a href="{{ route('pelanggan.dashboard') }}" class="btn fw-semibold text-white mt-2"
                       style="background:linear-gradient(135deg,#26b99a,#1abb9c);border:none;border-radius:10px;padding:10px 24px;">
                        <i class="fas fa-search me-2"></i> Jelajahi Produk
                    </a>
                </div>
                @endforelse
            </div>

            <!-- Ringkasan -->
            <div class="col-lg-4">
                <div style="background:white;border-radius:14px;padding:24px;box-shadow:0 2px 12px rgba(0,0,0,0.07);position:sticky;top:80px;">
                    <h5 class="fw-bold mb-4" style="color:#2a3f54;border-bottom:2px solid #f1f5f9;padding-bottom:12px;">
                        <i class="fas fa-receipt me-2" style="color:#26b99a;"></i> Ringkasan Belanja
                    </h5>

                    <div class="d-flex justify-content-between mb-2" style="font-size:14px;color:#555;">
                        <span>Subtotal (<span id="selectedCount">0</span> item dipilih)</span>
                        <span id="selectedTotal">Rp 0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3" style="font-size:14px;color:#555;">
                        <span>Ongkos Kirim</span>
                        <span style="color:#f39c12; font-style: italic;">Dihitung saat Checkout</span>
                    </div>

                    <div style="border-top:2px solid #f1f5f9;padding-top:16px;margin-bottom:20px;">
                        <div class="d-flex justify-content-between">
                            <span class="fw-bold" style="color:#2a3f54;font-size:15px;">Total</span>
                            <span class="fw-bold" style="color:#26b99a;font-size:18px;" id="grandTotal">Rp 0</span>
                        </div>
                    </div>

                    @if($keranjangs->isEmpty())
                        <button class="btn w-100 fw-semibold text-white mb-2" disabled
                            style="background:#adb5bd;border:none;border-radius:10px;padding:12px;">
                            <i class="fas fa-credit-card me-2"></i> Checkout
                        </button>
                    @else
                        <!-- Form checkout dengan selected IDs -->
                        <form method="GET" action="{{ route('checkout.index') }}" id="checkoutForm">
                            <div id="selectedInputs"></div>
                            <button type="submit" id="checkoutBtn" disabled
                                style="width:100%;padding:12px;border:none;border-radius:10px;font-weight:600;font-size:15px;color:white;background:#adb5bd;cursor:not-allowed;transition:background 0.2s;margin-bottom:8px;">
                                <i class="fas fa-credit-card me-2"></i> Checkout
                            </button>
                        </form>
                    @endif

                    <a href="{{ route('pelanggan.dashboard') }}"
                       class="btn w-100 fw-semibold"
                       style="background:#f1f5f9;color:#2a3f54;border:none;border-radius:10px;padding:12px;text-decoration:none;display:block;text-align:center;">
                        <i class="fas fa-arrow-left me-2"></i> Lanjut Belanja
                    </a>
                </div>
            </div>
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

<script src="{{ asset('js/app-navbar.js') }}"></script>
<script src="{{ asset('js/cart-utils.js') }}"></script>
<script>
function formatRupiah(angka) {
    return 'Rp ' + angka.toLocaleString('id-ID');
}

function updateSummary() {
    const checked = document.querySelectorAll('.item-checkbox:checked');
    let total = 0;

    // Reset semua highlight
    document.querySelectorAll('.cart-item-card').forEach(card => {
        card.style.borderColor = 'transparent';
    });

    checked.forEach(cb => {
        const card = cb.closest('.cart-item-card');
        const harga = parseInt(card.dataset.harga);
        const jumlah = parseInt(card.dataset.jumlah);
        total += harga * jumlah;
        card.style.borderColor = '#26b99a';
    });

    document.getElementById('selectedCount').textContent = checked.length;
    document.getElementById('selectedTotal').textContent = formatRupiah(total);
    document.getElementById('grandTotal').textContent = formatRupiah(total);

    // Update hidden inputs untuk form checkout
    const container = document.getElementById('selectedInputs');
    container.innerHTML = '';
    checked.forEach(cb => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'selected_ids[]';
        input.value = cb.value;
        container.appendChild(input);
    });

    // Toggle tombol checkout
    const btn = document.getElementById('checkoutBtn');
    if (btn) {
        if (checked.length > 0) {
            btn.disabled = false;
            btn.style.background = 'linear-gradient(135deg,#26b99a,#1abb9c)';
            btn.style.cursor = 'pointer';
        } else {
            btn.disabled = true;
            btn.style.background = '#adb5bd';
            btn.style.cursor = 'not-allowed';
        }
    }

    // Sync "Pilih Semua"
    const all = document.querySelectorAll('.item-checkbox');
    const selectAll = document.getElementById('selectAll');
    if (selectAll) {
        selectAll.checked = all.length > 0 && checked.length === all.length;
        selectAll.indeterminate = checked.length > 0 && checked.length < all.length;
    }
}

// Pilih semua
const selectAll = document.getElementById('selectAll');
if (selectAll) {
    selectAll.addEventListener('change', function () {
        document.querySelectorAll('.item-checkbox').forEach(cb => {
            cb.checked = this.checked;
        });
        updateSummary();
    });
}

// Tiap checkbox item
document.querySelectorAll('.item-checkbox').forEach(cb => {
    cb.addEventListener('change', updateSummary);
});

// Inisialisasi
updateSummary();
</script>
</body>
</html>

