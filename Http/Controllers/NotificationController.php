<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // Return all notifications for the authenticated user
    public function index(Request $request)
    {
        return response()->json([
            'notifications' => $request->user()->notifications,
        ]);
    }

    // Mark all notifications as read
    public function markAllAsRead(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();

        return response()->json([
            'message' => 'All notifications marked as read.',
        ]);
    }
}
