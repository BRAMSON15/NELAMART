<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Show login form for admin
    public function showAdminLogin()
    {
        return view('loginadmin.loginadmin');
    }

    // Show login form for user
    public function showUserLogin()
    {
        return view('loginuser.loginuser');
    }

    // Show login form for pelanggan
    public function showPelangganLogin()
    {
        return view('loginpelanggan.loginpelanggan');
    }

    // Handle admin login
    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            if (Auth::user()->role === 'admin') {
                $request->session()->regenerate();
                return redirect()->intended('/admin/dashboard');
            }
            
            Auth::logout();
            return back()->withErrors([
                'username' => 'Anda tidak memiliki akses sebagai admin.',
            ])->withInput();
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->withInput();
    }

    // Handle user login
    public function userLogin(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            if (Auth::user()->role === 'user') {
                $request->session()->regenerate();
                return redirect()->intended('/user/dashboard');
            }
            
            Auth::logout();
            return back()->withErrors([
                'email' => 'Anda tidak memiliki akses sebagai user.',
            ])->withInput();
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput();
    }

    // Handle pelanggan login
    public function pelangganLogin(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            if (Auth::user()->role === 'pelanggan') {
                $request->session()->regenerate();
                return redirect()->intended('/pelanggan/dashboard');
            }
            
            Auth::logout();
            return back()->withErrors([
                'username' => 'Anda tidak memiliki akses sebagai pelanggan.',
            ])->withInput();
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->withInput();
    }

    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}
