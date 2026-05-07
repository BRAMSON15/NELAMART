<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan - NELA MART</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/beranda.css') }}?v={{ time() }}" rel="stylesheet">
    <link href="{{ asset('css/pelanggan-theme.css') }}?v={{ time() }}" rel="stylesheet">
    <link href="{{ asset('css/pelanggan.css') }}?v={{ time() }}" rel="stylesheet">
</head>
<body>

<nav class="navbar" id="navbar" style="position:sticky;top:0;z-index:999;">
    <div class="nav-container">
        <a href="/" class="logo"><i class="fas fa-store"></i> NELA MART</a>
        <ul class="nav-menu">
            <li><a href="{{ route('pelanggan.dashboard') }}">Beranda</a></li>
        </ul>
        <div class="nav-buttons">
            <a href="{{ route('keranjang.index') }}" class="btn btn-outline btn-sm">
                <i class="fas fa-shopping-cart"></i> Keranjang
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

<section style="padding:40px 20px;background:#f5f5f5;min-height:70vh;">
    <div class="container" style="max-width:800px;">

        @if(session('success'))
            <div class="alert alert-success rounded-3 mb-4">{{ session('success') }}</div>
        @endif

        <!-- Status Banner -->
        @php
            $statusColor = match($pesanan->status) {
                'pending'     => ['bg' => '#fff7ed', 'border' => '#fed7aa', 'text' => '#c2410c', 'icon' => 'fa-clock'],
                'diproses'    => ['bg' => '#eff6ff', 'border' => '#bfdbfe', 'text' => '#1d4ed8', 'icon' => 'fa-cog'],
                'dikirim'     => ['bg' => '#f0fdf4', 'border' => '#bbf7d0', 'text' => '#15803d', 'icon' => 'fa-truck'],
                'selesai'     => ['bg' => '#f0fdf9', 'border' => '#99f6e4', 'text' => '#0f766e', 'icon' => 'fa-check-circle'],
                'dibatalkan'  => ['bg' => '#fef2f2', 'border' => '#fecaca', 'text' => '#dc2626', 'icon' => 'fa-times-circle'],
                default       => ['bg' => '#f8fafc', 'border' => '#e2e8f0', 'text' => '#64748b', 'icon' => 'fa-circle'],
            };
        @endphp

        <div class="p-4 rounded-3 mb-4 text-center"
            style="background:{{ $statusColor['bg'] }};border:2px solid {{ $statusColor['border'] }};">
            <i class="fas {{ $statusColor['icon'] }} fa-2x mb-2" style="color:{{ $statusColor['text'] }};"></i>
            <h5 class="fw-bold mb-1" style="color:{{ $statusColor['text'] }};">
                {{ ucfirst($pesanan->status) }}
            </h5>
            <p class="mb-0" style="font-size:13px;color:#666;">Kode Pesanan: <strong>{{ $pesanan->kode_pesanan }}</strong></p>
        </div>

        <div class="profile-card mb-4">
            <h5 class="fw-bold mb-3" style="color:#2a3f54;">
                <i class="fas fa-box me-2" style="color:#26b99a;"></i> Detail Produk
            </h5>
            @foreach($pesanan->details as $detail)
            <div class="d-flex align-items-center gap-3 mb-3">
                <div style="width:56px;height:56px;border-radius:10px;overflow:hidden;background:#f0f0f0;flex-shrink:0;display:flex;align-items:center;justify-content:center;">
                    @if($detail->produk->gambar)
                        <img src="{{ Storage::url($detail->produk->gambar) }}"
                            style="width:100%;height:100%;object-fit:cover;" alt="">
                    @else
                        <span style="font-size:22px;">📦</span>
                    @endif
                </div>
                <div class="flex-grow-1">
                    <div class="fw-semibold" style="color:#2a3f54;font-size:14px;">{{ $detail->produk->nama_produk }}</div>
                    <div style="font-size:12px;color:#888;">{{ $detail->jumlah }} x Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</div>
                </div>
                <div class="fw-bold" style="color:#2a3f54;">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</div>
            </div>
            @endforeach
            <div style="border-top:2px solid #f1f5f9;padding-top:12px;margin-top:4px;" class="d-flex justify-content-between">
                <span class="fw-bold" style="color:#2a3f54;">Total</span>
                <span class="fw-bold" style="color:#26b99a;font-size:17px;">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="profile-card h-100">
                    <h6 class="fw-bold mb-3" style="color:#2a3f54;">
                        <i class="fas fa-map-marker-alt me-2" style="color:#26b99a;"></i> Pengiriman
                    </h6>
                    <div style="font-size:13px;color:#555;line-height:1.8;">
                        <div><span style="color:#888;">Penerima:</span> {{ $pesanan->nama_penerima }}</div>
                        <div><span style="color:#888;">Telepon:</span> {{ $pesanan->telepon_penerima }}</div>
                        <div><span style="color:#888;">Alamat:</span> {{ $pesanan->alamat_pengiriman }}</div>
                        @if($pesanan->catatan)
                            <div><span style="color:#888;">Catatan:</span> {{ $pesanan->catatan }}</div>
                        @endif
                    </div>
                </div>
            </div>
                <div class="col-md-6">
                <div class="profile-card h-100">
                    <h6 class="fw-bold mb-3" style="color:#2a3f54;">
                        <i class="fas fa-wallet me-2" style="color:#26b99a;"></i> Pembayaran
                    </h6>
                    <div style="font-size:13px;color:#555;line-height:1.8;">
                        <div><span style="color:#888;">Metode:</span>
                            @if($pesanan->metode_pembayaran === 'cod')
                                <span class="badge" style="background:rgba(38,185,154,0.15);color:#26b99a;">Bayar di Tempat (COD)</span>
                            @elseif($pesanan->metode_pembayaran === 'qris')
                                <span class="badge" style="background:rgba(51,51,51,0.1);color:#333;">
                                    <i class="fas fa-qrcode me-1"></i>QRIS
                                </span>
                            @else
                                <span class="badge" style="background:rgba(42,63,84,0.1);color:#2a3f54;">{{ strtoupper($pesanan->metode_pembayaran) }}</span>
                            @endif
                        </div>
                        <div><span style="color:#888;">Toko:</span> {{ $pesanan->toko->nama_toko ?? '-' }}</div>
                        <div><span style="color:#888;">Tanggal:</span> {{ $pesanan->created_at->format('d M Y, H:i') }}</div>
                        @if($pesanan->dibayar_at)
                            <div><span style="color:#888;">Dibayar:</span>
                                <span style="color:#26b99a;">{{ $pesanan->dibayar_at->format('d M Y, H:i') }}</span>
                            </div>
                        @endif
                    </div>

                    {{-- Kotak Kode Unik — hanya tampil jika metode QRIS --}}
                    @if($pesanan->metode_pembayaran === 'qris' && $pesanan->kode_unik)
                    <div class="mt-3 p-3 rounded-3 text-center"
                        style="background:linear-gradient(135deg,#ecfdf5,#f0fdf4);border:2px solid #86efac;">
                        <div style="font-size:11px;color:#166534;font-weight:600;letter-spacing:.5px;text-transform:uppercase;margin-bottom:4px;">
                            <i class="fas fa-shield-alt me-1"></i> Nominal Yang Harus Ditransfer
                        </div>
                        <div style="font-size:26px;font-weight:800;color:#15803d;letter-spacing:1px;">
                            Rp {{ number_format($pesanan->total_bayar, 0, ',', '.') }}
                        </div>
                        <div style="font-size:12px;color:#166534;margin-top:4px;">
                            (Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                            + kode unik <strong>+{{ $pesanan->kode_unik }}</strong>)
                        </div>
                        <div class="mt-2" style="font-size:11px;color:#166534;background:rgba(22,163,74,0.1);border-radius:8px;padding:6px 10px;">
                            <i class="fas fa-exclamation-triangle me-1" style="color:#eab308;"></i>
                            Harap transfer <strong>tepat</strong> sesuai nominal di atas agar penjual dapat memverifikasi pembayaran kamu.
                        </div>
                    </div>
                    @elseif($pesanan->metode_pembayaran === 'cod')
                    <div class="mt-3 p-3 rounded-3" style="background:#f0fdf4;border:1px solid #bbf7d0;">
                        <div style="font-size:12px;color:#15803d;">
                            <i class="fas fa-info-circle me-1"></i>
                            Pembayaran dilakukan tunai saat barang tiba.
                        </div>
                    </div>
                    @endif

                    {{-- Panel Scan QR + Upload Bukti (muncul setelah kode unik ada) --}}
                    @if($pesanan->metode_pembayaran === 'qris' && $pesanan->kode_unik && $pesanan->toko->gambar_qris)
                    <div class="mt-3 p-3 rounded-3 text-center" style="background:#f8fafc;border:2px solid #e2e8f0;">
                        <div class="fw-semibold mb-2" style="font-size:12px;color:#2a3f54;">
                            <i class="fas fa-qrcode me-1" style="color:#333;"></i>
                            Scan QR Penjual — {{ $pesanan->toko->nama_toko }}
                        </div>
                        <img src="{{ Storage::url($pesanan->toko->gambar_qris) }}"
                             alt="QRIS {{ $pesanan->toko->nama_toko }}"
                             style="max-height:200px;border-radius:10px;border:2px solid #e2e8f0;">
                        <div class="mt-2" style="font-size:12px;color:#555;">
                            Transfer tepat
                            <strong style="color:#15803d;font-size:15px;">Rp {{ number_format($pesanan->total_bayar, 0, ',', '.') }}</strong>
                            ke QR di atas
                        </div>
                    </div>
                    @endif

                    {{-- Form Upload Bukti (jika belum upload) --}}
                    @if($pesanan->metode_pembayaran === 'qris' && !$pesanan->bukti_bayar)
                    <div class="mt-3">
                        <form method="POST"
                              action="{{ route('pelanggan.pesanan.upload-bukti', $pesanan->id) }}"
                              enctype="multipart/form-data">
                            @csrf
                            @if($errors->has('bukti_bayar'))
                                <div class="alert alert-danger py-2" style="font-size:12px;">
                                    {{ $errors->first('bukti_bayar') }}
                                </div>
                            @endif
                            <label class="form-label fw-semibold" style="color:#2a3f54;font-size:13px;">
                                Upload Bukti Transfer <span style="color:#ef4444;">*</span>
                            </label>
                            <input type="file" name="bukti_bayar" id="buktiBayar"
                                   accept="image/*" class="form-control"
                                   style="border-radius:10px;border:2px solid #e2e8f0;">
                            <small class="text-muted">Screenshot konfirmasi transfer, maks. 5MB</small>
                            <div id="previewBukti" class="mt-2" style="display:none;">
                                <img id="imgPreview" src="" alt="Preview"
                                     style="max-height:140px;border-radius:10px;border:2px solid #e2e8f0;">
                            </div>
                            <button type="submit" class="btn w-100 fw-semibold text-white mt-3"
                                style="background:linear-gradient(135deg,#26b99a,#1abb9c);border:none;border-radius:10px;padding:11px;">
                                <i class="fas fa-upload me-2"></i> Upload Bukti Pembayaran
                            </button>
                        </form>
                    </div>
                    @endif

                    @if($pesanan->bukti_bayar)
                    <div class="mt-3">
                        <p style="font-size:12px;color:#888;margin-bottom:6px;">
                            <i class="fas fa-check-circle me-1" style="color:#26b99a;"></i> Bukti sudah diupload:
                        </p>
                        <img src="{{ Storage::url($pesanan->bukti_bayar) }}"
                            alt="Bukti Bayar"
                            style="max-width:100%;border-radius:10px;border:2px solid #e2e8f0;">
                    </div>
                    @endif
                </div>
                </div>
        </div>

        <div class="text-center mt-4">
            @if($pesanan->status === 'dikirim')
                <a href="{{ route('tracking.show', $pesanan->id) }}" class="btn btn-success px-4 py-2 fw-semibold me-2"
                    style="border-radius:10px;text-decoration:none;">
                    <i class="fas fa-map-marked-alt me-2"></i> Lacak Pengiriman
                </a>
            @endif
            <a href="{{ route('pelanggan.dashboard') }}" class="btn px-4 py-2 fw-semibold"
                style="background:#f1f5f9;color:#2a3f54;border-radius:10px;text-decoration:none;">
                <i class="fas fa-home me-2"></i> Kembali ke Beranda
            </a>
        </div>
    </div>
</section>

<footer class="footer">
    <div class="footer-container">
        <div class="footer-brand">
            <h3><i class="fas fa-store"></i> NELA MART</h3>
            <p>Platform terpercaya untuk menemukan dan membeli produk-produk UMKM berkualitas dari seluruh Indonesia.</p>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2026 NELA MART. Dibuat dengan <i class="fas fa-heart" style="color:#e74c3c;"></i> untuk UMKM Indonesia.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/app-navbar.js') }}"></script>
<script>
// Preview bukti transfer sebelum upload
var buktiBayar = document.getElementById('buktiBayar');
if (buktiBayar) {
    buktiBayar.addEventListener('change', function() {
        var file = this.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imgPreview').src = e.target.result;
                document.getElementById('previewBukti').style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });
}
</script>
</body>
</html>

