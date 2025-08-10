<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Get notifications for current user.
     */
    public function index()
    {
        $notifications = Auth::user()->notifications()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Get unread notifications count for current user.
     */
    public function getUnreadCount()
    {
        $count = Auth::user()->notifications()->unread()->count();
        
        return response()->json(['count' => $count]);
    }

    /**
     * Get recent notifications for dropdown.
     */
    public function getRecent()
    {
        $notifications = Auth::user()->notifications()
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => Auth::user()->notifications()->unread()->count()
        ]);
    }

    /**
     * Mark notification as read.
     */
    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        if ($notification->action_url) {
            return redirect($notification->action_url);
        }

        return redirect()->back();
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead()
    {
        Auth::user()->notifications()->unread()->update(['read_at' => now()]);

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('success', 'Semua notifikasi telah ditandai sebagai dibaca');
    }

    /**
     * Delete notification.
     */
    public function destroy($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('success', 'Notifikasi berhasil dihapus');
    }

    /**
     * Create notification for user(s).
     */
    public static function create($userId, $title, $message, $type = 'info', $data = null, $actionUrl = null)
    {
        return Notification::create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'data' => $data,
            'action_url' => $actionUrl
        ]);
    }

    /**
     * Create notification for all admins.
     */
    public static function notifyAdmins($title, $message, $type = 'info', $data = null, $actionUrl = null)
    {
        $admins = \App\Models\User::where('role', 'admin')->where('is_active', true)->get();
        
        foreach ($admins as $admin) {
            self::create($admin->id, $title, $message, $type, $data, $actionUrl);
        }
    }

    /**
     * Create notification for all users.
     */
    public static function notifyAllUsers($title, $message, $type = 'info', $data = null, $actionUrl = null)
    {
        $users = \App\Models\User::where('is_active', true)->get();
        
        foreach ($users as $user) {
            self::create($user->id, $title, $message, $type, $data, $actionUrl);
        }
    }
}
