/**
 * UMKM Store - Cart Utilities
 */

/**
 * Change quantity stepper for cart or product details
 */
function changeItemQty(btn, delta) {
    const input = btn.parentElement.querySelector('input[name="jumlah"]');
    if (!input) return;

    let val = parseInt(input.value) + delta;
    const min = parseInt(input.min) || 1;
    const max = parseInt(input.max) || 999;

    if (val < min) val = min;
    if (val > max) val = max;

    input.value = val;

    // Auto submit if it's in the cart form
    const form = input.closest('form');
    if (form && form.hasAttribute('onchange-submit')) {
        form.submit();
    } else if (form) {
        // Find if any other connected fields need updating (like in detail-produk)
        const connectedQty = document.getElementById('jumlahKeranjang') || document.getElementById('jumlahBeli');
        if (connectedQty) connectedQty.value = val;
    }
}

/**
 * AJAX Add to Cart
 */
function addToCart(productId, csrfToken, route) {
    if(confirm('Tambahkan produk ini ke keranjang?')) {
        fetch(route, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                produk_id: productId,
                jumlah: 1
            })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                alert('Produk berhasil ditambahkan ke keranjang!');
                location.reload(); // To update navbar badge
            } else {
                alert('Gagal menambahkan produk: ' + (data.message || 'Error occurred'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menambahkan produk');
        });
    }
}
