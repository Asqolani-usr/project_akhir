<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('customer.notifications', compact('notifications'));
    }

    public function markAsRead(Notification $notification)
    {
        abort_if($notification->user_id !== auth()->id(), 403);
        $notification->update(['read' => true]);

        return back()->with('success', 'Notifikasi ditandai sudah dibaca.');
    }

    public function markAllAsRead()
    {
        Notification::where('user_id', auth()->id())->update(['read' => true]);
        return back()->with('success', 'Semua notifikasi ditandai sudah dibaca.');
    }

    public function destroy(Notification $notification)
    {
        abort_if($notification->user_id !== auth()->id(), 403);
        $notification->delete();
        return back()->with('success', 'Notifikasi dihapus.');
    }

    public function clearAll()
    {
        Notification::where('user_id', auth()->id())->delete();
        return back()->with('success', 'Semua notifikasi dihapus.');
    }

    public function unreadCount()
    {
        $count = Notification::where('user_id', auth()->id())->where('read', false)->count();
        return response()->json(['count' => $count]);
    }
}
