<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Tambah Produk - NELA MART</title>
    <link href="{{ asset('mentahan1/css/styles.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/user-dashboard.css') }}?v={{ time() }}" rel="stylesheet" />
    <link href="{{ asset('css/tambahproduk.css')}}" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="/">NELA MART</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle"><i class="fas fa-bars"></i></button>
        <ul class="navbar-nav ms-auto me-3">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="fas fa-user fa-fw"></i> {{ Auth::user()->name }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">Logout</button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <a class="nav-link" href="{{ route('user.dashboard') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <a class="nav-link" href="{{ route('user.toko.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-store"></i></div>
                            Data Toko
                        </a>
                        <a class="nav-link" href="{{ route('user.produk.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-box"></i></div>
                            Daftar Produk
                        </a>
                        <a class="nav-link active" href="{{ route('user.produk.create') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-plus-circle"></i></div>
                            Tambah Produk
                        </a>
                    </div>
                </div>
            </nav>
        </div>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Tambah Produk</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('user.produk.index') }}">Daftar Produk</a></li>
                        <li class="breadcrumb-item active">Tambah Produk</li>
                    </ol>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('user.produk.store') }}" enctype="multipart/form-data">
                        @csrf

                        {{-- ===== INFO DASAR ===== --}}
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-info-circle me-1"></i> Informasi Dasar Produk
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Nama Produk <span class="text-danger">*</span></label>
                                            <input type="text" name="nama_produk" class="form-control" value="{{ old('nama_produk') }}" required placeholder="Contoh: Tas Rajut Handmade">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                                            <select name="kategori" class="form-control" required>
                                                <option value="">-- Pilih Kategori --</option>
                                                @foreach(['Makanan','Minuman','Fashion','Kerajinan','Elektronik','Lainnya'] as $kat)
                                                    <option value="{{ $kat }}" {{ old('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Deskripsi <span class="text-danger">*</span></label>
                                    <textarea name="deskripsi" class="form-control" rows="4" required placeholder="Jelaskan detail produk, bahan, ukuran, dll.">{{ old('deskripsi') }}</textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Harga Dasar (Rp) <span class="text-danger">*</span></label>
                                            <input type="number" name="harga" class="form-control" min="0" value="{{ old('harga') }}" required placeholder="50000">
                                            <small class="text-muted">Harga utama / harga terendah</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Stok Dasar <span class="text-danger">*</span></label>
                                            <input type="number" name="stok" class="form-control" min="0" value="{{ old('stok', 0) }}" required placeholder="0">
                                            <small class="text-muted">Stok jika tidak ada varian</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Gambar Produk</label>
                                            <input type="file" name="gambar" class="form-control" accept="image/*" id="gambarInput">
                                            <small class="text-muted">Semua tipe gambar. Max: 10MB</small>
                                        </div>
                                    </div>
                                </div>

                                {{-- Preview gambar --}}
                                <div id="gambarPreview" style="display:none;margin-top:8px;">
                                    <img id="previewImg" src="" alt="Preview" style="max-height:160px;border-radius:8px;border:1px solid #e2e8f0;">
                                </div>
                            </div>
                        </div>

                        {{-- ===== VARIAN PRODUK ===== --}}
                        <div class="card mb-4">
                            <div class="card-header">
                                <div class="d-flex align-items-center justify-content-between">
                                    <span><i class="fas fa-tags me-1"></i> Varian Produk</span>
                                    <label class="toggle-varian-label mb-0">
                                        <input type="checkbox" id="toggleVarian" onchange="toggleVarianSection()">
                                        Aktifkan Varian
                                    </label>
                                </div>
                            </div>
                            <div class="card-body" id="varianSection" style="display:none;">
                                <p class="text-muted small mb-3">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Tambahkan varian seperti ukuran, warna, atau rasa. Harga tambahan dihitung dari harga dasar.
                                </p>

                                {{-- Tipe Varian --}}
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Tipe Varian</label>
                                    <div class="d-flex gap-2 flex-wrap" id="tipeVarButtons">
                                        @foreach(['Ukuran','Warna','Rasa','Bahan','Model'] as $tipe)
                                        <button type="button" class="btn btn-outline-secondary btn-sm"
                                            onclick="setTipeVarian('{{ $tipe }}', this)">{{ $tipe }}</button>
                                        @endforeach
                                        <input type="text" id="customTipe" class="form-control form-control-sm"
                                            style="width:140px;" placeholder="Tipe lainnya..."
                                            oninput="setCustomTipe(this.value)">
                                    </div>
                                    <input type="hidden" id="selectedTipe" value="">
                                </div>

                                <hr class="section-divider">

                                <div id="varianContainer">
                                    {{-- Row varian pertama --}}
                                    <div class="varian-row" id="varian-0">
                                        <button type="button" class="btn-remove-varian" onclick="removeVarian(this)" title="Hapus varian">
                                            <i class="fas fa-times-circle"></i>
                                        </button>
                                        <div class="row g-2 align-items-end">
                                            <div class="col-md-3">
                                                <label class="form-label small fw-semibold">Nama Varian <span class="text-danger">*</span></label>
                                                <input type="text" name="varian[0][nama_varian]" class="form-control form-control-sm"
                                                    placeholder="Contoh: Merah, XL, Vanilla">
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label small fw-semibold">Tipe</label>
                                                <input type="text" name="varian[0][tipe_varian]" class="form-control form-control-sm varian-tipe"
                                                    placeholder="Warna / Ukuran">
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label small fw-semibold">Harga Tambahan (Rp)</label>
                                                <input type="number" name="varian[0][harga_tambahan]" class="form-control form-control-sm"
                                                    min="0" value="0" placeholder="0">
                                                <small class="text-muted" style="font-size:11px;">0 = harga dasar</small>
                                            </div>
                                            <div class="col-md-1">
                                                <label class="form-label small fw-semibold">Stok</label>
                                                <input type="number" name="varian[0][stok]" class="form-control form-control-sm"
                                                    min="0" value="0">
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label small fw-semibold">SKU</label>
                                                <input type="text" name="varian[0][sku]" class="form-control form-control-sm"
                                                    placeholder="Kode produk">
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label small fw-semibold">Gambar Varian</label>
                                                <input type="file" name="varian[0][gambar]" class="form-control form-control-sm varian-gambar-input"
                                                    accept="image/*" onchange="previewVarianGambar(this, 'preview-varian-0')">
                                            </div>
                                        </div>
                                        {{-- Preview gambar varian --}}
                                        <div id="preview-varian-0" class="mt-2" style="display:none;">
                                            <img src="" alt="Preview Varian"
                                                style="max-height:80px;border-radius:6px;border:1px solid #e2e8f0;object-fit:cover;">
                                        </div>
                                    </div>
                                </div>

                                <button type="button" class="btn btn-outline-primary btn-sm mt-2" onclick="addVarian()">
                                    <i class="fas fa-plus me-1"></i> Tambah Varian
                                </button>
                            </div>
                        </div>

                        {{-- ===== TOMBOL SUBMIT ===== --}}
                        <div class="d-flex justify-content-between mb-5">
                            <a href="{{ route('user.produk.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary px-5">
                                <i class="fas fa-save me-1"></i> Simpan Produk
                            </button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('mentahan1/js/scripts.js') }}"></script>
    <script src="{{ asset('js/varian-manager.js') }}"></script>
</body>
</html>

