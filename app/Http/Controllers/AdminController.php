<?php

namespace App\Http\Controllers;
use App\Models\Toko;
use App\Models\User;
use App\Models\Produk;
use App\Models\PesananDetail;
use App\Services\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct(protected AdminService $adminService) {}

    public function kelolaTokoIndex()
    {
        $tokos = Toko::with('user')->latest()->get();
        return view('Admin.kelola-toko', compact('tokos'));
    }

    public function approveToko($id)
    {
        $this->adminService->approveToko($id);
        return redirect()->back()->with('success', 'Toko berhasil disetujui!');
    }

    public function rejectToko($id)
    {
        $this->adminService->rejectToko($id);
        return redirect()->back()->with('success', 'Toko berhasil ditolak!');
    }

    public function detailToko($id)
    {
        $toko = Toko::with('user')->findOrFail($id);
        return view('Admin.detail-toko', compact('toko'));
    }

    public function kelolaUserIndex()
    {
        $users = User::where('role', 'user')->latest()->get();
        return view('Admin.kelola-user', compact('users'));
    }

    public function detailUser($id)
    {
        $user = User::with('toko')->findOrFail($id);
        return view('Admin.detail-user', compact('user'));
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('Admin.edit-user', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $id,
            'username' => 'nullable|string|max:255|unique:users,username,' . $id,
            'role'     => 'required|in:admin,user,pelanggan',
            'password' => 'nullable|string|min:8',
        ]);

        $this->adminService->updateUser($id, $request->only('name', 'email', 'username', 'role', 'password'));

        return redirect()->route('admin.kelola-user')->with('success', 'User berhasil diupdate!');
    }

    public function deleteUser($id)
    {
        $this->adminService->deleteUser($id, auth()->id());
        return redirect()->back()->with('success', 'User berhasil dihapus!');
    }

    public function dashboard()
    {
        // Area Chart: Jumlah pesanan per hari (30 hari terakhir)
        $pesananHarian = \App\Models\Pesanan::select(
                DB::raw("DATE_FORMAT(created_at, '%d %b') as label"),
                DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as tgl"),
                DB::raw('count(*) as total')
            )
            ->where('created_at', '>=', now()->subDays(29)->startOfDay())
            ->groupBy('tgl', 'label')
            ->orderBy('tgl')
            ->get();

        // Isi hari yang kosong agar label lengkap 30 hari
        $chartLabels = [];
        $chartData   = [];
        for ($i = 29; $i >= 0; $i--) {
            $date  = now()->subDays($i);
            $label = $date->format('d M');
            $chartLabels[] = $label;
            $found = $pesananHarian->firstWhere('label', $label);
            $chartData[] = $found ? (int) $found->total : 0;
        }

        // Bar Chart: Jumlah pelaku UMKM terdaftar per bulan (12 bulan terakhir)
        $umkmBulanan = User::where('role', 'user')
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%b %Y') as label"),
                DB::raw("DATE_FORMAT(created_at, '%Y%m') as urut"),
                DB::raw('count(*) as total')
            )
            ->where('created_at', '>=', now()->subMonths(11)->startOfMonth())
            ->groupBy('urut', 'label')
            ->orderBy('urut')
            ->get();

        $barLabels = [];
        $barData   = [];
        for ($i = 11; $i >= 0; $i--) {
            $date  = now()->subMonths($i);
            $label = $date->format('M Y');
            $barLabels[] = $label;
            $found = $umkmBulanan->firstWhere('label', $label);
            $barData[] = $found ? (int) $found->total : 0;
        }

        return view('Admin.dashboardadmin', compact('chartLabels', 'chartData', 'barLabels', 'barData'));
    }

    public function statistik()
    {
        // Diagram Batang: Jumlah pelaku UMKM terdaftar per bulan (role=user)
        $umkmPerBulan = User::where('role', 'user')
            ->select(DB::raw("DATE_FORMAT(created_at, '%b %Y') as bulan"), DB::raw('count(*) as total'))
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%b %Y')"), DB::raw("DATE_FORMAT(created_at, '%Y%m')"))
            ->orderBy(DB::raw("DATE_FORMAT(created_at, '%Y%m')"))
            ->get();

        // Diagram Pie: Distribusi kategori produk
        $kategoriProduk = Produk::select('kategori', DB::raw('count(*) as total'))
            ->whereNotNull('kategori')
            ->groupBy('kategori')
            ->orderByDesc('total')
            ->get();

        return view('Admin.statistik', compact('umkmPerBulan', 'kategoriProduk'));
    }
}
