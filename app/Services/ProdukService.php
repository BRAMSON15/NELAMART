<?php

namespace App\Services;

use App\Models\Produk;
use App\Models\ProdukVarian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukService
{
    public function getByToko(int $tokoId)
    {
        return Produk::where('toko_id', $tokoId)->latest()->get();
    }

    public function store(Request $request, int $tokoId): Produk
    {
        $data = [
            'toko_id'     => $tokoId,
            'nama_produk' => $request->nama_produk,
            'deskripsi'   => $request->deskripsi,
            'harga'       => $request->harga,
            'stok'        => $request->stok,
            'kategori'    => $request->kategori,
        ];

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('produk', 'public');
        }

        $produk = Produk::create($data);

        if ($request->has('varian')) {
            foreach ($request->varian as $idx => $v) {
                if (!empty($v['nama_varian'])) {
                    $gambarVarian = null;
                    if ($request->hasFile("varian.$idx.gambar")) {
                        $gambarVarian = $request->file("varian.$idx.gambar")->store('varian', 'public');
                    }
                    ProdukVarian::create([
                        'produk_id'      => $produk->id,
                        'nama_varian'    => $v['nama_varian'],
                        'tipe_varian'    => $v['tipe_varian'] ?? null,
                        'harga_tambahan' => $v['harga_tambahan'] ?? 0,
                        'stok'           => $v['stok'] ?? 0,
                        'sku'            => $v['sku'] ?? null,
                        'gambar'         => $gambarVarian,
                    ]);
                }
            }
        }

        return $produk;
    }

    public function update(Request $request, Produk $produk): Produk
    {
        $data = [
            'nama_produk' => $request->nama_produk,
            'deskripsi'   => $request->deskripsi,
            'harga'       => $request->harga,
            'stok'        => $request->stok,
            'kategori'    => $request->kategori,
        ];

        if ($request->hasFile('gambar')) {
            if ($produk->gambar) {
                Storage::disk('public')->delete($produk->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('produk', 'public');
        }

        $produk->update($data);

        return $produk;
    }

    public function destroy(Produk $produk): void
    {
        if ($produk->gambar) {
            Storage::disk('public')->delete($produk->gambar);
        }

        $produk->delete();
    }
}
