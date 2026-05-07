<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - NELA MART</title>
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
            <a href="{{ route('keranjang.index') }}" style="color:#26b99a;text-decoration:none;">Keranjang</a>
            <span class="mx-2">/</span>
            <span style="color:#333;">Checkout</span>
        </nav>
    </div>
</div>

<!-- ===== CHECKOUT ===== -->
<section style="padding:40px 20px;background:#f5f5f5;min-height:60vh;">
    <div class="container" style="max-width:1100px;">

        @if($errors->any())
            <div class="alert alert-danger rounded-3 mb-4">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif

        <h4 class="fw-bold mb-4" style="color:#2a3f54;">
            <i class="fas fa-credit-card me-2" style="color:#26b99a;"></i> Checkout
        </h4>

        <form method="POST" action="{{ route('checkout.proses') }}" enctype="multipart/form-data">
            @csrf
            @foreach($selectedIds ?? [] as $sid)
                <input type="hidden" name="selected_ids[]" value="{{ $sid }}">
            @endforeach
            <div class="row g-4">

                <!-- Kiri: Form -->
                <div class="col-lg-7">

                    <!-- Informasi Penerima -->
                    <div class="profile-card mb-4">
                        <h5 class="fw-bold mb-3" style="color:#2a3f54;">
                            <i class="fas fa-user me-2" style="color:#26b99a;"></i> Informasi Penerima
                        </h5>
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="color:#2a3f54;font-size:13px;">Nama Penerima</label>
                            <input type="text" name="nama_penerima" class="form-control"
                                value="{{ old('nama_penerima', $user->name) }}" required
                                style="border-radius:10px;border:2px solid #e2e8f0;">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="color:#2a3f54;font-size:13px;">Nomor Telepon</label>
                            <input type="text" name="telepon_penerima" class="form-control"
                                value="{{ old('telepon_penerima') }}" required placeholder="08xxxxxxxxxx"
                                style="border-radius:10px;border:2px solid #e2e8f0;">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="color:#2a3f54;font-size:13px;">Provinsi</label>
                            <select name="provinsi" id="provinsi" class="form-select" required style="border-radius:10px;border:2px solid #e2e8f0;">
                                <option value="">Loading Provinsi...</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="color:#2a3f54;font-size:13px;">Kota/Kabupaten</label>
                            <select name="kota" id="kota" class="form-select" {{ $gunakanRajaongkir ? 'required' : '' }} style="border-radius:10px;border:2px solid #e2e8f0;" {{ $gunakanRajaongkir ? 'disabled' : '' }}>
                                <option value="">Pilih Kota/Kabupaten</option>
                            </select>
                        </div>

                        @if($gunakanRajaongkir)
                        <!-- Hanya tampilkan jika toko menggunakan RajaOngkir -->
                        <div class="alert alert-info mb-3">
                            <i class="fas fa-info-circle"></i> <strong>{{ $tokoRajaongkir->nama_toko }}</strong> menggunakan jasa pengiriman RajaOngkir
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="color:#2a3f54;font-size:13px;">Pilih Ekspedisi</label>
                            <select name="kurir" id="kurir" class="form-select" required style="border-radius:10px;border:2px solid #e2e8f0;" disabled>
                                <option value="">Pilih Kurir</option>
                                <option value="jne">JNE</option>
                                <option value="pos">POS Indonesia</option>
                                <option value="tiki">TIKI</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="color:#2a3f54;font-size:13px;">Layanan Ongkos Kirim</label>
                            <select name="layanan_ongkir" id="layanan_ongkir" class="form-select" required style="border-radius:10px;border:2px solid #e2e8f0;" disabled>
                                <option value="">Pilih Layanan</option>
                            </select>
                            <input type="hidden" name="ongkos_kirim" id="ongkos_kirim_input" value="0">
                        </div>
                        @else
                        <!-- Jika tidak menggunakan RajaOngkir, ongkir = 0 -->
                        <div class="alert alert-success mb-3">
                            <i class="fas fa-check-circle"></i> Toko ini tidak menggunakan jasa pengiriman RajaOngkir. <strong>Ongkir ditanggung penjual atau COD.</strong>
                        </div>
                        <input type="hidden" name="ongkos_kirim" value="0">
                        @endif

                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="color:#2a3f54;font-size:13px;">Detail Alamat Pengiriman</label>
                            <textarea name="alamat_pengiriman" class="form-control" rows="3" required
                                placeholder="Jalan, RT/RW, Kecamatan, dsb."
                                style="border-radius:10px;border:2px solid #e2e8f0;resize:vertical;">{{ old('alamat_pengiriman', $user->alamat) }}</textarea>
                        </div>
                        <div>
                            <label class="form-label fw-semibold" style="color:#2a3f54;font-size:13px;">Catatan (opsional)</label>
                            <input type="text" name="catatan" class="form-control"
                                value="{{ old('catatan') }}" placeholder="Contoh: Titip di depan pintu"
                                style="border-radius:10px;border:2px solid #e2e8f0;">
                        </div>
                    </div>

                    <!-- Metode Pembayaran -->
                    <div class="profile-card">
                        <h5 class="fw-bold mb-3" style="color:#2a3f54;">
                            <i class="fas fa-wallet me-2" style="color:#26b99a;"></i> Metode Pembayaran
                        </h5>

                        @php
                            $tokosList = $keranjangs->map(fn($i) => $i->produk->toko)->unique('id')->values();
                            $adaQris   = $tokosList->contains(fn($t) => in_array($t->tipe_pembayaran, ['qris','keduanya']) && $t->gambar_qris);
                            $adaBank   = $tokosList->contains(fn($t) => in_array($t->tipe_pembayaran, ['bank','keduanya']) && $t->nomor_rekening);
                        @endphp

                        {{-- COD --}}
                        <label class="d-flex align-items-center gap-3 p-3 mb-2 rounded-3"
                            style="border:2px solid #e2e8f0;cursor:pointer;transition:.2s;" id="label-cod">
                            <input type="radio" name="metode_pembayaran" value="cod"
                                {{ old('metode_pembayaran','cod') === 'cod' ? 'checked' : '' }}
                                onchange="toggleMetode(this.value)"
                                style="width:18px;height:18px;accent-color:#26b99a;">
                            <div class="d-flex align-items-center gap-3">
                                <div style="width:44px;height:44px;background:rgba(38,185,154,0.1);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                                    <i class="fas fa-truck" style="color:#26b99a;font-size:18px;"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold" style="color:#2a3f54;font-size:14px;">Bayar di Tempat (COD)</div>
                                    <div style="font-size:12px;color:#888;">Bayar tunai saat barang tiba</div>
                                </div>
                            </div>
                        </label>

                        {{-- QRIS Statis --}}
                        @if($adaQris)
                        <label class="d-flex align-items-center gap-3 p-3 mb-2 rounded-3"
                            style="border:2px solid #e2e8f0;cursor:pointer;transition:.2s;" id="label-qris">
                            <input type="radio" name="metode_pembayaran" value="qris"
                                {{ old('metode_pembayaran') === 'qris' ? 'checked' : '' }}
                                onchange="toggleMetode(this.value)"
                                style="width:18px;height:18px;accent-color:#26b99a;">
                            <div class="d-flex align-items-center gap-3">
                                <div style="width:44px;height:44px;background:#f5f5f5;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                                    <i class="fas fa-qrcode" style="color:#333;font-size:20px;"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold" style="color:#2a3f54;font-size:14px;">QRIS</div>
                                    <div style="font-size:12px;color:#888;">Scan QR penjual — GoPay, OVO, DANA, ShopeePay & semua dompet digital</div>
                                </div>
                            </div>
                        </label>
                        @endif

                        {{-- Info QRIS + Panduan 2 Langkah --}}
                        <div id="infoQris" style="display:{{ old('metode_pembayaran') === 'qris' ? 'block' : 'none' }};" class="mt-3">

                            {{-- Panduan Langkah --}}
                            <div class="p-3 rounded-3 mb-3" style="background:#f8fafc;border:2px solid #e2e8f0;">
                                <div class="fw-semibold mb-2" style="font-size:13px;color:#2a3f54;">
                                    <i class="fas fa-list-ol me-1" style="color:#26b99a;"></i> Cara Pembayaran QRIS
                                </div>
                                <div class="d-flex flex-column gap-2">
                                    <div class="d-flex align-items-start gap-2">
                                        <div style="width:22px;height:22px;background:#26b99a;color:white;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;flex-shrink:0;">1</div>
                                        <div style="font-size:12px;color:#555;">Klik <strong>"Buat Pesanan"</strong> — sistem akan generate <strong>nominal unik</strong> untuk transaksimu</div>
                                    </div>
                                    <div class="d-flex align-items-start gap-2">
                                        <div style="width:22px;height:22px;background:#26b99a;color:white;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;flex-shrink:0;">2</div>
                                        <div style="font-size:12px;color:#555;">Scan QR penjual & transfer sesuai <strong>nominal tepat</strong> yang tertera di halaman berikutnya</div>
                                    </div>
                                    <div class="d-flex align-items-start gap-2">
                                        <div style="width:22px;height:22px;background:#26b99a;color:white;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;flex-shrink:0;">3</div>
                                        <div style="font-size:12px;color:#555;">Upload bukti screenshot transfer di halaman detail pesanan</div>
                                    </div>
                                </div>
                            </div>

                            {{-- Preview QR per toko (hanya pratinjau) --}}
                            @foreach($tokosList->filter(fn($t) => in_array($t->tipe_pembayaran, ['qris','keduanya']) && $t->gambar_qris) as $toko)
                            <div class="p-3 rounded-3 mb-2 text-center" style="background:#f8fafc;border:1px solid #e2e8f0;">
                                <div class="fw-semibold mb-1" style="font-size:12px;color:#888;">
                                    <i class="fas fa-store me-1" style="color:#26b99a;"></i> {{ $toko->nama_toko }} — pratinjau QR
                                </div>
                                <img src="{{ Storage::url($toko->gambar_qris) }}"
                                     alt="QRIS {{ $toko->nama_toko }}"
                                     style="max-height:160px;border-radius:10px;border:2px solid #e2e8f0;opacity:.85;">
                                <div style="font-size:11px;color:#aaa;margin-top:4px;">
                                    Nominal transfer ditampilkan setelah pesanan dibuat
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Kanan: Ringkasan -->
                <div class="col-lg-5">
                    <div style="background:white;border-radius:14px;padding:24px;box-shadow:0 2px 12px rgba(0,0,0,0.07);position:sticky;top:80px;">
                        <h5 class="fw-bold mb-3" style="color:#2a3f54;border-bottom:2px solid #f1f5f9;padding-bottom:12px;">
                            <i class="fas fa-receipt me-2" style="color:#26b99a;"></i> Ringkasan Pesanan
                        </h5>

                        @foreach($keranjangs as $item)
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div style="width:48px;height:48px;border-radius:8px;overflow:hidden;background:#f0f0f0;flex-shrink:0;display:flex;align-items:center;justify-content:center;">
                                @if($item->produk->gambar)
                                    <img src="{{ Storage::url($item->produk->gambar) }}"
                                        style="width:100%;height:100%;object-fit:cover;" alt="">
                                @else
                                    <span style="font-size:20px;">📦</span>
                                @endif
                            </div>
                            <div class="flex-grow-1" style="min-width:0;">
                                <div class="fw-semibold text-truncate" style="color:#2a3f54;font-size:13px;">{{ $item->produk->nama_produk }}</div>
                                <div style="font-size:12px;color:#888;">{{ $item->jumlah }} x Rp {{ number_format($item->produk->harga, 0, ',', '.') }}</div>
                            </div>
                            <div class="fw-bold" style="color:#2a3f54;font-size:13px;white-space:nowrap;">
                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                            </div>
                        </div>
                        @endforeach

                        <div style="border-top:2px solid #f1f5f9;padding-top:14px;margin-top:4px;">
                            <div class="d-flex justify-content-between mb-2" style="font-size:13px;color:#555;">
                                <span>Subtotal</span>
                                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3" style="font-size:13px;color:#555;">
                                <span>Ongkos Kirim</span>
                                <span style="color:#2a3f54;" id="display_ongkir">Rp 0</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="fw-bold" style="color:#2a3f54;">Total</span>
                                <span class="fw-bold" style="color:#26b99a;font-size:18px;" id="display_grand_total" data-subtotal="{{ $total }}">
                                    Rp {{ number_format($total, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <button type="submit" class="btn w-100 fw-semibold text-white mt-4"
                            style="background:linear-gradient(135deg,#26b99a,#1abb9c);border:none;border-radius:10px;padding:13px;font-size:15px;">
                            <i class="fas fa-check-circle me-2"></i> Buat Pesanan
                        </button>
                        <a href="{{ route('keranjang.index') }}"
                            class="btn w-100 fw-semibold mt-2"
                            style="background:#f1f5f9;color:#2a3f54;border:none;border-radius:10px;padding:12px;text-decoration:none;display:block;text-align:center;">
                            <i class="fas fa-arrow-left me-2"></i> Kembali ke Keranjang
                        </a>
                    </div>
                </div>

            </div>
        </form>
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
<script>
const gunakanRajaongkir = {{ $gunakanRajaongkir ? 'true' : 'false' }};
const kotaAsalId = '{{ $tokoRajaongkir->kota_asal_id ?? '' }}';

function toggleMetode(val) {
    document.getElementById('infoQris').style.display = (val === 'qris') ? 'block' : 'none';
    document.querySelectorAll('[id^="label-"]').forEach(function(el) { el.style.borderColor = '#e2e8f0'; });
    var active = document.getElementById('label-' + val);
    if (active) active.style.borderColor = '#26b99a';
}
var checked = document.querySelector('input[name="metode_pembayaran"]:checked');
if (checked) toggleMetode(checked.value);

// RAJAONGKIR LOGIC - Hanya jalan jika toko menggunakan RajaOngkir
if (gunakanRajaongkir) {
    // 1. Fetch Provinces on load
    document.addEventListener('DOMContentLoaded', function() {
        fetch('{{ route("rajaongkir.provinces") }}')
            .then(response => response.json())
            .then(data => {
                const provinsiSelect = document.getElementById('provinsi');
                provinsiSelect.innerHTML = '<option value="">Pilih Provinsi</option>';
                if(data.rajaongkir && data.rajaongkir.results) {
                    data.rajaongkir.results.forEach(prov => {
                        let option = new Option(prov.province, prov.province_id);
                        provinsiSelect.add(option);
                    });
                }
            });
    });

    // 2. Fetch Cities when Province changes
    document.getElementById('provinsi').addEventListener('change', function() {
        let provId = this.value;
        const kotaSelect = document.getElementById('kota');
        const kurirSelect = document.getElementById('kurir');
        
        kotaSelect.innerHTML = '<option value="">Loading Kota...</option>';
        kotaSelect.disabled = true;
        kurirSelect.disabled = true;
        kurirSelect.value = "";
        document.getElementById('layanan_ongkir').innerHTML = '<option value="">Pilih Layanan</option>';
        resetOngkir();

        if(provId) {
            fetch('{{ url("rajaongkir/cities") }}/' + provId)
                .then(response => response.json())
                .then(data => {
                    kotaSelect.innerHTML = '<option value="">Pilih Kota/Kabupaten</option>';
                    if (data.rajaongkir && data.rajaongkir.results) {
                        data.rajaongkir.results.forEach(kota => {
                            let text = kota.type + ' ' + kota.city_name;
                            let option = new Option(text, kota.city_id);
                            kotaSelect.add(option);
                        });
                        kotaSelect.disabled = false;
                    }
                });
        }
    });

    // 3. Enable Courier select when City changes
    document.getElementById('kota').addEventListener('change', function() {
        if(this.value) {
            document.getElementById('kurir').disabled = false;
        } else {
            document.getElementById('kurir').disabled = true;
        }
        document.getElementById('kurir').value = "";
        document.getElementById('layanan_ongkir').innerHTML = '<option value="">Pilih Layanan</option>';
        resetOngkir();
    });

    // 4. Check Cost when Courier is chosen
    document.getElementById('kurir').addEventListener('change', function() {
        let kurir = this.value;
        let kotaDest = document.getElementById('kota').value;
        const layananSelect = document.getElementById('layanan_ongkir');
        
        layananSelect.innerHTML = '<option value="">Menghitung Ongkir...</option>';
        layananSelect.disabled = true;
        resetOngkir();

        if(kurir && kotaDest) {
            let formData = new FormData();
            formData.append('origin', kotaAsalId); // Dari kota asal toko
            formData.append('destination', kotaDest);
            formData.append('weight', 1000); 
            formData.append('courier', kurir);

            fetch('{{ route("rajaongkir.cost") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                layananSelect.innerHTML = '<option value="">Pilih Layanan</option>';
                if(data.rajaongkir && data.rajaongkir.results && data.rajaongkir.results[0].costs.length > 0) {
                    data.rajaongkir.results[0].costs.forEach(cost => {
                        let price = cost.cost[0].value;
                        let etd = cost.cost[0].etd;
                        let text = cost.service + ' - Rp ' + price.toLocaleString("id-ID") + ' (' + etd + ' hari)';
                        let option = new Option(text, price);
                        layananSelect.add(option);
                    });
                    layananSelect.disabled = false;
                } else {
                    layananSelect.innerHTML = '<option value="">Layanan tidak tersedia</option>';
                }
            });
        }
    });

    // 5. Update Ongkir value when Service is picked
    document.getElementById('layanan_ongkir').addEventListener('change', function() {
        let ongkir = parseInt(this.value) || 0;
        document.getElementById('ongkos_kirim_input').value = ongkir;
        document.getElementById('display_ongkir').innerText = 'Rp ' + ongkir.toLocaleString("id-ID");
        
        let subtotalText = document.getElementById('display_grand_total').getAttribute('data-subtotal');
        let subtotal = parseInt(subtotalText) || 0;
        let grandTotal = subtotal + ongkir;
        document.getElementById('display_grand_total').innerText = 'Rp ' + grandTotal.toLocaleString("id-ID");
    });

    function resetOngkir() {
        document.getElementById('ongkos_kirim_input').value = 0;
        document.getElementById('display_ongkir').innerText = 'Rp 0';
        let subtotal = parseInt(document.getElementById('display_grand_total').getAttribute('data-subtotal')) || 0;
        document.getElementById('display_grand_total').innerText = 'Rp ' + subtotal.toLocaleString("id-ID");
    }
}
</script>
</body>
</html>

