/**
 * UMKM Store - Varian Manager
 */
let varianCount = 1;

function toggleVarianSection() {
    const el = document.getElementById('toggleVarian');
    if (!el) return;
    const checked = el.checked;
    const section = document.getElementById('varianSection');
    if (section) section.style.display = checked ? 'block' : 'none';
}

function addVarian() {
    const idx = varianCount++;
    const tipeEl = document.getElementById('selectedTipe');
    const tipe = tipeEl ? tipeEl.value : '';
    const container = document.getElementById('varianContainer');
    if (!container) return;
    
    const previewId = 'preview-varian-' + idx;

    const row = document.createElement('div');
    row.className = 'varian-row';
    row.id = 'varian-' + idx;
    row.innerHTML = `
        <button type="button" class="btn-remove-varian" onclick="removeVarian(this)" title="Hapus varian">
            <i class="fas fa-times-circle"></i>
        </button>
        <div class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label small fw-semibold">Nama Varian <span class="text-danger">*</span></label>
                <input type="text" name="varian[${idx}][nama_varian]" class="form-control form-control-sm"
                    placeholder="Contoh: Merah, XL, Vanilla">
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-semibold">Tipe</label>
                <input type="text" name="varian[${idx}][tipe_varian]" class="form-control form-control-sm varian-tipe"
                    value="${tipe}" placeholder="Warna / Ukuran">
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-semibold">Harga Tambahan (Rp)</label>
                <input type="number" name="varian[${idx}][harga_tambahan]" class="form-control form-control-sm"
                    min="0" value="0" placeholder="0">
                <small class="text-muted" style="font-size:11px;">0 = harga dasar</small>
            </div>
            <div class="col-md-1">
                <label class="form-label small fw-semibold">Stok</label>
                <input type="number" name="varian[${idx}][stok]" class="form-control form-control-sm"
                    min="0" value="0">
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-semibold">SKU</label>
                <input type="text" name="varian[${idx}][sku]" class="form-control form-control-sm"
                    placeholder="Kode produk">
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-semibold">Gambar Varian</label>
                <input type="file" name="varian[${idx}][gambar]" class="form-control form-control-sm varian-gambar-input"
                    accept="image/*" onchange="previewVarianGambar(this, '${previewId}')">
            </div>
        </div>
        <div id="${previewId}" class="mt-2" style="display:none;">
            <img src="" alt="Preview Varian"
                style="max-height:80px;border-radius:6px;border:1px solid #e2e8f0;object-fit:cover;">
        </div>`;
    container.appendChild(row);
}

function removeVarian(btn) {
    const row = btn.closest('.varian-row');
    if (row) row.remove();
}

function setTipeVarian(tipe, btn) {
    const selTipe = document.getElementById('selectedTipe');
    const custTipe = document.getElementById('customTipe');
    if (selTipe) selTipe.value = tipe;
    if (custTipe) custTipe.value = '';
    
    // highlight button
    document.querySelectorAll('#tipeVarButtons .btn').forEach(b => b.classList.remove('btn-secondary', 'active'));
    if (btn) btn.classList.add('btn-secondary', 'active');
    
    // isi semua field tipe yang sudah ada
    document.querySelectorAll('.varian-tipe').forEach(el => el.value = tipe);
}

function setCustomTipe(val) {
    const selTipe = document.getElementById('selectedTipe');
    if (selTipe) selTipe.value = val;
    document.querySelectorAll('#tipeVarButtons .btn').forEach(b => b.classList.remove('btn-secondary', 'active'));
    document.querySelectorAll('.varian-tipe').forEach(el => el.value = val);
}

// Global init for previews
document.addEventListener('DOMContentLoaded', () => {
    const mainImgInput = document.getElementById('gambarInput');
    if (mainImgInput) {
        mainImgInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = e => {
                    const prev = document.getElementById('previewImg');
                    const container = document.getElementById('gambarPreview');
                    if (prev) prev.src = e.target.result;
                    if (container) container.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    }
});

function previewVarianGambar(input, previewId) {
    const file = input.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        const container = document.getElementById(previewId);
        if (container) {
            const img = container.querySelector('img');
            if (img) img.src = e.target.result;
            container.style.display = 'block';
        }
    };
    reader.readAsDataURL(file);
}
