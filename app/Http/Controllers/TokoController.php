<?php

namespace App\Http\Controllers;

use App\Services\TokoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TokoController extends Controller
{
    public function __construct(protected TokoService $tokoService) {}

    public function index()
    {
        $toko = Auth::user()->toko;
        return view('User.data-toko', compact('toko'));
    }

    public function create()
    {
        if (Auth::user()->toko) {
            return redirect()->route('user.toko.index')->with('error', 'Anda sudah memiliki toko');
        }
        return view('User.daftar-toko');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_toko' => 'required|string|max:255',
            'alamat'    => 'required|string',
            'telepon'   => 'required|string|max:20',
            'deskripsi' => 'nullable|string',
            'gunakan_rajaongkir' => 'nullable|boolean',
            'kota_asal_id' => 'required_if:gunakan_rajaongkir,1|nullable|string',
            'kota_asal_nama' => 'required_if:gunakan_rajaongkir,1|nullable|string',
        ]);

        $data = $request->only('nama_toko', 'alamat', 'telepon', 'deskripsi');
        $data['gunakan_rajaongkir'] = $request->has('gunakan_rajaongkir') ? true : false;
        $data['kota_asal_id'] = $request->kota_asal_id;
        $data['kota_asal_nama'] = $request->kota_asal_nama;

        $this->tokoService->store(Auth::id(), $data);

        return redirect()->route('user.dashboard')->with('success', 'Toko berhasil didaftarkan. Menunggu verifikasi admin.');
    }

    public function edit()
    {
        $toko = Auth::user()->toko;
        if (!$toko) {
            return redirect()->route('user.toko.create');
        }
        return view('User.edit-toko', compact('toko'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_toko'              => 'required|string|max:255',
            'alamat'                 => 'required|string',
            'telepon'                => 'required|string|max:20',
            'deskripsi'              => 'nullable|string',
            'tipe_pembayaran'        => 'required|in:bank,ewallet,qris,keduanya',
            'nama_bank'              => 'nullable|required_if:tipe_pembayaran,bank|required_if:tipe_pembayaran,keduanya|string|max:50',
            'nomor_rekening'         => 'nullable|required_if:tipe_pembayaran,bank|required_if:tipe_pembayaran,keduanya|string|max:30',
            'nama_pemilik_rekening'  => 'nullable|required_if:tipe_pembayaran,bank|required_if:tipe_pembayaran,keduanya|string|max:100',
            'nama_ewallet'           => 'nullable|required_if:tipe_pembayaran,ewallet|string|max:50',
            'nomor_ewallet'          => 'nullable|required_if:tipe_pembayaran,ewallet|string|max:50',
            'nama_pemilik_ewallet'   => 'nullable|required_if:tipe_pembayaran,ewallet|string|max:100',
            'gambar_ewallet_qr'      => 'nullable|image|max:2048',
            'gambar_qris'            => 'nullable|image|max:2048',
            'gunakan_rajaongkir'     => 'nullable|boolean',
            'kota_asal_id'           => 'required_if:gunakan_rajaongkir,1|nullable|string',
            'kota_asal_nama'         => 'required_if:gunakan_rajaongkir,1|nullable|string',
        ]);

        $data = $request->only([
            'nama_toko', 'alamat', 'telepon', 'deskripsi',
            'tipe_pembayaran',
            'nama_bank', 'nomor_rekening', 'nama_pemilik_rekening',
            'nama_ewallet', 'nomor_ewallet', 'nama_pemilik_ewallet',
        ]);

        $data['gunakan_rajaongkir'] = $request->has('gunakan_rajaongkir') ? true : false;
        $data['kota_asal_id'] = $request->kota_asal_id;
        $data['kota_asal_nama'] = $request->kota_asal_nama;

        if ($request->hasFile('gambar_ewallet_qr')) {
            $data['gambar_ewallet_qr'] = $request->file('gambar_ewallet_qr');
        }

        if ($request->hasFile('gambar_qris')) {
            $data['gambar_qris'] = $request->file('gambar_qris');
        }

        $this->tokoService->update(Auth::user()->toko, $data);

        return redirect()->route('user.toko.index')->with('success', 'Data toko berhasil diupdate');
    }

    public function show($id)
    {
        $toko = $this->tokoService->getPublic($id);
        $produks = $toko->produks;

        return view('Pelanggan.reviewakunuser', compact('toko', 'produks'));
    }
}
