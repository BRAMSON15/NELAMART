<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Daftar Toko - NELA MART</title>
    <link href="{{asset('mentahan1/css/styles.css')}}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">
                                        <i class="fas fa-store"></i> Daftar Toko UMKM
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('user.toko.store') }}">
                                        @csrf
                                        <div class="form-floating mb-3">
                                            <input class="form-control" name="nama_toko" type="text" placeholder="Nama Toko" required />
                                            <label>Nama Toko</label>
                                            @error('nama_toko')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-floating mb-3">
                                            <textarea class="form-control" name="alamat" placeholder="Alamat" style="height: 100px" required></textarea>
                                            <label>Alamat Lengkap</label>
                                            @error('alamat')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" name="telepon" type="text" placeholder="Telepon" required />
                                            <label>Nomor Telepon</label>
                                            @error('telepon')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-floating mb-3">
                                            <textarea class="form-control" name="deskripsi" placeholder="Deskripsi" style="height: 100px"></textarea>
                                            <label>Deskripsi Toko (Opsional)</label>
                                        </div>

                                        <!-- Opsi Jasa Pengiriman -->
                                        <div class="card mb-3">
                                            <div class="card-header bg-light">
                                                <h6 class="mb-0"><i class="fas fa-shipping-fast"></i> Jasa Pengiriman</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-check mb-3">
                                                    <input class="form-check-input" type="checkbox" name="gunakan_rajaongkir" id="gunakanRajaongkir" value="1">
                                                    <label class="form-check-label" for="gunakanRajaongkir">
                                                        <strong>Gunakan RajaOngkir</strong>
                                                        <br><small class="text-muted">Pelanggan dapat memilih jasa pengiriman (JNE, TIKI, POS) dengan ongkir otomatis</small>
                                                    </label>
                                                </div>

                                                <div id="rajaongkirFields" style="display: none;">
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
                                                            <op tion value="">-- Pilih Kota --</option>
                                                        </select>
                                                        <input type="hidden" id="kotaAsalNama" name="kota_asal_nama">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <a class="btn btn-secondary" href="{{ route('user.dashboard') }}">Kembali</a>
                                            <button class="btn btn-primary" type="submit">Daftar Toko</button>
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
    </script>
</body>
</html>

