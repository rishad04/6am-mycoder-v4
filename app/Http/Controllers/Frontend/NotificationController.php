<?php

namespace App\Http\Controllers\Frontend;


use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Events\Task2\NewUserRegisteredNotification;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */

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
