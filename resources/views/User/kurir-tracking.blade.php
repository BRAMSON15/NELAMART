<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Lokasi Pengiriman - NELA MART</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f5f5f5;
        }
        
        #map {
            height: 400px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .tracking-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            margin-bottom: 20px;
        }
        
        .btn-update {
            background: linear-gradient(135deg, #26b99a, #1abb9c);
            border: none;
            color: white;
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-update:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(38, 185, 154, 0.3);
        }
        
        .status-indicator {
            width: 12px;
            height: 12px;
            background: #26b99a;
            border-radius: 50%;
            display: inline-block;
            animation: blink 1.5s infinite;
        }
        
        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.3; }
        }
    </style>
</head>
<body>

<div class="container py-5" style="max-width: 800px;">
    <div class="text-center mb-4">
        <h2 style="color: #2a3f54; font-weight: 700;">
            <i class="fas fa-motorcycle me-2" style="color: #26b99a;"></i>
            Update Lokasi Pengiriman
        </h2>
        <p class="text-muted">Pesanan #{{ $pesanan->id }}</p>
    </div>

    <div class="tracking-card">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 style="color: #2a3f54; margin: 0;">
                <span class="status-indicator"></span>
                <span class="ms-2">Tracking Aktif</span>
            </h5>
            <small class="text-muted" id="lastUpdate">
                @if($pesanan->tracking_updated_at)
                    Update: {{ $pesanan->tracking_updated_at->format('H:i:s') }}
                @else
                    Belum ada update
                @endif
            </small>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Nama Kurir</label>
                <input type="text" id="kurirNama" class="form-control" 
                       value="{{ $pesanan->kurir_nama }}" placeholder="Nama kurir">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Telepon Kurir</label>
                <input type="text" id="kurirTelepon" class="form-control" 
                       value="{{ $pesanan->kurir_telepon }}" placeholder="08xx">
            </div>
        </div>

        <div id="map" class="mb-3"></div>

        <div class="row g-2 mb-3">
            <div class="col-6">
                <input type="text" id="latDisplay" class="form-control form-control-sm" 
                       placeholder="Latitude" readonly>
            </div>
            <div class="col-6">
                <input type="text" id="lngDisplay" class="form-control form-control-sm" 
                       placeholder="Longitude" readonly>
            </div>
        </div>

        <div class="d-grid gap-2">
            <button onclick="updateMyLocation()" class="btn btn-update">
                <i class="fas fa-location-arrow me-2"></i>
                Update Lokasi Saya
            </button>
            <button onclick="saveLocation()" class="btn btn-success">
                <i class="fas fa-save me-2"></i>
                Simpan & Kirim ke Pelanggan
            </button>
        </div>

        <div id="statusMessage" class="mt-3"></div>
    </div>

    <div class="tracking-card">
        <h5 class="mb-3" style="color: #2a3f54;">
            <i class="fas fa-map-marker-alt me-2" style="color: #ef4444;"></i>
            Alamat Tujuan
        </h5>
        <p class="mb-2"><strong>{{ $pesanan->user->name }}</strong></p>
        <p class="text-muted mb-0">{{ $pesanan->alamat_pengiriman }}</p>
    </div>

    <div class="text-center">
        <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>
            Kembali ke Dashboard
        </a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    let map, marker;
    let currentLat = {{ $pesanan->kurir_latitude ?? 'null' }};
    let currentLng = {{ $pesanan->kurir_longitude ?? 'null' }};
    const tujuanLat = {{ $pesanan->user->latitude ?? -6.2088 }};
    const tujuanLng = {{ $pesanan->user->longitude ?? 106.8456 }};
    const pesananId = {{ $pesanan->id }};

    // Init map
    map = L.map('map').setView([currentLat || tujuanLat, currentLng || tujuanLng], 15);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Marker tujuan
    const tujuanIcon = L.icon({
        iconUrl: 'data:image/svg+xml;base64,' + btoa(`
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="%23ef4444" width="40" height="40">
                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
            </svg>
        `),
        iconSize: [40, 40],
        iconAnchor: [20, 40]
    });

    L.marker([tujuanLat, tujuanLng], {icon: tujuanIcon})
        .addTo(map)
        .bindPopup('<b>Tujuan Pengiriman</b>');

    // Marker kurir
    if (currentLat && currentLng) {
        marker = L.marker([currentLat, currentLng], {draggable: true}).addTo(map);
        updateDisplay(currentLat, currentLng);
        
        marker.on('dragend', function(e) {
            const pos = e.target.getLatLng();
            updateDisplay(pos.lat, pos.lng);
        });
    }

    function updateDisplay(lat, lng) {
        document.getElementById('latDisplay').value = lat.toFixed(6);
        document.getElementById('lngDisplay').value = lng.toFixed(6);
        currentLat = lat;
        currentLng = lng;
    }

    function updateMyLocation() {
        if (!navigator.geolocation) {
            showMessage('Browser tidak support GPS', 'danger');
            return;
        }

        showMessage('Mengambil lokasi...', 'info');

        navigator.geolocation.getCurrentPosition(
            function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;

                if (marker) {
                    marker.setLatLng([lat, lng]);
                } else {
                    marker = L.marker([lat, lng], {draggable: true}).addTo(map);
                    marker.on('dragend', function(e) {
                        const pos = e.target.getLatLng();
                        updateDisplay(pos.lat, pos.lng);
                    });
                }

                map.setView([lat, lng], 16);
                updateDisplay(lat, lng);
                showMessage('Lokasi berhasil diambil!', 'success');
            },
            function(error) {
                showMessage('Gagal mengambil lokasi: ' + error.message, 'danger');
            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            }
        );
    }

    function saveLocation() {
        if (!currentLat || !currentLng) {
            showMessage('Silakan update lokasi terlebih dahulu', 'warning');
            return;
        }

        const kurirNama = document.getElementById('kurirNama').value;
        const kurirTelepon = document.getElementById('kurirTelepon').value;

        showMessage('Menyimpan lokasi...', 'info');

        fetch(`/tracking/${pesananId}/update`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                latitude: currentLat,
                longitude: currentLng,
                kurir_nama: kurirNama,
                kurir_telepon: kurirTelepon
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showMessage('Lokasi berhasil dikirim ke pelanggan!', 'success');
                document.getElementById('lastUpdate').textContent = 
                    'Update: ' + new Date().toLocaleTimeString('id-ID');
            } else {
                showMessage('Gagal menyimpan lokasi', 'danger');
            }
        })
        .catch(err => {
            showMessage('Error: ' + err.message, 'danger');
        });
    }

    function showMessage(text, type) {
        const statusDiv = document.getElementById('statusMessage');
        statusDiv.innerHTML = `<div class="alert alert-${type}">${text}</div>`;
        
        if (type === 'success') {
            setTimeout(() => {
                statusDiv.innerHTML = '';
            }, 3000);
        }
    }

    // Auto update setiap 30 detik
    setInterval(function() {
        if (currentLat && currentLng) {
            updateMyLocation();
        }
    }, 30000);
</script>

</body>
</html>
