/**
 * UMKM Store - Map & GPS Geolocation
 */
let map = null;
let marker = null;

function initMap(lat, lng, elementId = 'map', containerId = 'mapContainer') {
    const container = document.getElementById(containerId);
    if (container) container.style.display = 'block';

    if (map) {
        map.setView([lat, lng], 15);
        if (marker) marker.setLatLng([lat, lng]);
        return;
    }

    const mapEl = document.getElementById(elementId);
    if (!mapEl) return;

    map = L.map(elementId).setView([lat, lng], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(map);

    marker = L.marker([lat, lng], { draggable: true }).addTo(map);

    // Drag marker → update input
    marker.on('dragend', function(e) {
        const pos = e.target.getLatLng();
        setCoords(pos.lat, pos.lng);
        reverseGeocode(pos.lat, pos.lng);
    });

    // Klik peta → pindah marker
    map.on('click', function(e) {
        marker.setLatLng(e.latlng);
        setCoords(e.latlng.lat, e.latlng.lng);
        reverseGeocode(e.latlng.lat, e.latlng.lng);
    });
}

function setCoords(lat, lng) {
    const latIn = document.getElementById('latInput');
    const lngIn = document.getElementById('lngInput');
    if (latIn) latIn.value = lat.toFixed(7);
    if (lngIn) lngIn.value = lng.toFixed(7);
}

function reverseGeocode(lat, lng) {
    fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`)
        .then(r => r.json())
        .then(data => {
            const addr = document.getElementById('alamatInput');
            if (addr && data.display_name) {
                addr.value = data.display_name;
            }
        })
        .catch(() => {});
}

function getGPS(btnId = 'gpsBtn', statusId = 'gpsStatus') {
    const btn = document.getElementById(btnId);
    const status = document.getElementById(statusId);

    if (!navigator.geolocation) {
        if (status) {
            status.style.display = 'block';
            status.style.color = '#ef4444';
            status.innerHTML = '<i class="fas fa-times-circle me-1"></i> Browser tidak mendukung GPS.';
        }
        return;
    }

    const oldHtml = btn ? btn.innerHTML : '';
    if (btn) {
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Mendeteksi lokasi...';
        btn.disabled = true;
    }
    if (status) status.style.display = 'none';

    navigator.geolocation.getCurrentPosition(
        function(pos) {
            const lat = pos.coords.latitude;
            const lng = pos.coords.longitude;

            setCoords(lat, lng);
            initMap(lat, lng);
            reverseGeocode(lat, lng);

            if (btn) {
                btn.innerHTML = '<i class="fas fa-check me-2"></i> Lokasi Terdeteksi';
                btn.style.background = 'rgba(38,185,154,0.2)';
                btn.disabled = false;
            }

            if (status) {
                status.style.display = 'block';
                status.style.color = '#26b99a';
                status.innerHTML = `<i class="fas fa-map-marker-alt me-1"></i> ${lat.toFixed(5)}, ${lng.toFixed(5)}`;
            }
        },
        function(err) {
            if (btn) {
                btn.innerHTML = oldHtml || '<i class="fas fa-location-arrow me-2"></i> Gunakan Lokasi Saya';
                btn.disabled = false;
            }
            if (status) {
                status.style.display = 'block';
                status.style.color = '#ef4444';
                const msg = err.code === 1 ? 'Izin lokasi ditolak.' : 'Gagal mendapatkan lokasi.';
                status.innerHTML = `<i class="fas fa-exclamation-circle me-1"></i> ${msg}`;
            }
        },
        { enableHighAccuracy: true, timeout: 10000 }
    );
}
