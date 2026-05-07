<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracking Pengiriman - NELA MART</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <link href="{{ asset('css/beranda.css') }}?v={{ time() }}" rel="stylesheet">
    <link href="{{ asset('css/pelanggan-theme.css') }}?v={{ time() }}" rel="stylesheet">
    <style>
        #trackingMap {
            height: 500px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .tracking-info {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        
        .kurir-info {
            background: linear-gradient(135deg, #26b99a, #1abb9c);
            color: white;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }
        
        .pulse-dot {
            width: 12px;
            height: 12px;
            background: #26b99a;
            border-radius: 50%;
            display: inline-block;
            animation: pulse 2s infinite;
            margin-right: 8px;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.2); }
        }
        
        @media (max-width: 768px) {
            #trackingMap {
                height: 350px;
            }
        }
    </style>
</head>
<body>

<!-- ===== NAVBAR ===== -->
<nav class="navbar" id="navbar" style="position:sticky;top:0;z-index:999;">
    <div class="nav-container">
        <a href="/" class="logo"><i class="fas fa-store"></i> NELA MART</a>
        <ul class="nav-menu">
            <li><a href="{{ route('pelanggan.dashboard') }}">Beranda</a></li>
            <li><a href="{{ route('keranjang.index') }}">Keranjang</a></li>
            <li><a href="{{ route('profil.index') }}">Profil</a></li>
        </ul>
        <div class="nav-buttons">
            <a href="{{ route('pelanggan.dashboard') }}" class="btn btn-outline btn-sm">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
        <button class="nav-toggle" id="navToggle"><i class="fas fa-bars"></i></button>
    </div>
</nav>

<section style="padding: 40px 20px; background: #f5f5f5; min-height: 100vh;">
    <div class="container" style="max-width: 1200px;">
        
        <div class="text-center mb-4">
            <h2 style="color: #2a3f54; font-weight: 700;">
                <i class="fas fa-map-marked-alt me-2" style="color: #26b99a;"></i>
                Tracking Pengiriman
            </h2>
            <p class="text-muted">Pesanan #{{ $pesanan->id }}</p>
        </div>

        <div class="row g-4">
            <!-- Peta Tracking -->
            <div class="col-lg-8">
                <div id="trackingMap"></div>
                
                <div class="tracking-info mt-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="pulse-dot"></span>
                            <span class="fw-semibold">Status Pengiriman:</span>
                            <span class="status-badge ms-2" style="background: 
                                @if($pesanan->status == 'dikirim') #26b99a
                                @elseif($pesanan->status == 'selesai') #4CAF50
                                @else #ffc107
                                @endif; color: white;">
                                {{ ucfirst($pesanan->status) }}
                            </span>
                        </div>
                        <small class="text-muted" id="lastUpdate">
                            @if($pesanan->tracking_updated_at)
                                Update: {{ $pesanan->tracking_updated_at->diffForHumans() }}
                            @endif
                        </small>
                    </div>
                </div>
            </div>

            <!-- Info Pengiriman -->
            <div class="col-lg-4">
                @if($pesanan->kurir_nama)
                <div class="kurir-info">
                    <h5 class="mb-3">
                        <i class="fas fa-motorcycle me-2"></i>
                        Informasi Kurir
                    </h5>
                    <div class="mb-2">
                        <i class="fas fa-user me-2"></i>
                        <strong>{{ $pesanan->kurir_nama }}</strong>
                    </div>
                    @if($pesanan->kurir_telepon)
                    <div>
                        <i class="fas fa-phone me-2"></i>
                        <a href="tel:{{ $pesanan->kurir_telepon }}" style="color: white; text-decoration: none;">
                            {{ $pesanan->kurir_telepon }}
                        </a>
                    </div>
                    @endif
                </div>
                @endif

                <div class="tracking-info">
                    <h5 class="mb-3" style="color: #2a3f54;">
                        <i class="fas fa-map-marker-alt me-2" style="color: #26b99a;"></i>
                        Alamat Tujuan
                    </h5>
                    <p class="mb-2"><strong>{{ $pesanan->user->name }}</strong></p>
                    <p class="text-muted small mb-0">{{ $pesanan->alamat_pengiriman }}</p>
                </div>

                <div class="tracking-info mt-3">
                    <h5 class="mb-3" style="color: #2a3f54;">
                        <i class="fas fa-box me-2" style="color: #26b99a;"></i>
                        Detail Pesanan
                    </h5>
                    @foreach($pesanan->details as $detail)
                    <div class="d-flex align-items-center mb-2 pb-2 border-bottom">
                        @if($detail->produk->gambar)
                        <img src="{{ Storage::url($detail->produk->gambar) }}" 
                             alt="{{ $detail->produk->nama_produk }}"
                             style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                        @endif
                        <div class="ms-3 flex-grow-1">
                            <div class="fw-semibold" style="font-size: 14px;">{{ $detail->produk->nama_produk }}</div>
                            <small class="text-muted">{{ $detail->jumlah }}x</small>
                        </div>
                    </div>
                    @endforeach
                    
                    <div class="mt-3 pt-3 border-top">
                        <div class="d-flex justify-content-between">
                            <span class="fw-bold">Total:</span>
                            <span class="fw-bold" style="color: #26b99a;">
                                Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-3">
                    <a href="{{ route('pesanan.detail', $pesanan->id) }}" class="btn btn-outline-dark w-100">
                        <i class="fas fa-receipt me-2"></i>
                        Lihat Detail Pesanan
                    </a>
                </div>
            </div>
        </div>

    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="{{ asset('js/app-navbar.js') }}"></script>
