<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function getUserNotifications()
    {
        $user_id = auth('api')->id();

        $notifications = Notification::where("site", "1")
                ->where("users_read_id", NULL)
                ->orWhere("users_read_id", "NOT LIKE", "%[$user_id]%")
                ->orderBy("created_at", "DESC")
                ->get();

        return response()->json([
            "notifications" => $notifications
        ], 200);
    }

    public function read($id)
    {   
        $user_id = auth('api')->id();

        $notification = Notification::where('users_read_id', 'NOT LIKE', "[$user_id]")
                    ->orWhere('users_read_id', NULL)
                    ->find($id);

        if(!$notification){
            return response()->json([
                "message" => "Ошибка получения уведомления"
            ],422);
        }

        $notification->users_read_id = trim($notification->users_read_id . ",[" . $user_id . "]", ",");

        $notification->save();

        return response()->json([], 204);
    }

    public function getCount()
    {   
        $user_id = auth('api')->id();

        $count = Notification::where("site", "1")
                ->where("users_read_id", NULL)
                ->orWhere("users_read_id", "NOT LIKE", "%[$user_id]%")
                ->count();
        
        return response()->json([
            "count" => $count
        ], 200);
    }
}
