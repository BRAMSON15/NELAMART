<?php

namespace App\Services;

use App\Models\Toko;

class TokoService
{
    public function store(int $userId, array $data): Toko
    {
        return Toko::create([
            'user_id'   => $userId,
            'nama_toko' => $data['nama_toko'],
            'alamat'    => $data['alamat'],
            'telepon'   => $data['telepon'],
            'deskripsi' => $data['deskripsi'] ?? null,
            'status'    => 'pending',
        ]);
    }

    public function update(Toko $toko, array $data): Toko
    {
        $updateData = [
            'nama_toko'             => $data['nama_toko'],
            'alamat'                => $data['alamat'],
            'telepon'               => $data['telepon'],
            'deskripsi'             => $data['deskripsi'] ?? null,
            'tipe_pembayaran'       => $data['tipe_pembayaran'] ?? 'bank',
            'nama_bank'             => $data['nama_bank'] ?? null,
            'nomor_rekening'        => $data['nomor_rekening'] ?? null,
            'nama_pemilik_rekening' => $data['nama_pemilik_rekening'] ?? null,
            'nama_ewallet'          => $data['nama_ewallet'] ?? null,
            'nomor_ewallet'         => $data['nomor_ewallet'] ?? null,
            'nama_pemilik_ewallet'  => $data['nama_pemilik_ewallet'] ?? null,
        ];

        // Upload gambar QRIS jika ada
        if (!empty($data['gambar_qris'])) {
            // Hapus gambar lama jika ada
            if ($toko->gambar_qris) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($toko->gambar_qris);
            }
            $updateData['gambar_qris'] = $data['gambar_qris']->store('qris', 'public');
        }

        // Upload gambar QR E-Wallet jika ada
        if (!empty($data['gambar_ewallet_qr'])) {
            // Hapus gambar lama jika ada
            if ($toko->gambar_ewallet_qr) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($toko->gambar_ewallet_qr);
            }
            $updateData['gambar_ewallet_qr'] = $data['gambar_ewallet_qr']->store('ewallet', 'public');
        }

        $toko->update($updateData);

        return $toko;
    }

    public function getPublic(int $id): Toko
    {
        $toko = Toko::with(['produks' => fn($q) => $q->latest(), 'user'])->findOrFail($id);

        abort_if($toko->status !== 'aktif', 404, 'Toko tidak ditemukan atau belum diverifikasi');

        return $toko;
    }
}
