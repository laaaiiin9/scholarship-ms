<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\NotificationRead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get notifications sent directly to student OR broadcasts
        $notifications = Notification::where(function($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->orWhereNull('user_id');
            })
            ->latest()
            ->get();

        // Get read notification IDs
        $readIds = NotificationRead::where('user_id', $user->id)
            ->pluck('notification_id')
            ->toArray();

        return view('student.notifications.index', compact('notifications', 'readIds'));
    }

    public function markAsRead(Request $request, Notification $notification)
    {
        NotificationRead::firstOrCreate([
            'notification_id' => $notification->id,
            'user_id' => Auth::id()
        ]);

        return response()->json(['success' => true]);
    }
}
