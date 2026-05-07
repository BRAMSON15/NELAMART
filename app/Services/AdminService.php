<?php

namespace App\Services;

use App\Models\Toko;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminService
{
    public function approveToko(int $id): Toko
    {
        $toko = Toko::findOrFail($id);
        $toko->update(['status' => 'aktif']);

        return $toko;
    }

    public function rejectToko(int $id): Toko
    {
        $toko = Toko::findOrFail($id);
        $toko->update(['status' => 'ditolak']);

        return $toko;
    }

    public function updateUser(int $id, array $data): User
    {
        $user = User::findOrFail($id);

        $user->update([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'username' => $data['username'] ?? null,
            'role'     => $data['role'],
        ]);

        if (!empty($data['password'])) {
            $user->update(['password' => Hash::make($data['password'])]);
        }

        return $user;
    }

    public function deleteUser(int $id, int $currentUserId): void
    {
        abort_if($id === $currentUserId, 403, 'Tidak dapat menghapus akun sendiri!');

        User::findOrFail($id)->delete();
    }
}
