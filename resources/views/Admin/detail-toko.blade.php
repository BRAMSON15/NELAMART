<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Detail Toko - NELA MART</title>
    <link href="{{asset('mentahan1/css/styles.css')}}" rel="stylesheet" />
    <link href="{{asset('css/admin-dashboard.css')}}?v={{ time() }}" rel="stylesheet" />
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
                        <div class="sb-sidenav-menu-heading">Menu Utama</div>
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        
                        <div class="sb-sidenav-menu-heading">Manajemen</div>
                        <a class="nav-link active" href="{{ route('admin.kelola-toko') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-store"></i></div>
                            Kelola Toko
                        </a>
                        <a class="nav-link" href="{{ route('admin.kelola-user') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                            Kelola User
                        </a>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Detail Toko</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.kelola-toko') }}">Kelola Toko</a></li>
                        <li class="breadcrumb-item active">Detail Toko</li>
                    </ol>

                    <div class="row">
                        <div class="col-xl-8">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-store me-1"></i>
                                    Informasi Toko
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th width="200">Nama Toko</th>
                                            <td>{{ $toko->nama_toko }}</td>
                                        </tr>
                                        <tr>
                                            <th>Pemilik</th>
                                            <td>{{ $toko->user->name }} ({{ $toko->user->email }})</td>
                                        </tr>
                                        <tr>
                                            <th>Deskripsi</th>
                                            <td>{{ $toko->deskripsi ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Alamat</th>
                                            <td>{{ $toko->alamat }}</td>
                                        </tr>
                                        <tr>
                                            <th>Telepon</th>
                                            <td>{{ $toko->telepon }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td>
                                                @if($toko->status == 'pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @elseif($toko->status == 'aktif')
                                                    <span class="badge bg-success">Aktif</span>
                                                @else
                                                    <span class="badge bg-danger">Ditolak</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Daftar</th>
                                            <td>{{ $toko->created_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Terakhir Update</th>
                                            <td>{{ $toko->updated_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-wallet me-1"></i>
                                    Informasi Pembayaran
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th width="200">Metode Pembayaran</th>
                                            <td><span class="badge bg-primary">{{ strtoupper($toko->tipe_pembayaran) }}</span></td>
                                        </tr>
                                        @if($toko->tipe_pembayaran == 'bank' || $toko->tipe_pembayaran == 'keduanya')
                                        <tr>
                                            <th>Bank</th>
                                            <td>{{ $toko->nama_bank }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nomor Rekening</th>
                                            <td>{{ $toko->nomor_rekening }}</td>
                                        </tr>
                                        <tr>
                                            <th>Pemilik Rekening</th>
                                            <td>{{ $toko->nama_pemilik_rekening }}</td>
                                        </tr>
                                        @endif
                                        @if($toko->tipe_pembayaran == 'ewallet')
                                        <tr>
                                            <th>E-Wallet</th>
                                            <td>{{ $toko->nama_ewallet }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nomor E-Wallet</th>
                                            <td>{{ $toko->nomor_ewallet }}</td>
                                        </tr>
                                        <tr>
                                            <th>Pemilik E-Wallet</th>
                                            <td>{{ $toko->nama_pemilik_ewallet }}</td>
                                        </tr>
                                        @if($toko->gambar_ewallet_qr)
                                        <tr>
                                            <th>QR Code E-Wallet</th>
                                            <td>
                                                <img src="{{ Storage::url($toko->gambar_ewallet_qr) }}" 
                                                     alt="QR E-Wallet" style="max-height: 200px; border-radius: 8px;">
                                            </td>
                                        </tr>
                                        @endif
                                        @endif
                                        @if($toko->tipe_pembayaran == 'qris' || $toko->tipe_pembayaran == 'keduanya')
                                        <tr>
                                            <th>Gambar QRIS</th>
                                            <td>
                                                @if($toko->gambar_qris)
                                                    <img src="{{ Storage::url($toko->gambar_qris) }}" alt="QRIS" style="max-height: 200px; border-radius: 8px;">
                                                @else
                                                    <span class="text-danger">Belum diupload</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-cog me-1"></i>
                                    Aksi
                                </div>
                                <div class="card-body">
                                    @if($toko->status == 'pending')
                                        <form action="{{ route('admin.toko.approve', $toko->id) }}" method="POST" class="mb-2">
                                            @csrf
                                            <button type="submit" class="btn btn-success w-100" onclick="return confirm('Setujui toko ini?')">
                                                <i class="fas fa-check"></i> Setujui Toko
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.toko.reject', $toko->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Tolak toko ini?')">
                                                <i class="fas fa-times"></i> Tolak Toko
                                            </button>
                                        </form>
                                    @elseif($toko->status == 'aktif')
                                        <form action="{{ route('admin.toko.reject', $toko->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-warning w-100" onclick="return confirm('Nonaktifkan toko ini?')">
                                                <i class="fas fa-ban"></i> Nonaktifkan Toko
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.toko.approve', $toko->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success w-100" onclick="return confirm('Aktifkan toko ini?')">
                                                <i class="fas fa-check"></i> Aktifkan Toko
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <hr>
                                    
                                    <a href="{{ route('admin.kelola-toko') }}" class="btn btn-secondary w-100">
                                        <i class="fas fa-arrow-left"></i> Kembali
                                    </a>
                                </div>
                            </div>

                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-bar me-1"></i>
                                    Statistik Toko
                                </div>
                                <div class="card-body">
                                    <p class="mb-2">
                                        <strong>Total Produk:</strong> 
                                        {{ $toko->produks->count() }}
                                    </p>
                                    <p class="mb-2">
                                        <strong>Produk Aktif:</strong> 
                                        {{ $toko->produks->where('status', 'tersedia')->count() }}
                                    </p>
                                    <p class="mb-0">
                                        <strong>Total Pesanan:</strong> 
                                        {{ \App\Models\Pesanan::where('toko_id', $toko->id)->count() }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('mentahan1/js/scripts.js')}}"></script>
</body>
</html>

