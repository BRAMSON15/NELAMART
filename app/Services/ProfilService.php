<?php

namespace App\Services;

use App\Models\Ulasan;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ProfilService
{
    public function update(User $user, array $data): User
    {
        $user->update([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'username'  => $data['username'],
            'alamat'    => $data['alamat'] ?? null,
            'latitude'  => $data['latitude'] ?? null,
            'longitude' => $data['longitude'] ?? null,
        ]);

        return $user;
    }

    public function updatePassword(User $user, string $passwordLama, string $passwordBaru): bool
    {
        if (!Hash::check($passwordLama, $user->password)) {
            return false;
        }

        $user->update(['password' => Hash::make($passwordBaru)]);

        return true;
    }

    public function storeReview(int $userId, int $produkId, int $rating, ?string $komentar): Ulasan|false
    {
        if (Ulasan::where('user_id', $userId)->where('produk_id', $produkId)->exists()) {
            return false;
        }

        return Ulasan::create([
            'user_id'    => $userId,
            'produk_id'  => $produkId,
            'pesanan_id' => null,
            'rating'     => $rating,
            'komentar'   => $komentar,
        ]);
    }
}
