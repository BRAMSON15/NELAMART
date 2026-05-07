<?php

namespace App\Http\Controllers;

use App\Services\ProfilService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function __construct(protected ProfilService $profilService) {}

    public function index()
    {
        $user = Auth::user();
        return view('Pelanggan.profil', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'username'  => 'required|string|unique:users,username,' . $user->id,
            'alamat'    => 'nullable|string|max:500',
            'latitude'  => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        $this->profilService->update($user, $request->only('name', 'email', 'username', 'alamat', 'latitude', 'longitude'));

        return redirect()->back()->with('success', 'Profil berhasil diupdate');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:8|confirmed',
        ]);

        $updated = $this->profilService->updatePassword(
            Auth::user(),
            $request->password_lama,
            $request->password_baru
        );

        if (!$updated) {
            return redirect()->back()->with('error', 'Password lama tidak sesuai');
        }

        return redirect()->back()->with('success', 'Password berhasil diubah');
    }

    public function reviewStore(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'rating'    => 'required|integer|min:1|max:5',
            'komentar'  => 'nullable|string|max:1000',
        ]);

        $result = $this->profilService->storeReview(
            Auth::id(),
            $request->produk_id,
            $request->rating,
            $request->komentar
        );

        if ($result === false) {
            return redirect()->back()->with('error', 'Anda sudah memberikan ulasan untuk produk ini.');
        }

        return redirect()->back()->with('success', 'Ulasan berhasil dikirim. Terima kasih!');
    }
}
