<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\NotificationRead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationBellController extends Controller
{
    /**
     * Return the count of unread notifications for the current user.
     */
    public function unreadCount()
    {
        $user = Auth::user();

        $total = Notification::where(function ($q) use ($user) {
                $q->where('user_id', $user->id)->orWhereNull('user_id');
            })
            ->count();

        $readCount = NotificationRead::where('user_id', $user->id)->count();

        return response()->json(['count' => max(0, $total - $readCount)]);
    }

    /**
     * Return the 5 most recent notifications for the current user.
     */
    public function recent()
    {
        $user = Auth::user();

        $notifications = Notification::where(function ($q) use ($user) {
                $q->where('user_id', $user->id)->orWhereNull('user_id');
            })
            ->latest()
            ->take(5)
            ->get();

        $readIds = NotificationRead::where('user_id', $user->id)
            ->pluck('notification_id')
            ->toArray();

        $notifications->each(function ($n) use ($readIds) {
            $n->is_read = in_array($n->id, $readIds);
        });

        return response()->json($notifications);
    }

    /**
     * Mark a single notification as read.
     */
    public function markRead(Notification $notification)
    {
        NotificationRead::firstOrCreate([
            'notification_id' => $notification->id,
            'user_id'         => Auth::id(),
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Mark all notifications as read for the current user.
     */
    public function markAllRead()
    {
        $user = Auth::user();

        $notifIds = Notification::where(function ($q) use ($user) {
                $q->where('user_id', $user->id)->orWhereNull('user_id');
            })
            ->pluck('id');

        foreach ($notifIds as $id) {
            NotificationRead::firstOrCreate([
                'notification_id' => $id,
                'user_id'         => Auth::id(),
            ]);
        }

        return response()->json(['success' => true]);
    }
}
