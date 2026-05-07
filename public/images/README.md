# Images Folder

Folder ini digunakan untuk menyimpan gambar-gambar yang digunakan di website UMKM Store.

## Hero Background Image

Untuk menggunakan gambar lokal sebagai background hero section:

1. Simpan gambar Anda di folder ini dengan nama `hero-bg.jpg` (atau format lain seperti .png, .webp)
2. Buka file `resources/views/berandautama.blade.php`
3. Cari bagian CSS untuk `.hero`
4. Uncomment (hapus `/*` dan `*/`) pada Option 4 yang menggunakan local image
5. Sesuaikan nama file jika berbeda

### Rekomendasi Gambar:

- **Ukuran**: Minimal 1920x1080px untuk kualitas terbaik
- **Format**: JPG, PNG, atau WebP
- **Tema**: Produk UMKM, pasar tradisional, kerajinan tangan, atau toko
- **Ukuran File**: Maksimal 500KB untuk performa optimal (gunakan tools seperti TinyPNG untuk compress)

### Contoh Nama File:
- `hero-bg.jpg` - Background utama hero section
- `hero-bg-mobile.jpg` - Background untuk mobile (opsional)
- `product-placeholder.jpg` - Placeholder untuk produk

## Sumber Gambar Gratis:

Jika Anda membutuhkan gambar gratis, bisa download dari:
- Unsplash: https://unsplash.com
- Pexels: https://pexels.com
- Pixabay: https://pixabay.com

Keyword pencarian yang disarankan:
- "local market"
- "handcraft"
- "traditional market"
- "small business"
- "artisan products"
- "indonesian market"
