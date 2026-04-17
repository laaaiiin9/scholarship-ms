<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Notification::with('user.profile')
                ->latest();

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('message', 'like', "%{$search}%")
                      ->orWhereHas('user.profile', function($pq) use ($search) {
                          $pq->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%");
                      });
                });
            }

            return response()->json($query->paginate(10));
        }

        $students = User::whereHas('roles', function($q) {
            $q->where('name', 'student');
        })->with('profile')->get();

        return view('admin.notifications.index', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'message' => 'required|string',
            'type'    => 'required|in:SYSTEM,ALERT,ANNOUNCEMENT',
            'scope'   => 'required|in:broadcast,individual',
            'user_id' => 'required_if:scope,individual|nullable|exists:users,id'
        ]);

        Notification::create([
            'title'   => $request->title,
            'message' => $request->message,
            'type'    => $request->type,
            'user_id' => $request->scope === 'broadcast' ? null : $request->user_id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Notification sent successfully.'
        ]);
    }

    public function destroy(Notification $notification)
    {
        $notification->delete();
        return back()->with('success', 'Notification deleted.');
    }
}
