<?php

namespace App\Http\Controllers;

use App\Services\ProdukService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProdukController extends Controller
{
    public function __construct(protected ProdukService $produkService) {}

    public function index()
    {
        $toko = Auth::user()->toko;
        if (!$toko) {
            return redirect()->route('user.toko.create')->with('error', 'Silakan daftarkan toko terlebih dahulu');
        }

        $produks = $this->produkService->getByToko($toko->id);
        return view('User.daftar-produk', compact('produks'));
    }

    public function create()
    {
        if (!Auth::user()->toko) {
            return redirect()->route('user.toko.create')->with('error', 'Silakan daftarkan toko terlebih dahulu');
        }
        return view('User.tambah-produk');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk'             => 'required|string|max:255',
            'deskripsi'               => 'required|string',
            'harga'                   => 'required|numeric|min:0',
            'stok'                    => 'required|integer|min:0',
            'kategori'                => 'required|string',
            'gambar'                  => 'nullable|image|max:10240',
            'varian.*.nama_varian'    => 'nullable|string|max:100',
            'varian.*.tipe_varian'    => 'nullable|string|max:100',
            'varian.*.harga_tambahan' => 'nullable|numeric|min:0',
            'varian.*.stok'           => 'nullable|integer|min:0',
            'varian.*.sku'            => 'nullable|string|max:100',
            'varian.*.gambar'         => 'nullable|image|max:10240',
        ]);

        $this->produkService->store($request, Auth::user()->toko->id);

        return redirect()->route('user.produk.index')->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit($id)
    {
        $produk = Auth::user()->toko->produks()->findOrFail($id);
        return view('User.edit-produk', compact('produk'));
    }

    public function update(Request $request, $id)
    {
        $produk = Auth::user()->toko->produks()->findOrFail($id);

        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'deskripsi'   => 'required|string',
            'harga'       => 'required|numeric|min:0',
            'stok'        => 'required|integer|min:0',
            'kategori'    => 'required|string',
            'gambar'      => 'nullable|image|max:10240',
        ]);

        $this->produkService->update($request, $produk);

        return redirect()->route('user.produk.index')->with('success', 'Produk berhasil diupdate');
    }

    public function destroy($id)
    {
        $produk = Auth::user()->toko->produks()->findOrFail($id);
        $this->produkService->destroy($produk);

        return redirect()->route('user.produk.index')->with('success', 'Produk berhasil dihapus');
    }
}
