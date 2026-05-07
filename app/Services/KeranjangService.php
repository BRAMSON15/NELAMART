<?php

namespace App\Services;

use App\Models\Keranjang;

class KeranjangService
{
    public function getByUser(int $userId)
    {
        return Keranjang::with('produk.toko')
            ->where('user_id', $userId)
            ->get();
    }

    public function tambah(int $userId, int $produkId, int $jumlah): Keranjang
    {
        $keranjang = Keranjang::where('user_id', $userId)
            ->where('produk_id', $produkId)
            ->first();

        if ($keranjang) {
            $keranjang->jumlah += $jumlah;
            $keranjang->save();
        } else {
            $keranjang = Keranjang::create([
                'user_id'   => $userId,
                'produk_id' => $produkId,
                'jumlah'    => $jumlah,
            ]);
        }

        return $keranjang;
    }

    public function update(int $userId, int $keranjangId, int $jumlah): Keranjang
    {
        $keranjang = Keranjang::where('user_id', $userId)->findOrFail($keranjangId);
        $keranjang->update(['jumlah' => $jumlah]);

        return $keranjang;
    }

    public function hapus(int $userId, int $keranjangId): void
    {
        Keranjang::where('user_id', $userId)->findOrFail($keranjangId)->delete();
    }

    public function hitungTotal($keranjangs): int|float
    {
        return $keranjangs->sum(fn($item) => $item->subtotal);
    }
}
