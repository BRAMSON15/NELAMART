<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Pesanan;
use App\Services\KeranjangService;
use App\Services\PesananService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    public function __construct(
        protected KeranjangService $keranjangService,
        protected PesananService $pesananService,
    ) {}

    public function index()
    {
        $keranjangs = $this->keranjangService->getByUser(Auth::id());
        $total = $this->keranjangService->hitungTotal($keranjangs);
        return view('Pelanggan.keranjang', compact('keranjangs', 'total'));
    }

    public function tambah(Request $request)
    {
        
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'jumlah'    => 'required|integer|min:1',
        ]);

        $this->keranjangService->tambah(Auth::id(), $request->produk_id, $request->jumlah);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Produk berhasil ditambahkan ke keranjang']);
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang');
    }

    public function update(Request $request, $id)
    {
        $request->validate(['jumlah' => 'required|integer|min:1']);
        $this->keranjangService->update(Auth::id(), $id, $request->jumlah);
        return redirect()->back()->with('success', 'Keranjang berhasil diupdate');
    }

    public function hapus($id)
    {
        $this->keranjangService->hapus(Auth::id(), $id);
        return redirect()->back()->with('success', 'Item berhasil dihapus dari keranjang');
    }

    public function detailProduk($id)
    {
        $produk = Produk::with(['toko', 'varians', 'ulasans.user'])->findOrFail($id);
        $sudahDiulas = $produk->ulasans()->where('user_id', Auth::id())->exists();
        return view('Pelanggan.detail-produk', compact('produk', 'sudahDiulas'));
    }

    public function beliSekarang(Request $request, $id)
    {
        $request->validate(['jumlah' => 'required|integer|min:1']);
        $this->keranjangService->tambah(Auth::id(), $id, $request->jumlah);
        return redirect()->route('keranjang.index')->with('success', 'Produk ditambahkan. Silakan lanjutkan checkout.');
    }

    public function checkout(Request $request)
    {
        $selectedIds = $request->input('selected_ids', []);
        $keranjangs  = $this->keranjangService->getByUser(Auth::id());

        if ($keranjangs->isEmpty()) {
            return redirect()->route('keranjang.index')->with('error', 'Keranjang Anda kosong.');
        }

        if (!empty($selectedIds)) {
            $keranjangs = $keranjangs->whereIn('id', $selectedIds)->values();
        }

        if ($keranjangs->isEmpty()) {
            return redirect()->route('keranjang.index')->with('error', 'Pilih minimal satu produk untuk checkout.');
        }

        $total = $this->keranjangService->hitungTotal($keranjangs);
        $user  = Auth::user();
        
        // Cek apakah ada toko yang menggunakan RajaOngkir
        $tokosList = $keranjangs->map(fn($i) => $i->produk->toko)->unique('id')->values();
        $gunakanRajaongkir = $tokosList->contains(fn($t) => $t->gunakan_rajaongkir);
        $tokoRajaongkir = $tokosList->firstWhere('gunakan_rajaongkir', true);

        return view('Pelanggan.checkout', compact('keranjangs', 'total', 'user', 'selectedIds', 'gunakanRajaongkir', 'tokoRajaongkir'));
    }
//ini untuk checkout 
    public function prosesCheckout(Request $request)
    {
        $request->validate([
            'nama_penerima'     => 'required|string|max:100',
            'telepon_penerima'  => 'required|string|max:20',
            'alamat_pengiriman' => 'required|string',
            'metode_pembayaran' => 'required|in:cod,qris',
            // Bukti bayar TIDAK diwajibkan saat checkout.
            // Pelanggan mendapat kode unik SETELAH pesanan dibuat,
            // lalu upload bukti di halaman detail pesanan.
            'catatan'           => 'nullable|string|max:255',
            'selected_ids'      => 'required|array|min:1',
            'selected_ids.*'    => 'integer|exists:keranjangs,id',
        ]);

        $selectedIds   = $request->input('selected_ids', []);
        $allKeranjangs = $this->keranjangService->getByUser(Auth::id());
        $keranjangs    = $allKeranjangs->whereIn('id', $selectedIds)->values();

        if ($keranjangs->isEmpty()) {
            return redirect()->route('keranjang.index')->with('error', 'Pilih minimal satu produk untuk checkout.');
        }

        $data = $request->only(['nama_penerima', 'telepon_penerima', 'alamat_pengiriman', 'metode_pembayaran', 'catatan']);

        $pesanan = $this->pesananService->buatPesanan(Auth::id(), $data, $keranjangs);

        return redirect()->route('pelanggan.pesanan.detail', $pesanan->id)
            ->with('success', 'Pesanan berhasil dibuat! Kode: ' . $pesanan->kode_pesanan);
    }

    public function uploadBuktiBayar(Request $request, $id)
    {
        $pesanan = \App\Models\Pesanan::where('user_id', Auth::id())->findOrFail($id);

        // Pastikan pesanan memang QRIS dan belum ada bukti bayar
        if ($pesanan->metode_pembayaran !== 'qris') {
            return redirect()->back()->with('error', 'Upload bukti hanya untuk pembayaran QRIS.');
        }

        $request->validate([
            'bukti_bayar' => 'required|image|max:5120',
        ]);

        $pesanan->update([
            'bukti_bayar' => $request->file('bukti_bayar')->store('bukti_bayar', 'public'),
            'dibayar_at'  => now(),
        ]);

        return redirect()->route('pelanggan.pesanan.detail', $pesanan->id)
            ->with('success', 'Bukti pembayaran berhasil diupload! Menunggu konfirmasi penjual.');
    }

    public function detailPesanan($id)
    {
        $pesanan = Pesanan::with(['details.produk.toko', 'toko'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('Pelanggan.detail-pesanan', compact('pesanan'));
    }
}
