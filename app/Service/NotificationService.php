<?php

namespace App\Service;

use App\Models\Notification;
use Illuminate\Support\Facades\Validator;

class NotificationService
{
    public function getUserNotifications()
    {
        $user_id = auth('api')->id();

        $notifications = Notification::where("site", "1")
                ->where("users_read_id", NULL)
                ->orWhere("users_read_id", "NOT LIKE", "%[$user_id]%")
                ->orderBy("created_at", "DESC")
                ->get();

        return $notifications;
    }

    public function read($id)
    {
        $user_id = auth('api')->id();

        $notification = Notification::where('users_read_id', 'NOT LIKE', "[$user_id]")
                    ->orWhere('users_read_id', NULL)
                    ->find($id);

        if(!$notification){
            return [
                "body" => [
                    "message" => "Ошибка получения уведомления"
                ],
                "code" => 422
            ];
        }

        $notification->users_read_id = trim($notification->users_read_id . ",[" . $user_id . "]", ",");

        $notification->save();

        return [
            "body" => [],
            "code" => 204
        ];
    }

    public function getCount()
    {
        $user_id = auth('api')->id();

        $count = Notification::where("site", "1")
                ->where("users_read_id", NULL)
                ->orWhere("users_read_id", "NOT LIKE", "%[$user_id]%")
                ->count();
        
        return $count;
    }

    public function getNotificationForAdmin()
    {
        return Notification::get();
    }

    public function createNotification($request)
    {
        $validator = Validator::make($request->all(), [
            "email" => ["sometimes", "accepted"],
            "sms" => ["sometimes", "accepted"],
            "site" => ["sometimes", "accepted"],
            "telegram" => ["sometimes", "accepted"],
            "text" => ["required", "string", "min:10"]
        ]);

        if($validator->fails()){
            return [
                "body" => $validator->errors(),
                "code" => 422
            ];
        }

        if(!$request->email && !$request->sms && !$request->site && !$request->telegram){
            return [
                "body" => [
                    "message" => "Выберите метод рассылки"
                ],
                "code" => 422
            ];
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

        return [
            "body" => $notification,
            "code" => 200
        ];
    }
}