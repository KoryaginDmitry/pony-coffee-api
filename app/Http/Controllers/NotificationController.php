<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

    public function getNotificationForAdmin()
    {
        $notifications = Notification::get();

        return response()->json($notifications, 200);
    }

    public function createNotification(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => ["sometimes", "accepted"],
            "sms" => ["sometimes", "accepted"],
            "site" => ["sometimes", "accepted"],
            "telegram" => ["sometimes", "accepted"],
            "text" => ["required", "string", "min:10"]
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        if(!$request->email && !$request->sms && !$request->site && !$request->telegram){
            return response()->json([
                "message" => "Выберите метод рассылки"
            ],422);
        }

        if($request->email){
            //email рассылка
        }

        if($request->sms){
            //sms рассылка
        }

        if($request->telegram){
            //telegram рассылка
        }
         
        $notification = Notification::create([
            "email" => $request->email ? "1" : "0",
            "sms" => $request->sms ? "1" : "0", 
            "site" => $request->site ? "1" : "0",
            "telegram" => $request->site ? "1" : "0",
            "text" => $request->text
        ]);

        return response()->json($notification, 201);
    }
}