<script>
    let map, kurirMarker, tujuanMarker, routeLine;
    const pesananId = {{ $pesanan->id }};
    const tujuanLat = {{ $pesanan->user->latitude ?? -6.2088 }};
    const tujuanLng = {{ $pesanan->user->longitude ?? 106.8456 }};
    
    // Icon custom
    const kurirIcon = L.icon({
        iconUrl: 'data:image/svg+xml;base64,' + btoa(`
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="%2326b99a" width="40" height="40">
                <circle cx="12" cy="12" r="10" fill="white" stroke="%2326b99a" stroke-width="2"/>
                <path d="M12 2L15 8L21 9L16.5 13.5L17.5 19.5L12 16.5L6.5 19.5L7.5 13.5L3 9L9 8L12 2Z" fill="%2326b99a"/>
            </svg>
        `),
        iconSize: [40, 40],
        iconAnchor: [20, 40],
        popupAnchor: [0, -40]
    });

    const tujuanIcon = L.icon({
        iconUrl: 'data:image/svg+xml;base64,' + btoa(`
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="%23ef4444" width="40" height="40">
                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
            </svg>
        `),
        iconSize: [40, 40],
        iconAnchor: [20, 40],
        popupAnchor: [0, -40]
    });

    // Init map
    function initMap(kurirLat, kurirLng) {
        if (!map) {
            map = L.map('trackingMap').setView([kurirLat || tujuanLat, kurirLng || tujuanLng], 13);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);
        }

        // Marker tujuan
        if (!tujuanMarker) {
            tujuanMarker = L.marker([tujuanLat, tujuanLng], {icon: tujuanIcon})
                .addTo(map)
                .bindPopup('<b>Alamat Tujuan</b><br>{{ $pesanan->user->name }}');
        }

        // Marker kurir
        if (kurirLat && kurirLng) {
            if (kurirMarker) {
                kurirMarker.setLatLng([kurirLat, kurirLng]);
            } else {
                kurirMarker = L.marker([kurirLat, kurirLng], {icon: kurirIcon})
                    .addTo(map)
                    .bindPopup('<b>Kurir</b><br>{{ $pesanan->kurir_nama ?? "Dalam Perjalanan" }}');
            }

            // Garis rute
            if (routeLine) {
                map.removeLayer(routeLine);
            }
            routeLine = L.polyline([[kurirLat, kurirLng], [tujuanLat, tujuanLng]], {
                color: '#26b99a',
                weight: 3,
                opacity: 0.7,
                dashArray: '10, 10'
            }).addTo(map);

            // Fit bounds
            const bounds = L.latLngBounds([
                [kurirLat, kurirLng],
                [tujuanLat, tujuanLng]
            ]);
            map.fitBounds(bounds, {padding: [50, 50]});
        } else {
            map.setView([tujuanLat, tujuanLng], 15);
        }
    }

    // Update lokasi kurir
    function updateTracking() {
        fetch(`/tracking/${pesananId}/location`)
            .then(res => res.json())
            .then(data => {
                if (data.kurir_latitude && data.kurir_longitude) {
                    initMap(data.kurir_latitude, data.kurir_longitude);
                    
                    if (data.tracking_updated_at) {
                        document.getElementById('lastUpdate').textContent = 
                            'Update: ' + new Date(data.tracking_updated_at).toLocaleString('id-ID');
                    }
                }
            })
            .catch(err => console.error('Error:', err));
    }

    // Init
    document.addEventListener('DOMContentLoaded', function() {
        @if($pesanan->kurir_latitude && $pesanan->kurir_longitude)
            initMap({{ $pesanan->kurir_latitude }}, {{ $pesanan->kurir_longitude }});
        @else
            initMap(null, null);
        @endif

        // Auto refresh setiap 10 detik jika status dikirim
        @if($pesanan->status == 'dikirim')
            setInterval(updateTracking, 10000);
        @endif
    });
</script>

</body>
</html>
