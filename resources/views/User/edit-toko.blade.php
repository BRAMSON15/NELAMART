<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Edit Toko - NELA MART</title>
    <link href="{{asset('mentahan1/css/styles.css')}}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        .payment-tab { cursor: pointer; transition: border-color .2s, background .2s; }
        .payment-tab:hover { background: #f0fdf9; }
    </style>
</head>
<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="card shadow-lg border-0 rounded-lg mt-5 mb-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">
                                        <i class="fas fa-edit"></i> Edit Data Toko
                                    </h3>
                                </div>
                                <div class="card-body">

                                    @if($errors->any())
                                        <div class="alert alert-danger">
                                            <ul class="mb-0">
                                                @foreach($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <form method="POST" action="{{ route('user.toko.update') }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        {{-- Info Toko --}}
                                        <h5 class="mb-3 mt-2" style="color:#2a3f54;"><i class="fas fa-store me-2" style="color:#26b99a;"></i>Informasi Toko</h5>

                                        <div class="form-floating mb-3">
                                            <input class="form-control" name="nama_toko" type="text" value="{{ old('nama_toko', $toko->nama_toko) }}" required placeholder="Nama Toko" />
                                            <label>Nama Toko</label>
                                            @error('nama_toko')<small class="text-danger">{{ $message }}</small>@enderror
                                        </div>
                                        <div class="form-floating mb-3">
                                            <textarea class="form-control" name="alamat" placeholder="Alamat" style="height:100px" required>{{ old('alamat', $toko->alamat) }}</textarea>
                                            <label>Alamat Lengkap</label>
                                            @error('alamat')<small class="text-danger">{{ $message }}</small>@enderror
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" name="telepon" type="text" value="{{ old('telepon', $toko->telepon) }}" required placeholder="Nomor Telepon" />
                                            <label>Nomor Telepon</label>
                                            @error('telepon')<small class="text-danger">{{ $message }}</small>@enderror
                                        </div>
                                        <div class="form-floating mb-4">
                                            <textarea class="form-control" name="deskripsi" placeholder="Deskripsi" style="height:100px">{{ old('deskripsi', $toko->deskripsi) }}</textarea>
                                            <label>Deskripsi Toko (Opsional)</label>
                                        </div>

                                        <hr>

                                        {{-- Informasi Pembayaran --}}
                                        <h5 class="mb-1 mt-3" style="color:#2a3f54;"><i class="fas fa-wallet me-2" style="color:#26b99a;"></i>Informasi Pembayaran</h5>
                                        <p class="text-muted mb-3" style="font-size:13px;">Digunakan untuk menerima pembayaran dari pembeli.</p>

                                        {{-- Tab Pilih Tipe --}}
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Metode Pembayaran <span class="text-danger">*</span></label>
                                            <div class="d-flex gap-2">
                                                @php $tipe = old('tipe_pembayaran', $toko->tipe_pembayaran ?? 'bank'); @endphp
                                                <div class="payment-tab text-center p-3 rounded border flex-fill"
                                                     id="tab-bank"
                                                     onclick="switchPayment('bank')"
                                                     style="border-width:2px !important; border-color:{{ $tipe == 'bank' ? '#26b99a' : '#dee2e6' }} !important;">
                                                    <i class="fas fa-university fa-lg mb-1 d-block" style="color:#26b99a;"></i>
                                                    <span style="font-size:13px;font-weight:600;">Transfer Bank</span>
                                                </div>
                                                <div class="payment-tab text-center p-3 rounded border flex-fill"
                                                     id="tab-ewallet"
                                                     onclick="switchPayment('ewallet')"
                                                     style="border-width:2px !important; border-color:{{ $tipe == 'ewallet' ? '#26b99a' : '#dee2e6' }} !important;">
                                                    <i class="fas fa-mobile-alt fa-lg mb-1 d-block" style="color:#26b99a;"></i>
                                                    <span style="font-size:13px;font-weight:600;">E-Wallet</span>
                                                </div>
                                                <div class="payment-tab text-center p-3 rounded border flex-fill"
                                                     id="tab-qris"
                                                     onclick="switchPayment('qris')"
                                                     style="border-width:2px !important; border-color:{{ $tipe == 'qris' ? '#26b99a' : '#dee2e6' }} !important;">
                                                    <i class="fas fa-qrcode fa-lg mb-1 d-block" style="color:#26b99a;"></i>
                                                    <span style="font-size:13px;font-weight:600;">QRIS</span>
                                                </div>
                                                <!-- <div class="payment-tab text-center p-3 rounded border flex-fill"
                                                     id="tab-keduanya"
                                                     onclick="switchPayment('keduanya')"
                                                     style="border-width:2px !important; border-color:{{ $tipe == 'keduanya' ? '#26b99a' : '#dee2e6' }} !important;">
                                                    <i class="fas fa-layer-group fa-lg mb-1 d-block" style="color:#26b99a;"></i>
                                                    <span style="font-size:13px;font-weight:600;">Bank + QRIS</span>
                                                </div> -->
                                            </div>
                                            <input type="hidden" name="tipe_pembayaran" id="tipe_pembayaran" value="{{ $tipe }}">

                                        {{-- Form QRIS --}}
                                        <div id="form-qris">
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold" style="font-size:13px;">
                                                    Upload Gambar QRIS Statis <span class="text-danger">*</span>
                                                </label>
                                                @if($toko->gambar_qris)
                                                <div class="mb-2">
                                                    <img src="{{ Storage::url($toko->gambar_qris) }}"
                                                         alt="QRIS saat ini"
                                                         style="max-height:180px;border-radius:10px;border:2px solid #e2e8f0;">
                                                    <div style="font-size:12px;color:#888;margin-top:4px;">QRIS saat ini — upload baru untuk mengganti</div>
                                                </div>
                                                @endif
                                                <input type="file" name="gambar_qris" id="gambar_qris"
                                                       accept="image/*" class="form-control"
                                                       style="border-radius:8px;">
                                                <small class="text-muted">Format JPG/PNG, maks. 2MB. Pastikan QR terlihat jelas.</small>
                                                @error('gambar_qris')<small class="text-danger">{{ $message }}</small>@enderror
                                            </div>
                                            <div class="p-3 rounded-3 mb-3" style="background:#f0fdf9;border:1px solid #bbf7e8;font-size:12px;color:#555;">
                                                <i class="fas fa-info-circle me-1" style="color:#26b99a;"></i>
                                                Upload foto QRIS statis dari dompet digital Anda (GoPay, OVO, DANA, ShopeePay, dll).
                                                Pelanggan akan scan QR ini dan transfer nominal sesuai total pesanan.
                                            </div>
                                        </div>
                                        </div>

                                        {{-- Form Bank --}}
                                        <div id="form-bank">
                                            <div class="form-floating mb-3">
                                                <select class="form-select" name="nama_bank" id="nama_bank">
                                                    <option value="">-- Pilih Bank --</option>
                                                    @foreach(['BCA','BRI','BNI','Mandiri','BSI','CIMB Niaga','Danamon','Permata','BTN','Maybank'] as $bank)
                                                        <option value="{{ $bank }}" {{ old('nama_bank', $toko->nama_bank) == $bank ? 'selected' : '' }}>{{ $bank }}</option>
                                                    @endforeach
                                                </select>
                                                <label>Nama Bank</label>
                                                @error('nama_bank')<small class="text-danger">{{ $message }}</small>@enderror
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" type="text" name="nomor_rekening" id="nomor_rekening"
                                                       value="{{ old('nomor_rekening', $toko->nomor_rekening) }}" placeholder="Nomor Rekening" />
                                                <label>Nomor Rekening</label>
                                                @error('nomor_rekening')<small class="text-danger">{{ $message }}</small>@enderror
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" type="text" name="nama_pemilik_rekening" id="nama_pemilik_rekening"
                                                       value="{{ old('nama_pemilik_rekening', $toko->nama_pemilik_rekening) }}" placeholder="Nama Pemilik Rekening" />
                                                <label>Nama Pemilik Rekening</label>
                                                @error('nama_pemilik_rekening')<small class="text-danger">{{ $message }}</small>@enderror
                                            </div>
                                        </div>

                                        {{-- Form E-Wallet --}}
                                        <div id="form-ewallet">
                                            <div class="form-floating mb-3">
                                                <select class="form-select" name="nama_ewallet" id="nama_ewallet">
                                                    <option value="">-- Pilih E-Wallet --</option>
                                                    @foreach(['DANA','GoPay','OVO','ShopeePay','LinkAja','QRIS'] as $ew)
                                                        <option value="{{ $ew }}" {{ old('nama_ewallet', $toko->nama_ewallet) == $ew ? 'selected' : '' }}>{{ $ew }}</option>
                                                    @endforeach
                                                </select>
                                                <label>Nama E-Wallet</label>
                                                @error('nama_ewallet')<small class="text-danger">{{ $message }}</small>@enderror
                                            </div>
                                            <!-- <div class="form-floating mb-3">
                                                <input class="form-control" type="text" name="nomor_ewallet" id="nomor_ewallet"
                                                       value="{{ old('nomor_ewallet', $toko->nomor_ewallet) }}" placeholder="Nomor E-Wallet" />
                                                <label>Nomor E-Wallet</label>
                                                @error('nomor_ewallet')<small class="text-danger">{{ $message }}</small>@enderror
                                            </div> -->
                                            <div class="form-floating mb-3">
                                                <input class="form-control" type="text" name="nama_pemilik_ewallet" id="nama_pemilik_ewallet"
                                                       value="{{ old('nama_pemilik_ewallet', $toko->nama_pemilik_ewallet) }}" placeholder="Nama Pemilik E-Wallet" />
                                                <label>Nama Pemilik E-Wallet</label>
                                                @error('nama_pemilik_ewallet')<small class="text-danger">{{ $message }}</small>@enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-semibold" style="font-size:13px;">
                                                    Upload QR Code E-Wallet <span class="text-muted">(Opsional)</span>
                                                </label>
                                                @if($toko->gambar_ewallet_qr)
                                                <div class="mb-2">
                                                    <img src="{{ Storage::url($toko->gambar_ewallet_qr) }}" 
                                                         alt="QR E-Wallet" 
                                                         style="max-height:150px; border-radius:8px; border:1px solid #ddd;">
                                                </div>
                                                @endif
                                                <input type="file" name="gambar_ewallet_qr" class="form-control" accept="image/*">
                                                <small class="text-muted" style="font-size:11px;">Upload QR DANA/OVO/GoPay Anda.</small>
                                            </div>
                                        </div>

                                        <hr>

                                        {{-- Opsi Jasa Pengiriman --}}
                                        <h5 class="mb-1 mt-3" style="color:#2a3f54;"><i class="fas fa-shipping-fast me-2" style="color:#26b99a;"></i>Jasa Pengiriman</h5>
                                        <p class="text-muted mb-3" style="font-size:13px;">Pilih apakah menggunakan jasa pengiriman RajaOngkir atau tidak.</p>

                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <div class="form-check mb-3">
                                                    <input class="form-check-input" type="checkbox" name="gunakan_rajaongkir" id="gunakanRajaongkir" value="1" 
                                                        {{ old('gunakan_rajaongkir', $toko->gunakan_rajaongkir) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="gunakanRajaongkir">
                                                        <strong>Gunakan RajaOngkir</strong>
                                                        <br><small class="text-muted">Pelanggan dapat memilih jasa pengiriman (JNE, TIKI, POS) dengan ongkir otomatis</small>
                                                    </label>
                                                </div>

                                                <div id="rajaongkirFields" style="display: {{ old('gunakan_rajaongkir', $toko->gunakan_rajaongkir) ? 'block' : 'none' }};">
                                                    <div class="alert alert-info">
                                                        <i class="fas fa-info-circle"></i> Pilih kota asal pengiriman untuk menghitung ongkos kirim
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Provinsi Asal</label>
                                                        <select class="form-select" id="provinsiAsal" name="provinsi_asal">
                                                            <option value="">-- Pilih Provinsi --</option>
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Kota/Kabupaten Asal <span class="text-danger">*</span></label>
                                                        <select class="form-select" id="kotaAsal" name="kota_asal_id">
                                                            <option value="">-- Pilih Kota --</option>
                                                        </select>
                                                        <input type="hidden" id="kotaAsalNama" name="kota_asal_nama" value="{{ old('kota_asal_nama', $toko->kota_asal_nama) }}">
                                                        @if($toko->kota_asal_nama)
                                                            <small class="text-muted">Saat ini: {{ $toko->kota_asal_nama }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <a class="btn btn-secondary" href="{{ route('user.toko.index') }}">Kembali</a>
                                            <button class="btn btn-primary" type="submit">Update Toko</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script>
    function switchPayment(tipe) {
        document.getElementById('tipe_pembayaran').value = tipe;

        ['bank','ewallet','qris','keduanya'].forEach(function(t) {
            var tab = document.getElementById('tab-' + t);
            if (tab) tab.style.borderColor = '#dee2e6';
        });
        var activeTab = document.getElementById('tab-' + tipe);
        if (activeTab) activeTab.style.borderColor = '#26b99a';

        var showBank  = (tipe === 'bank'    || tipe === 'keduanya');
        var showQris  = (tipe === 'qris'    || tipe === 'keduanya');
        var showEwalet = (tipe === 'ewallet');

        document.getElementById('form-bank').style.display    = showBank   ? '' : 'none';
        document.getElementById('form-ewallet').style.display = showEwalet ? '' : 'none';
        document.getElementById('form-qris').style.display    = showQris   ? '' : 'none';

        ['nama_bank','nomor_rekening','nama_pemilik_rekening'].forEach(function(id) {
            var el = document.getElementById(id);
            if (el) el.required = showBank;
        });
        ['nama_ewallet','nomor_ewallet','nama_pemilik_ewallet'].forEach(function(id) {
            var el = document.getElementById(id);
            if (el) el.required = showEwalet;
        });
    }
    switchPayment(document.getElementById('tipe_pembayaran').value || 'bank');

    // RajaOngkir Toggle
    const kotaAsalIdAwal = '{{ old("kota_asal_id", $toko->kota_asal_id) }}';
    
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
            .catch(error => console.error('Error:', error));
    }

    // Load Kota
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
                        const selected = city.city_id == kotaAsalIdAwal ? 'selected' : '';
                        kotaSelect.innerHTML += `<option value="${city.city_id}" data-nama="${cityName}" ${selected}>${cityName}</option>`;
                    });
                }
            })
            .catch(error => console.error('Error:', error));
    });

    // Save kota nama
    document.getElementById('kotaAsal').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const kotaNama = selectedOption.getAttribute('data-nama') || selectedOption.text;
        document.getElementById('kotaAsalNama').value = kotaNama;
    });

    // Load data awal jika sudah ada
    if (document.getElementById('gunakanRajaongkir').checked) {
        loadProvinsi();
    }
    </script>
</body>
</html>

