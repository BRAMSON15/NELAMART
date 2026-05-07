/**
 * UMKM Store - Checkout Logic
 */

/**
 * Toggle between COD and Transfer
 */
function toggleMetode(radio) {
    const infoTransfer = document.getElementById('infoTransfer');
    const labelCod      = document.getElementById('labelCod');
    const labelTransfer = document.getElementById('labelTransfer');

    if (!infoTransfer || !labelCod || !labelTransfer) return;

    if (radio.value === 'transfer') {
        infoTransfer.style.display = 'block';
        labelTransfer.style.borderColor = '#26b99a';
        labelCod.style.borderColor = '#e2e8f0';
    } else {
        infoTransfer.style.display = 'none';
        labelCod.style.borderColor = '#26b99a';
        labelTransfer.style.borderColor = '#e2e8f0';
    }
}

/**
 * Initialize listeners on checkout page
 */
document.addEventListener('DOMContentLoaded', () => {
    // Highlight active on load
    document.querySelectorAll('input[name="metode_pembayaran"]').forEach(r => {
        if (r.checked) toggleMetode(r);
    });

    // Preview bukti transfer
    const buktiInput = document.getElementById('buktiTransfer');
    if (buktiInput) {
        buktiInput.addEventListener('change', function() {
            const file = this.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = e => {
                const prevImg = document.getElementById('imgPreview');
                const prevDiv = document.getElementById('previewBukti');
                if (prevImg) prevImg.src = e.target.result;
                if (prevDiv) prevDiv.style.display = 'block';
            };
            reader.readAsDataURL(file);
        });
    }
});
