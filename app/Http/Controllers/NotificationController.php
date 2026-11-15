<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function markRead(Notification $notification)
    {
        $notification = Notification::where('user_id', Auth::id())
            ->findOrFail($notification->id);
        $notification->update(['is_read' => true]);

        return back();
    }
}
