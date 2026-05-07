<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrackingController extends Controller
{
    // Halaman tracking untuk pelanggan
    public function show($id)
    {
        $pesanan = Pesanan::with(['user', 'details.produk', 'toko'])->findOrFail($id);
        
        // Pastikan pesanan milik user yang login
        if ($pesanan->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        return view('Pelanggan.tracking', compact('pesanan'));
    }

    // API untuk get lokasi kurir terbaru
    public function getLocation($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        
        // Pastikan pesanan milik user yang login
        if ($pesanan->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json([
            'kurir_latitude' => $pesanan->kurir_latitude,
            'kurir_longitude' => $pesanan->kurir_longitude,
            'kurir_nama' => $pesanan->kurir_nama,
            'kurir_telepon' => $pesanan->kurir_telepon,
            'tracking_updated_at' => $pesanan->tracking_updated_at,
            'status' => $pesanan->status
        ]);
    }

    // Update lokasi kurir (untuk kurir/toko)
    public function updateLocation(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);
        
        // Pastikan yang update adalah pemilik toko
        if ($pesanan->toko->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'kurir_nama' => 'nullable|string',
            'kurir_telepon' => 'nullable|string'
        ]);

        $pesanan->update([
            'kurir_latitude' => $request->latitude,
            'kurir_longitude' => $request->longitude,
            'kurir_nama' => $request->kurir_nama ?? $pesanan->kurir_nama,
            'kurir_telepon' => $request->kurir_telepon ?? $pesanan->kurir_telepon,
            'tracking_updated_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Lokasi berhasil diupdate'
        ]);
    }
}
