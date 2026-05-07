<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Toko;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RegistrasiController extends Controller
{
    public function showPelangganRegistrationForm()
    {
        return view('loginpelanggan.registerpelanggan');
    }

    public function registerPelanggan(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ], [
            'name.required'       => 'Nama lengkap wajib diisi',
            'username.required'   => 'Username wajib diisi',
            'username.unique'     => 'Username sudah digunakan',
            'email.required'      => 'Email wajib diisi',
            'email.unique'        => 'Email sudah terdaftar',
            'password.required'   => 'Password wajib diisi',
            'password.min'        => 'Password minimal 8 karakter',
            'password.confirmed'  => 'Konfirmasi password tidak cocok',
        ]);

        User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'pelanggan',
        ]);

        return redirect()->route('pelanggan.login')
            ->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function showRegistrationForm()
    {
        return view('loginuser.registrasi');
    }

    public function register(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            // Data Akun
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            
            // Data Pelaku UMKM
            'nama_lengkap' => 'required|string|max:255',
            'telepon' => 'required|string|max:20',
            
            // Data Toko
            'nama_toko' => 'required|string|max:255',
            'alamat_toko' => 'required|string',
            'deskripsi_toko' => 'nullable|string',
            
            // Rekening
            'tipe_pembayaran' => 'required|in:bank,ewallet,keduanya',
            'nama_bank' => 'nullable|required_if:tipe_pembayaran,bank|required_if:tipe_pembayaran,keduanya|string|max:50',
            'nomor_rekening' => 'nullable|required_if:tipe_pembayaran,bank|required_if:tipe_pembayaran,keduanya|string|max:30',
            'nama_pemilik_rekening' => 'nullable|required_if:tipe_pembayaran,bank|required_if:tipe_pembayaran,keduanya|string|max:100',
            'nama_ewallet' => 'nullable|required_if:tipe_pembayaran,ewallet|required_if:tipe_pembayaran,keduanya|string|max:50',
            'nama_pemilik_ewallet' => 'nullable|required_if:tipe_pembayaran,ewallet|required_if:tipe_pembayaran,keduanya|string|max:100',
            'gambar_qris' => 'nullable|required_if:tipe_pembayaran,ewallet|required_if:tipe_pembayaran,keduanya|image|max:2048',
            
            // Jasa Pengiriman
            'gunakan_rajaongkir' => 'nullable|in:0,1',
            'kota_asal_id' => 'required_if:gunakan_rajaongkir,1|nullable|string',
            'kota_asal_nama' => 'required_if:gunakan_rajaongkir,1|nullable|string',
            
            // Data Produk
            'nama_produk' => 'required|string|max:255',
            'kategori_produk' => 'required|string',
            'harga_produk' => 'required|numeric|min:0',
            'deskripsi_produk' => 'required|string',
            'gambar_produk' => 'required|image|max:5120',
            'stok_produk' => 'required|integer|min:0',
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi',
            'telepon.required' => 'Nomor telepon wajib diisi',
            'nama_toko.required' => 'Nama toko wajib diisi',
            'alamat_toko.required' => 'Alamat toko wajib diisi',
            'nama_produk.required' => 'Nama produk wajib diisi',
            'kategori_produk.required' => 'Kategori produk wajib dipilih',
            'harga_produk.required' => 'Harga produk wajib diisi',
            'harga_produk.numeric' => 'Harga produk harus berupa angka',
            'deskripsi_produk.required' => 'Deskripsi produk wajib diisi',
            'gambar_produk.required' => 'Gambar produk wajib diupload',
            'gambar_produk.image' => 'File harus berupa gambar',
            'gambar_produk.max' => 'Ukuran gambar maksimal 5MB',
            'stok_produk.required' => 'Stok produk wajib diisi',
        ]);

        DB::beginTransaction();
        
        try {
            // 1. Buat User
            $user = User::create([
                'name' => $validated['nama_lengkap'],
                'username' => strtolower(str_replace(' ', '', $validated['nama_lengkap'])) . rand(100, 999),
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'user',
            ]);

            // 2. Buat Toko
            $gambarQrisPath = null;
            if ($request->hasFile('gambar_qris')) {
                $gambarQrisPath = $request->file('gambar_qris')->store('qris', 'public');
            }

            $toko = Toko::create([
                'user_id'               => $user->id,
                'nama_toko'             => $validated['nama_toko'],
                'deskripsi'             => $validated['deskripsi_toko'],
                'alamat'                => $validated['alamat_toko'],
                'telepon'               => $validated['telepon'],
                'status'                => 'pending',
                'tipe_pembayaran'       => $validated['tipe_pembayaran'],
                'nama_bank'             => $validated['nama_bank'] ?? null,
                'nomor_rekening'        => $validated['nomor_rekening'] ?? null,
                'nama_pemilik_rekening' => $validated['nama_pemilik_rekening'] ?? null,
                'nama_ewallet'          => $validated['nama_ewallet'] ?? null,
                'nama_pemilik_ewallet'  => $validated['nama_pemilik_ewallet'] ?? null,
                'gambar_qris'           => $gambarQrisPath,
                'gunakan_rajaongkir'    => $request->has('gunakan_rajaongkir') ? true : false,
                'kota_asal_id'          => $request->kota_asal_id,
                'kota_asal_nama'        => $request->kota_asal_nama,
            ]);

            // 3. Upload Gambar Produk
            $gambarPath = null;
            if ($request->hasFile('gambar_produk')) {
                $file = $request->file('gambar_produk');
                $filename = time() . '_' . $file->getClientOriginalName();
                $gambarPath = $file->storeAs('produk', $filename, 'public');
            }

            // 4. Buat Produk
            Produk::create([
                'toko_id' => $toko->id,
                'nama_produk' => $validated['nama_produk'],
                'kategori' => $validated['kategori_produk'],
                'harga' => $validated['harga_produk'],
                'deskripsi' => $validated['deskripsi_produk'],
                'gambar' => $gambarPath,
                'stok' => $validated['stok_produk'],
                'status' => 'active',
            ]);

            DB::commit();

            // Redirect ke halaman sukses atau login
            return redirect()->route('user.login')
                ->with('success', 'Registrasi berhasil! Silakan login. Toko Anda akan diverifikasi oleh admin.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Hapus gambar jika ada error
            if (isset($gambarPath) && Storage::disk('public')->exists($gambarPath)) {
                Storage::disk('public')->delete($gambarPath);
            }
            if (isset($gambarQrisPath) && Storage::disk('public')->exists($gambarQrisPath)) {
                Storage::disk('public')->delete($gambarQrisPath);
            }

            return back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
}
