<?php

namespace App\Http\Controllers\Frontend;


use stdClass;
use App\Models\Notification;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function all()
    {
        $data = Notification::paginate(15);

        $info = new stdClass();
        $info->page_title = 'Notifications';
        $info->title = 'Notifications';

        return view('backend.notifications.index', compact('data', 'info'));
    }

    public function getLatestNotification()
    {
        $notification = Notification::where('is_broadcasted', 0)->first();

        if ($notification != '') {
            return response()->json(['message' => $notification->message]);
        }

        return response()->json(['message' => null]);
    }

    public function resetBroadcasted()
    {
        $updated = Notification::where('is_broadcasted', 0)->update(['is_broadcasted' => 1]);

        if ($updated > 0) {
            return response()->json(['message' => 'Notifications reset successfully!']);
        }

        return response()->json(['message' => 'No notifications to reset.']);
    }
}
