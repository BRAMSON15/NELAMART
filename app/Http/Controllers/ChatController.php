<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function chatUser($userId)
    {
        $user = User::findOrFail($userId);
        
        $chats = Chat::where(function($query) use ($userId) {
            $query->where('pengirim_id', Auth::id())
                  ->where('penerima_id', $userId);
        })->orWhere(function($query) use ($userId) {
            $query->where('pengirim_id', $userId)
                  ->where('penerima_id', Auth::id());
        })->orderBy('created_at', 'asc')->get();

        Chat::where('pengirim_id', $userId)
            ->where('penerima_id', Auth::id())
            ->update(['is_read' => true]);

        return view('Pelanggan.chatuser', compact('user', 'chats'));
    }

    public function chatAdmin()
    {
        $admin = User::where('role', 'admin')->first();
        
        if (!$admin) {
            return redirect()->back()->with('error', 'Admin tidak ditemukan');
        }

        $chats = Chat::where(function($query) use ($admin) {
            $query->where('pengirim_id', Auth::id())
                  ->where('penerima_id', $admin->id);
        })->orWhere(function($query) use ($admin) {
            $query->where('pengirim_id', $admin->id)
                  ->where('penerima_id', Auth::id());
        })->orderBy('created_at', 'asc')->get();

        Chat::where('pengirim_id', $admin->id)
            ->where('penerima_id', Auth::id())
            ->update(['is_read' => true]);

        return view('Pelanggan.chatadmin', compact('admin', 'chats'));
    }

    public function kirimPesan(Request $request)
    {
        $request->validate([
            'penerima_id' => 'required|exists:users,id',
            'pesan' => 'required|string',
        ]);

        Chat::create([
            'pengirim_id' => Auth::id(),
            'penerima_id' => $request->penerima_id,
            'pesan' => $request->pesan,
            'is_read' => false,
        ]);

        return redirect()->back()->with('success', 'Pesan berhasil dikirim');
    }

    public function adminIndex()
    {
        // Get unique users who have chatted with admin
        $chats = Chat::where('penerima_id', Auth::id())
            ->orWhere('pengirim_id', Auth::id())
            ->latest()
            ->get();

        $userIds = $chats->map(function($chat) {
            return $chat->pengirim_id == Auth::id() ? $chat->penerima_id : $chat->pengirim_id;
        })->unique();

        $users = User::whereIn('id', $userIds)->get();

        return view('Admin.chat.index', compact('users', 'chats'));
    }

    public function adminShow($userId)
    {
        $user = User::findOrFail($userId);
        
        $chats = Chat::where(function($query) use ($userId) {
            $query->where('pengirim_id', Auth::id())
                  ->where('penerima_id', $userId);
        })->orWhere(function($query) use ($userId) {
            $query->where('pengirim_id', $userId)
                  ->where('penerima_id', Auth::id());
        })->orderBy('created_at', 'asc')->get();

        Chat::where('pengirim_id', $userId)
            ->where('penerima_id', Auth::id())
            ->update(['is_read' => true]);

        return view('Admin.chat.show', compact('user', 'chats'));
    }
}
