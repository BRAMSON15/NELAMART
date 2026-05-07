/**
 * UMKM Store - Product Detail Logic
 */

/**
 * Change quantity in product detail page
 */
function changeQty(delta) {
    const input = document.getElementById('jumlahInput');
    if (!input) return;

    const max = parseInt(input.max) || 999;
    let val = parseInt(input.value) + delta;

    if (val < 1) val = 1;
    if (val > max) val = max;

    input.value = val;
    
    // Update hidden inputs for forms
    const qtyCart = document.getElementById('jumlahKeranjang');
    const qtyBuy = document.getElementById('jumlahBeli');
    if (qtyCart) qtyCart.value = val;
    if (qtyBuy) qtyBuy.value = val;
}

/**
 * Init listeners for manual qty input
 */
document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('jumlahInput');
    if (input) {
        input.addEventListener('input', function() {
            const qtyCart = document.getElementById('jumlahKeranjang');
            const qtyBuy = document.getElementById('jumlahBeli');
            if (qtyCart) qtyCart.value = this.value;
            if (qtyBuy) qtyBuy.value = this.value;
        });
    }
});

/**
 * Switch product variant
 */
function pilihVarian(btn) {
    // Reset all buttons
    document.querySelectorAll('.varian-btn').forEach(b => {
        b.style.borderColor = '#dee2e6';
        b.style.background = 'white';
        b.style.color = '#2a3f54';
    });

    // Highlight selected
    btn.style.borderColor = '#26b99a';
    btn.style.background = 'rgba(38,185,154,0.08)';
    btn.style.color = '#26b99a';

    // Update hidden fields and display
    const selVar = document.getElementById('selectedVarian');
    const hargaTampil = document.getElementById('hargaTampil');
    const input = document.getElementById('jumlahInput');

    if (selVar) selVar.value = btn.dataset.id;
    if (hargaTampil) {
        hargaTampil.textContent = 'Rp ' + parseInt(btn.dataset.harga).toLocaleString('id-ID');
    }
    if (input) input.max = btn.dataset.stok;
}

/**
 * Star Rating logic
 */
let dpSelected = 0;
const dpLabels = ['', 'Sangat Buruk', 'Buruk', 'Cukup', 'Bagus', 'Sangat Bagus'];

function dpSetRating(val) {
    dpSelected = val;
    const input = document.getElementById('dpRatingInput');
    const badge = document.getElementById('dpRatingBadge');
    const label = document.getElementById('dpRatingLabel');

    if (input) input.value = val;
    if (badge) badge.style.display = 'inline-block';
    if (label) label.textContent = dpLabels[val];
    dpUpdateStars(val);
}

function dpHover(val) { 
    dpUpdateStars(val); 
}

function dpResetHover() { 
    dpUpdateStars(dpSelected); 
}

function dpUpdateStars(val) {
    document.querySelectorAll('.dp-star').forEach((s, i) => {
        s.style.color = i < val ? '#ffc107' : '#ddd';
        s.style.transform = i < val ? 'scale(1.15)' : 'scale(1)';
    });
}
