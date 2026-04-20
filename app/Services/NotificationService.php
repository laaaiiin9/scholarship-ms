<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;

class NotificationService
{
    /**
     * Notify all admin users of an action taken by a student.
     */
    public static function notifyAdmins(string $title, string $message, string $type = 'SYSTEM'): void
    {
        $admins = User::whereHas('roles', function ($q) {
            $q->where('name', 'admin');
        })->get();

        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'title'   => $title,
                'type'    => $type,
                'message' => $message,
            ]);
        }
    }

    /**
     * Notify a specific student of an action taken by an admin.
     */
    public static function notifyStudent(int $userId, string $title, string $message, string $type = 'SYSTEM'): void
    {
        Notification::create([
            'user_id' => $userId,
            'title'   => $title,
            'type'    => $type,
            'message' => $message,
        ]);
    }

    /**
     * Broadcast a notification to all students.
     */
    public static function broadcast(string $title, string $message, string $type = 'ANNOUNCEMENT'): void
    {
        Notification::create([
            'user_id' => null,
            'title'   => $title,
            'type'    => $type,
            'message' => $message,
        ]);
    }
}
