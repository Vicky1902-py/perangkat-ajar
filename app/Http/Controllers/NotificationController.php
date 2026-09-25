<?php

namespace App\Http\Controllers;

use App\Models\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Tandai sebuah notifikasi telah dibaca oleh pengguna.
     */
    public function markAsRead(Request $request, UserNotification $notification)
    {
        if ($notification->user_id !== Auth::id()) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Akses ditolak.'], 403);
            }
            return redirect()->back()->with('error', 'Akses ditolak.');
        }

        $notification->markAsRead();

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Notifikasi ditandai sudah dibaca.']);
        }

        return redirect()->back()->with('success', 'Notifikasi berhasil ditandai sudah dibaca.');
    }

    /**
     * Tandai seluruh notifikasi milik pengguna telah dibaca.
     */
    public function markAllAsRead(Request $request)
    {
        UserNotification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Semua notifikasi telah ditandai dibaca.']);
        }

        return redirect()->back()->with('success', 'Semua notifikasi telah ditandai dibaca.');
    }
}
