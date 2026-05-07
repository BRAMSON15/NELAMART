<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Edit Produk - NELA MART</title>
    <link href="{{asset('mentahan1/css/styles.css')}}" rel="stylesheet" />
    <link href="{{asset('css/user-dashboard.css')}}?v={{ time() }}" rel="stylesheet" />
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
                        <a class="nav-link active" href="{{ route('user.produk.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-box"></i></div>
                            Daftar Produk
                        </a>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Edit Produk</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('user.produk.index') }}">Daftar Produk</a></li>
                        <li class="breadcrumb-item active">Edit Produk</li>
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

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-edit me-1"></i>
                            Form Edit Produk
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('user.produk.update', $produk->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Nama Produk</label>
                                            <input type="text" name="nama_produk" class="form-control" value="{{ $produk->nama_produk }}" required>
                                            @error('nama_produk')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Kategori</label>
                                            <select name="kategori" class="form-control" required>
                                                <option value="Makanan" {{ $produk->kategori == 'Makanan' ? 'selected' : '' }}>Makanan</option>
                                                <option value="Minuman" {{ $produk->kategori == 'Minuman' ? 'selected' : '' }}>Minuman</option>
                                                <option value="Fashion" {{ $produk->kategori == 'Fashion' ? 'selected' : '' }}>Fashion</option>
                                                <option value="Kerajinan" {{ $produk->kategori == 'Kerajinan' ? 'selected' : '' }}>Kerajinan</option>
                                                <option value="Elektronik" {{ $produk->kategori == 'Elektronik' ? 'selected' : '' }}>Elektronik</option>
                                                <option value="Lainnya" {{ $produk->kategori == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea name="deskripsi" class="form-control" rows="4" required>{{ $produk->deskripsi }}</textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Harga (Rp)</label>
                                            <input type="number" name="harga" class="form-control" value="{{ $produk->harga }}" min="0" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Stok</label>
                                            <input type="number" name="stok" class="form-control" value="{{ $produk->stok }}" min="0" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Gambar Produk</label>
                                    <div class="mb-2" id="gambarPreview" style="{{ $produk->gambar ? '' : 'display: none;' }}">
                                        <img id="previewImg" src="{{ $produk->gambar ? Storage::url($produk->gambar) : '#' }}" alt="{{ $produk->nama_produk }}" style="max-width: 200px; border-radius: 8px; border: 1px solid #e2e8f0;">
                                    </div>
                                    <input type="file" name="gambar" class="form-control" id="gambarInput" accept="image/*" onchange="previewImage(event)">
                                    @error('gambar')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                    <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar. Format: Semua tipe gambar. Maks: 10MB.</small>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('user.produk.index') }}" class="btn btn-secondary">Kembali</a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Update Produk
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('mentahan1/js/scripts.js')}}"></script>
    <script>
        function previewImage(event) {
            var input = event.target;
            var reader = new FileReader();
            reader.onload = function(){
                var dataURL = reader.result;
                var output = document.getElementById('previewImg');
                var container = document.getElementById('gambarPreview');
                output.src = dataURL;
                container.style.display = 'block';
            };
            if(input.files && input.files[0]) {
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>

