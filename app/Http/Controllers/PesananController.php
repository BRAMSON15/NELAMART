<?php

namespace App\Http\Controllers;

use App\Services\PesananService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    public function __construct(protected PesananService $pesananService) {}

    public function index()
    {
        $toko = Auth::user()->toko;
        if (!$toko) {
            return redirect()->route('user.toko.create')->with('error', 'Silakan daftarkan toko terlebih dahulu');
        }

        $pesanans = $this->pesananService->getByToko($toko->id);
        return view('User.daftar-pesanan', compact('pesanans'));
    }

    public function show($id)
    {
        $pesanan = $this->pesananService->getDetail($id, Auth::user()->toko->id);
        return view('User.detail-pesanan', compact('pesanan'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,diproses,dikirim,selesai,dibatalkan',
        ]);

        $this->pesananService->updateStatus($id, $request->status);

        return redirect()->back()->with('success', 'Status pesanan berhasil diupdate');
    }

    public function laporan()
    {
        $toko = Auth::user()->toko;
        if (!$toko) {
            return redirect()->route('user.toko.create');
        }

        $data = $this->pesananService->getLaporan($toko->id);
        return view('User.laporan', $data);
    }
}
