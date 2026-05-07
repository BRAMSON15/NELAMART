<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Detail Pesanan - NELA MART</title>
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
                        <a class="nav-link active" href="{{ route('user.pesanan.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart"></i></div>
                            Daftar Pesanan
                        </a>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Detail Pesanan #{{ $pesanan->id }}</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('user.pesanan.index') }}">Daftar Pesanan</a></li>
                        <li class="breadcrumb-item active">Detail Pesanan</li>
                    </ol>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="row">
                        <div class="col-md-8">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-shopping-bag me-1"></i>
                                    Item Pesanan
                                </div>
                                <div class="card-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Produk</th>
                                                <th>Harga</th>
                                                <th>Jumlah</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pesanan->details as $detail)
                                            <tr>
                                                <td>{{ $detail->produk->nama_produk }}</td>
                                                <td>Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                                                <td>{{ $detail->jumlah }}</td>
                                                <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="3" class="text-end">Total:</th>
                                                <th>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Informasi Pesanan
                                </div>
                                <div class="card-body">
                                    <p><strong>Pelanggan:</strong> {{ $pesanan->user->name }}</p>
                                    <p><strong>Tanggal:</strong> {{ $pesanan->created_at->format('d F Y, H:i') }}</p>
                                    <p><strong>Metode:</strong>
                                        @if($pesanan->metode_pembayaran === 'cod')
                                            <span class="badge bg-success">COD</span>
                                        @else
                                            <span class="badge bg-dark">QRIS</span>
                                        @endif
                                    </p>
                                    <p><strong>Status:</strong>
                                        @if($pesanan->status == 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($pesanan->status == 'diproses')
                                            <span class="badge bg-info">Diproses</span>
                                        @elseif($pesanan->status == 'selesai')
                                            <span class="badge bg-success">Selesai</span>
                                        @else
                                            <span class="badge bg-danger">Dibatalkan</span>
                                        @endif
                                    </p>

                                    {{-- Panel Verifikasi Kode Unik --}}
                                    @if($pesanan->metode_pembayaran === 'qris' && $pesanan->kode_unik)
                                    <div class="p-3 rounded-3 mb-3"
                                        style="background:linear-gradient(135deg,#ecfdf5,#f0fdf4);border:2px solid #86efac;">
                                        <div style="font-size:11px;font-weight:700;color:#166534;text-transform:uppercase;letter-spacing:.5px;margin-bottom:6px;">
                                            <i class="fas fa-shield-alt me-1"></i> Verifikasi Pembayaran QRIS
                                        </div>
                                        <div style="font-size:12px;color:#4b7c59;margin-bottom:8px;">
                                            Pelanggan wajib transfer dengan nominal <strong>tepat</strong> berikut:
                                        </div>
                                        <div class="text-center py-2" style="background:white;border-radius:8px;border:1px solid #86efac;">
                                            <div style="font-size:11px;color:#888;">Nominal Transfer</div>
                                            <div style="font-size:24px;font-weight:800;color:#15803d;">
                                                Rp {{ number_format($pesanan->total_bayar, 0, ',', '.') }}
                                            </div>
                                            <div style="font-size:11px;color:#888;">
                                                (Subtotal Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                                                + kode <strong style="color:#15803d;">+{{ $pesanan->kode_unik }}</strong>)
                                            </div>
                                        </div>
                                        <div class="mt-2" style="font-size:11px;color:#444;">
                                            <i class="fas fa-lightbulb text-warning me-1"></i>
                                            Cek riwayat transfer: pastikan nominal yang masuk adalah
                                            <strong>Rp {{ number_format($pesanan->total_bayar, 0, ',', '.') }}</strong>.
                                            Jika berbeda, kemungkinan bukti dipalsukan.
                                        </div>
                                    </div>
                                    @endif

                                    @if($pesanan->bukti_bayar)
                                    <div class="mb-3">
                                        <p class="mb-1"><strong>Bukti Pembayaran:</strong></p>
                                        <img src="{{ Storage::url($pesanan->bukti_bayar) }}"
                                            alt="Bukti Bayar"
                                            style="max-width:100%;border-radius:8px;border:1px solid #dee2e6;cursor:pointer;"
                                            onclick="window.open(this.src,'_blank')">
                                        <div style="font-size:11px;color:#888;margin-top:4px;">
                                            <i class="fas fa-search-plus me-1"></i> Klik gambar untuk memperbesar
                                        </div>
                                    </div>
                                    @endif

                                    <hr>
                                    
                                    <form method="POST" action="{{ route('user.pesanan.updateStatus', $pesanan->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-3">
                                            <label class="form-label">Update Status</label>
                                            <select name="status" class="form-control">
                                                <option value="pending" {{ $pesanan->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="diproses" {{ $pesanan->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                                <option value="dikirim" {{ $pesanan->status == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                                                <option value="selesai" {{ $pesanan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                                <option value="dibatalkan" {{ $pesanan->status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100">Update Status</button>
                                    </form>
                                    
                                    @if($pesanan->status === 'dikirim')
                                        <hr>
                                        <a href="{{ route('kurir.tracking', $pesanan->id) }}" class="btn btn-success w-100">
                                            <i class="fas fa-motorcycle me-2"></i>
                                            Update Lokasi Kurir
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('user.pesanan.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('mentahan1/js/scripts.js')}}"></script>
</body>
</html>

