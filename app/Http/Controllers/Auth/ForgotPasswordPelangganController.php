<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ForgotPasswordPelangganController extends Controller
{
    /**
     * Display the form to request a password reset link.
     */
    public function showLinkRequestForm()
    {
        return view('loginpelanggan.forgot-password');
    }

    /**
     * Send a reset link to the given user.
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->where('role', 'pelanggan')->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak terdaftar sebagai pelanggan.']);
        }

        // Generate token
        $token = Str::random(64);

        // Delete any existing tokens for this email
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        // Store token
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        // In a real application, you would send an email here.
        // For development, with MAIL_MAILER=log, it will show up in the logs.
        $resetLink = route('password.reset', ['token' => $token, 'email' => $request->email]);
        
        // Manual email sending using basic Mail::raw for simplicity in this setup
        // But better to use Notification/Mailable
        try {
            Mail::raw("Halo,\n\nAnda menerima email ini karena kami menerima permintaan reset password untuk akun Anda.\n\nKlik link di bawah ini untuk mereset password Anda:\n$resetLink\n\nLink ini akan kadaluarsa dalam 60 menit.\n\nJika Anda tidak merasa melakukan permintaan ini, abaikan email ini.\n\nSalam,\nNELA MARKET", function ($message) use ($request) {
                $message->to($request->email)
                    ->subject('Reset Password Pelanggan');
            });
        } catch (\Exception $e) {
            // Log the error but continue (especially if mail server is not configured)
            Log::error("Gagal mengirim email reset password: " . $e->getMessage());
        }

        return back()->with('success', 'Link reset password telah dikirim ke email Anda! (Cek storage/logs/laravel.log jika menggunakan mailer log)');
    }

    /**
     * Display the password reset view for the given token.
     */
    public function showResetForm(Request $request, $token)
    {
        return view('loginpelanggan.reset-password')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    /**
     * Reset the given user's password.
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ], [
            'password.required' => 'Password baru wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        $reset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$reset) {
            return back()->withErrors(['email' => 'Token reset password tidak valid atau sudah kadaluarsa.']);
        }

        /** @var object $reset */
        // Check expiration (e.g., 60 minutes)
        if (Carbon::parse($reset->created_at)->addMinutes(60)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return back()->withErrors(['email' => 'Token reset password sudah kadaluarsa.']);
        }

        $user = User::where('email', $request->email)->where('role', 'pelanggan')->first();
        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();

            // Delete the token
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();

            return redirect()->route('pelanggan.login')->with('success', 'Password Anda telah berhasil direset! Silakan login dengan password baru.');
        }

        return back()->withErrors(['email' => 'Akun pelanggan tidak ditemukan.']);
    }
}
