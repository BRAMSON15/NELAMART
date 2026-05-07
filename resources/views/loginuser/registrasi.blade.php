<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pelaku UMKM - NELA MART</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/registrasi.css') }}?v={{ time() }}" rel="stylesheet">
</head>
<body>
    <div class="container">

        {{-- Header --}}
        <div class="reg-header">
            <div class="reg-icon">
                <i class="fas fa-store"></i>
            </div>
            <h1>Daftar Sebagai Pelaku UMKM</h1>
            <p>Bergabunglah dan mulai jual produk Anda ke seluruh Indonesia</p>
        </div>

        {{-- Error --}}
        @if($errors->any())
            <div class="alert">
                <strong><i class="fas fa-exclamation-circle me-1"></i> Terjadi kesalahan:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('user.register.submit') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-grid">

                {{-- ===== KOLOM KIRI ===== --}}
                <div>
                    {{-- Data Akun --}}
                    <div class="form-section">
                        <h3 class="section-title"><i class="fas fa-key"></i> Data Akun</h3>

                        <div class="form-group">
                            <label>Email <span class="required">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" required placeholder="contoh@email.com">
                        </div>
                        <div class="form-group">
                            <label>Password <span class="required">*</span></label>
                            <input type="password" name="password" required placeholder="Minimal 8 karakter">
                        </div>
                        <div class="form-group">
                            <label>Konfirmasi Password <span class="required">*</span></label>
                            <input type="password" name="password_confirmation" required placeholder="Ulangi password">
                        </div>
                    </div>

                    {{-- Data Pelaku UMKM --}}
                    <div class="form-section">
                        <h3 class="section-title"><i class="fas fa-user"></i> Data Pelaku UMKM</h3>

                        <div class="form-group">
                            <label>Nama Lengkap <span class="required">*</span></label>
                            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required placeholder="Masukkan nama lengkap Anda">
                        </div>
                        <div class="form-group">
                            <label>Nomor Telepon <span class="required">*</span></label>
                            <input type="tel" name="telepon" value="{{ old('telepon') }}" required placeholder="08xxxxxxxxxx">
                        </div>
                    </div>

                    {{-- Data Toko --}}
                    <div class="form-section">
                        <h3 class="section-title"><i class="fas fa-store"></i> Data Toko</h3>

                        <div class="form-group">
                            <label>Nama Toko <span class="required">*</span></label>
                            <input type="text" name="nama_toko" value="{{ old('nama_toko') }}" required placeholder="Contoh: Toko Kerajinan Nusantara">
                        </div>
                        <div class="form-group">
                            <label>Alamat Toko <span class="required">*</span></label>
                            <textarea name="alamat_toko" required placeholder="Masukkan alamat lengkap toko Anda">{{ old('alamat_toko') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Deskripsi Toko <span class="help-text">(opsional)</span></label>
                            <textarea name="deskripsi_toko" placeholder="Ceritakan tentang toko Anda">{{ old('deskripsi_toko') }}</textarea>
                        </div>
                    </div>

                    {{-- Informasi Pembayaran --}}
                    <div class="form-section">
                        <h3 class="section-title"><i class="fas fa-wallet"></i> Informasi Pembayaran</h3>
                        <p class="help-text" style="margin-bottom:18px;">Digunakan untuk menerima pembayaran dari pembeli.</p>

                        {{-- Tab Pilih Tipe --}}
                        <div class="form-group">
                            <label>Metode Pembayaran <span class="required">*</span></label>
                            <div style="display:flex;gap:10px;margin-top:6px;">
                                <label class="payment-tab {{ old('tipe_pembayaran','bank') == 'bank' ? 'active' : '' }}" id="tab-bank" onclick="switchPayment('bank')" style="flex:1;border:2px solid {{ old('tipe_pembayaran','bank') == 'bank' ? '#26b99a' : '#e2e8f0' }};border-radius:10px;padding:12px;cursor:pointer;text-align:center;transition:all .2s;">
                                    <i class="fas fa-university" style="font-size:20px;color:#26b99a;display:block;margin-bottom:4px;"></i>
                                    <span style="font-size:13px;font-weight:600;">Transfer Bank</span>
                                </label>
                                <label class="payment-tab {{ old('tipe_pembayaran') == 'ewallet' ? 'active' : '' }}" id="tab-ewallet" onclick="switchPayment('ewallet')" style="flex:1;border:2px solid {{ old('tipe_pembayaran') == 'ewallet' ? '#26b99a' : '#e2e8f0' }};border-radius:10px;padding:12px;cursor:pointer;text-align:center;transition:all .2s;">
                                    <i class="fas fa-mobile-alt" style="font-size:20px;color:#26b99a;display:block;margin-bottom:4px;"></i>
                                    <span style="font-size:13px;font-weight:600;">E-Wallet</span>
                                </label>
                                <label class="payment-tab {{ old('tipe_pembayaran') == 'keduanya' ? 'active' : '' }}" id="tab-keduanya" onclick="switchPayment('keduanya')" style="flex:1;border:2px solid {{ old('tipe_pembayaran') == 'keduanya' ? '#26b99a' : '#e2e8f0' }};border-radius:10px;padding:12px;cursor:pointer;text-align:center;transition:all .2s;">
                                    <i class="fas fa-layer-group" style="font-size:20px;color:#26b99a;display:block;margin-bottom:4px;"></i>
                                    <span style="font-size:13px;font-weight:600;">Keduanya</span>
                                </label>
                            </div>
                            <input type="hidden" name="tipe_pembayaran" id="tipe_pembayaran" value="{{ old('tipe_pembayaran', 'bank') }}">
                        </div>

                        {{-- Form Bank --}}
                        <div id="form-bank" style="{{ old('tipe_pembayaran','bank') == 'ewallet' ? 'display:none' : '' }}">
                            <div class="form-group">
                                <label>Nama Bank <span class="required">*</span></label>
                                <select name="nama_bank" id="nama_bank">
                                    <option value="">-- Pilih Bank --</option>
                                    @foreach(['BCA','BRI','BNI','Mandiri','BSI','CIMB Niaga','Danamon','Permata','BTN','Maybank'] as $bank)
                                        <option value="{{ $bank }}" {{ old('nama_bank') == $bank ? 'selected' : '' }}>{{ $bank }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Nomor Rekening <span class="required">*</span></label>
                                <input type="text" name="nomor_rekening" id="nomor_rekening" value="{{ old('nomor_rekening') }}" placeholder="Contoh: 1234567890">
                            </div>
                            <div class="form-group">
                                <label>Nama Pemilik Rekening <span class="required">*</span></label>
                                <input type="text" name="nama_pemilik_rekening" id="nama_pemilik_rekening" value="{{ old('nama_pemilik_rekening') }}" placeholder="Sesuai buku tabungan">
                            </div>
                        </div>

                        {{-- Form E-Wallet --}}
                        <div id="form-ewallet" style="{{ old('tipe_pembayaran','bank') == 'bank' ? 'display:none' : '' }}">
                            <div class="form-group">
                                <label>Nama E-Wallet / Dompet Digital <span class="required">*</span></label>
                                <select name="nama_ewallet" id="nama_ewallet">
                                    <option value="">-- Pilih E-Wallet --</option>
                                    @foreach(['DANA','GoPay','OVO','ShopeePay','LinkAja','QRIS'] as $ew)
                                        <option value="{{ $ew }}" {{ old('nama_ewallet') == $ew ? 'selected' : '' }}>{{ $ew }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Nama Pemilik E-Wallet <span class="required">*</span></label>
                                <input type="text" name="nama_pemilik_ewallet" id="nama_pemilik_ewallet"
                                       value="{{ old('nama_pemilik_ewallet') }}"
                                       placeholder="Nama sesuai akun e-wallet">
                            </div>
                            <div class="form-group">
                                <label>Upload Gambar QRIS <span class="required">*</span></label>
                                <input type="file" name="gambar_qris" id="gambar_qris" accept="image/*"
                                       onchange="previewQris(this)">
                                <span class="help-text">Upload foto/screenshot QRIS dari aplikasi dompet digital Anda. Format JPG/PNG, maks. 2MB.</span>
                                <div id="previewQrisBox" style="display:none;margin-top:10px;text-align:center;">
                                    <img id="previewQrisImg" src="" alt="Preview QRIS"
                                         style="max-height:200px;border-radius:10px;border:2px solid #e2e8f0;">
                                    <div style="font-size:12px;color:#888;margin-top:4px;">Preview QRIS Anda</div>
                                </div>
                                <div style="margin-top:10px;padding:10px 14px;background:#f0fdf9;border:1px solid #bbf7e8;border-radius:8px;font-size:12px;color:#555;">
                                    <i class="fas fa-info-circle" style="color:#26b99a;margin-right:4px;"></i>
                                    Cara mendapatkan gambar QRIS: Buka aplikasi DANA/GoPay/OVO → Terima Uang → Screenshot QR yang muncul.
                                    Pelanggan akan scan QR ini untuk membayar langsung ke akun Anda.
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                    function switchPayment(tipe) {
                        document.getElementById('tipe_pembayaran').value = tipe;

                        ['bank','ewallet','keduanya'].forEach(function(t) {
                            document.getElementById('tab-' + t).style.borderColor = '#e2e8f0';
                        });
                        document.getElementById('tab-' + tipe).style.borderColor = '#26b99a';

                        var showBank   = (tipe === 'bank'    || tipe === 'keduanya');
                        var showEwalet = (tipe === 'ewallet' || tipe === 'keduanya');

                        document.getElementById('form-bank').style.display    = showBank   ? '' : 'none';
                        document.getElementById('form-ewallet').style.display = showEwalet ? '' : 'none';

                        ['nama_bank','nomor_rekening','nama_pemilik_rekening'].forEach(function(id) {
                            var el = document.getElementById(id);
                            if (el) el.required = showBank;
                        });
                        // Ewallet: wajib nama_ewallet, nama_pemilik_ewallet, gambar_qris
                        ['nama_ewallet','nama_pemilik_ewallet','gambar_qris'].forEach(function(id) {
                            var el = document.getElementById(id);
                            if (el) el.required = showEwalet;
                        });
                    }

                    function previewQris(input) {
                        var file = input.files[0];
                        if (file) {
                            var reader = new FileReader();
                            reader.onload = function(e) {
                                document.getElementById('previewQrisImg').src = e.target.result;
                                document.getElementById('previewQrisBox').style.display = 'block';
                            };
                            reader.readAsDataURL(file);
                        }
                    }

                    switchPayment(document.getElementById('tipe_pembayaran').value || 'bank');
                    </script>

                    {{-- Jasa Pengiriman --}}
                    <div class="form-section">
                        <h3 class="section-title"><i class="fas fa-shipping-fast"></i> Jasa Pengiriman</h3>
                        <p class="help-text" style="margin-bottom:18px;">Pilih apakah menggunakan jasa pengiriman RajaOngkir atau tidak.</p>

                        <div class="form-group">
                            <label style="display:flex;align-items:center;gap:10px;cursor:pointer;padding:14px;border:2px solid #e2e8f0;border-radius:10px;background:#f8fafc;">
                                <input type="checkbox" name="gunakan_rajaongkir" id="gunakanRajaongkir" value="1" 
                                    {{ old('gunakan_rajaongkir') ? 'checked' : '' }}
                                    style="width:20px;height:20px;accent-color:#26b99a;">
                                <div>
                                    <strong style="color:#2a3f54;font-size:14px;">Gunakan RajaOngkir</strong>
                                    <div class="help-text" style="margin:0;">Pelanggan dapat memilih jasa pengiriman (JNE, TIKI, POS) dengan ongkir otomatis</div>
                                </div>
                            </label>
                        </div>

                        <div id="rajaongkirFields" style="display:{{ old('gunakan_rajaongkir') ? 'block' : 'none' }};">
                            <div style="padding:12px;background:#e0f2fe;border:1px solid #bae6fd;border-radius:8px;margin-bottom:14px;font-size:13px;color:#0c4a6e;">
                                <i class="fas fa-info-circle"></i> Pilih kota asal pengiriman untuk menghitung ongkos kirim
                            </div>

                            <div class="form-group">
                                <label>Provinsi Asal</label>
                                <select id="provinsiAsal" name="provinsi_asal">
                                    <option value="">-- Pilih Provinsi --</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Kota/Kabupaten Asal <span class="required">*</span></label>
                                <select id="kotaAsal" name="kota_asal_id">
                                    <option value="">-- Pilih Kota --</option>
                                </select>
                                <input type="hidden" id="kotaAsalNama" name="kota_asal_nama" value="{{ old('kota_asal_nama') }}">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ===== KOLOM KANAN ===== --}}
                <div>
                    {{-- Data Produk --}}
                    <div class="form-section">
                        <h3 class="section-title"><i class="fas fa-box"></i> Data Produk Utama</h3>
                        <p class="help-text" style="margin-bottom:18px;">Produk pertama Anda — bisa ditambah lagi setelah registrasi.</p>

                        <div class="form-group">
                            <label>Nama Produk <span class="required">*</span></label>
                            <input type="text" name="nama_produk" value="{{ old('nama_produk') }}" required placeholder="Contoh: Tas Rajut Handmade">
                        </div>
                        <div class="form-group">
                            <label>Kategori Produk <span class="required">*</span></label>
                            <select name="kategori_produk" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach(['Makanan & Minuman','Fashion & Pakaian','Kerajinan Tangan','Aksesoris','Elektronik','Kesehatan & Kecantikan','Rumah Tangga','Lainnya'] as $kat)
                                    <option value="{{ $kat }}" {{ old('kategori_produk') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Harga Produk (Rp) <span class="required">*</span></label>
                            <input type="number" name="harga_produk" value="{{ old('harga_produk') }}" required min="0" step="1000" placeholder="Contoh: 50000">
                        </div>
                        <div class="form-group">
                            <label>Deskripsi Produk <span class="required">*</span></label>
                            <textarea name="deskripsi_produk" required placeholder="Jelaskan detail produk, bahan, ukuran, dll.">{{ old('deskripsi_produk') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Gambar Produk <span class="required">*</span></label>
                            <input type="file" name="gambar_produk" accept="image/*" required>
                            <span class="help-text">Format: JPG, PNG (Max: 2MB)</span>
                        </div>
                        <div class="form-group">
                            <label>Stok Produk <span class="required">*</span></label>
                            <input type="number" name="stok_produk" value="{{ old('stok_produk') }}" required min="0" placeholder="Jumlah stok tersedia">
                        </div>
                    </div>
                </div>

            </div>{{-- end form-grid --}}

            {{-- Submit --}}
            <div class="section-full">
                <button type="submit" class="btn-submit">
                    <i class="fas fa-store me-2"></i> Daftar Sekarang
                </button>
                <div class="login-link">
                    Sudah punya akun? <a href="{{ route('user.login') }}">Login di sini</a>
                </div>
                <div class="back-link">
                    <a href="/"><i class="fas fa-arrow-left"></i> Kembali ke Beranda</a>
                </div>
            </div>

        </form>
    </div>

    <script>
    // Toggle RajaOngkir fields
    document.getElementById('gunakanRajaongkir').addEventListener('change', function() {
        const fields = document.getElementById('rajaongkirFields');
        const kotaAsal = document.getElementById('kotaAsal');
        
        if (this.checked) {
            fields.style.display = 'block';
            kotaAsal.required = true;
            loadProvinsi();
        } else {
            fields.style.display = 'none';
            kotaAsal.required = false;
            kotaAsal.value = '';
            document.getElementById('provinsiAsal').value = '';
            document.getElementById('kotaAsalNama').value = '';
        }
    });

    // Load Provinsi
    function loadProvinsi() {
        fetch('/rajaongkir/provinces')
            .then(response => response.json())
            .then(data => {
                const select = document.getElementById('provinsiAsal');
                select.innerHTML = '<option value="">-- Pilih Provinsi --</option>';
                
                if (data.rajaongkir && data.rajaongkir.results) {
                    data.rajaongkir.results.forEach(prov => {
                        select.innerHTML += `<option value="${prov.province_id}">${prov.province}</option>`;
                    });
                }
            })
            .catch(error => {
                console.error('Error loading provinces:', error);
                alert('Gagal memuat data provinsi. Pastikan RajaOngkir API key sudah dikonfigurasi.');
            });
    }

    // Load Kota when Provinsi selected
    document.getElementById('provinsiAsal').addEventListener('change', function() {
        const provinsiId = this.value;
        const kotaSelect = document.getElementById('kotaAsal');
        
        if (!provinsiId) {
            kotaSelect.innerHTML = '<option value="">-- Pilih Kota --</option>';
            return;
        }

        kotaSelect.innerHTML = '<option value="">Loading...</option>';
        
        fetch(`/rajaongkir/cities/${provinsiId}`)
            .then(response => response.json())
            .then(data => {
                kotaSelect.innerHTML = '<option value="">-- Pilih Kota --</option>';
                
                if (data.rajaongkir && data.rajaongkir.results) {
                    data.rajaongkir.results.forEach(city => {
                        const cityName = `${city.type} ${city.city_name}`;
                        kotaSelect.innerHTML += `<option value="${city.city_id}" data-nama="${cityName}">${cityName}</option>`;
                    });
                }
            })
            .catch(error => {
                console.error('Error loading cities:', error);
                kotaSelect.innerHTML = '<option value="">-- Error loading cities --</option>';
            });
    });

    // Save kota nama when kota selected
    document.getElementById('kotaAsal').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const kotaNama = selectedOption.getAttribute('data-nama') || selectedOption.text;
        document.getElementById('kotaAsalNama').value = kotaNama;
    });

    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const gunakanRajaongkir = document.getElementById('gunakanRajaongkir').checked;
        const kotaAsal = document.getElementById('kotaAsal').value;
        
        if (gunakanRajaongkir && !kotaAsal) {
            e.preventDefault();
            alert('Silakan pilih kota asal pengiriman!');
            document.getElementById('kotaAsal').focus();
        }
    });

    // Load provinsi if checkbox already checked (from old input)
    if (document.getElementById('gunakanRajaongkir').checked) {
        loadProvinsi();
    }
    </script>
</body>
</html>

