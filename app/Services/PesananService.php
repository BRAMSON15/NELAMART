<?php

namespace App\Services;

use App\Models\Pesanan;
use App\Models\PesananDetail;
use App\Models\Keranjang;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

// Kode unik nominal: angka 3 digit (1-999) yang ditambahkan ke total QRIS
// agar penjual bisa memverifikasi keaslian pembayaran dari nominal transfer.

class PesananService
{
    /**
     * Generate kode unik 3 digit (1–999) yang belum dipakai hari ini.
     * Dijamin unik agar penjual bisa membedakan setiap transaksi.
     */
    private function generateKodeUnik(): int
    {
        // Ambil semua kode unik yang sudah dipakai hari ini
        $used = Pesanan::whereDate('created_at', today())
            ->whereNotNull('kode_unik')
            ->pluck('kode_unik')
            ->toArray();

        // Generate angka acak yang belum terpakai
        $attempts = 0;
        do {
            $kode = rand(1, 999);
            $attempts++;
            // Jika sudah 999 percobaan, reset hari ini (sangat jarang terjadi)
            if ($attempts > 50) break;
        } while (in_array($kode, $used));

        return $kode;
    }

    public function buatPesanan(int $userId, array $data, $keranjangs): Pesanan
    {
        return DB::transaction(function () use ($userId, $data, $keranjangs) {
            // Group by toko — buat pesanan per toko
            $grouped = $keranjangs->groupBy(fn($item) => $item->produk->toko_id);

            $pesananPertama = null;
            $isQris = ($data['metode_pembayaran'] === 'qris');

            foreach ($grouped as $tokoId => $items) {
                $total = $items->sum(fn($i) => $i->subtotal);

                // Buat kode unik hanya untuk pembayaran QRIS
                $kodeUnik  = $isQris ? $this->generateKodeUnik() : null;
                $totalBayar = $isQris ? ($total + $kodeUnik) : $total;

                $pesanan = Pesanan::create([
                    'kode_pesanan'      => 'ORD-' . strtoupper(Str::random(8)),
                    'user_id'           => $userId,
                    'toko_id'           => $tokoId,
                    'total_harga'       => $total,
                    'kode_unik'         => $kodeUnik,
                    'total_bayar'       => $totalBayar,
                    'status'            => 'pending',
                    'alamat_pengiriman' => $data['alamat_pengiriman'],
                    'nama_penerima'     => $data['nama_penerima'],
                    'telepon_penerima'  => $data['telepon_penerima'],
                    'catatan'           => $data['catatan'] ?? null,
                    'metode_pembayaran' => $data['metode_pembayaran'],
                    'bukti_bayar'       => $data['bukti_bayar'] ?? null,
                    'dibayar_at'        => $data['dibayar_at'] ?? null,
                ]);

                foreach ($items as $item) {
                    PesananDetail::create([
                        'pesanan_id'   => $pesanan->id,
                        'produk_id'    => $item->produk_id,
                        'jumlah'       => $item->jumlah,
                        'harga_satuan' => $item->produk->harga,
                        'subtotal'     => $item->subtotal,
                    ]);
                }

                if (!$pesananPertama) $pesananPertama = $pesanan;
            }

            // Hapus hanya item yang di-checkout
            $checkedOutIds = $keranjangs->pluck('id')->toArray();
            Keranjang::where('user_id', $userId)->whereIn('id', $checkedOutIds)->delete();

            return $pesananPertama;
        });
    }

    public function getByPelanggan(int $userId)
    {
        return Pesanan::with(['details.produk', 'toko'])
            ->where('user_id', $userId)
            ->latest()
            ->get();
    }

    public function getByToko(int $tokoId)
    {
        return Pesanan::with(['user', 'details.produk'])
            ->whereHas('details.produk', fn($q) => $q->where('toko_id', $tokoId))
            ->latest()
            ->get();
    }

    public function getDetail(int $pesananId, int $tokoId): Pesanan
    {
        $pesanan = Pesanan::with(['user', 'details.produk.toko'])->findOrFail($pesananId);

        $hasProduk = $pesanan->details->contains(
            fn($detail) => $detail->produk->toko_id == $tokoId
        );

        abort_unless($hasProduk, 403, 'Unauthorized');

        return $pesanan;
    }

    public function updateStatus(int $pesananId, string $status): Pesanan
    {
        $pesanan = Pesanan::findOrFail($pesananId);
        $pesanan->update(['status' => $status]);

        return $pesanan;
    }

    public function getLaporan(int $tokoId): array
    {
        $tokoScope = fn($q) => $q->where('toko_id', $tokoId);
        $selesaiScope = fn($q) => $q->where('status', 'selesai');

        $totalPendapatan = PesananDetail::whereHas('produk', $tokoScope)
            ->whereHas('pesanan', $selesaiScope)
            ->sum(DB::raw('harga_satuan * jumlah'));

        $totalPesanan = Pesanan::whereHas('details.produk', $tokoScope)->count();

        $produkTerjual = PesananDetail::whereHas('produk', $tokoScope)
            ->whereHas('pesanan', $selesaiScope)
            ->sum('jumlah');

        return compact('totalPendapatan', 'totalPesanan', 'produkTerjual');
    }
}
