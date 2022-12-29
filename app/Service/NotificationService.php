<?php

namespace App\Service;

use App\Models\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Request;

/**
 * 
 */
class NotificationService extends BaseService
{   
    /**
     * Undocumented function
     *
     * @return void
     */
    public function getUserNotifications()
    {
        $user_id = auth()->id();

        $this->data['notifications'] = Notification::where("site", "1")
            ->where("users_read_id", null)
            ->orWhere("users_read_id", "NOT LIKE", "%[$user_id]%")
            ->orderBy("created_at", "DESC")
            ->get();

        return $this->sendResponse();
    }

    /**
     * Undocumented function
     *
     * @param int $id
     * 
     * @return void
     */
    public function read($id)
    {
        $user_id = auth()->id();

        $notification = Notification::where('users_read_id', 'NOT LIKE', "[$user_id]")
            ->orWhere('users_read_id', null)
            ->find($id);

        if (!$notification) {
            return $this->sendErrorResponse(['Ошибка получения уведомления']);
        }

        $notification->users_read_id = trim($notification->users_read_id . ",[" . $user_id . "]", ",");

        $notification->save();

        $this->code = 204;

        return $this->sendResponse();
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getCount()
    {
        $user_id = auth()->id();
        
        $this->data['count'] = Notification::where("site", "1")
            ->where("users_read_id", null)
            ->orWhere("users_read_id", "NOT LIKE", "%[$user_id]%")
            ->count();
    
        return $this->sendResponse();
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getNotificationForAdmin()
    {
        $this->data = [
            "notifications" => Notification::get()
        ];

        return $this->sendResponse();
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * 
     * @return Notification
     */
    public function createNotification($request)
    {
        $validator = Validator::make(
            $request->all(), 
            [
                "site" => ["sometimes", "accepted"],
                "telegram" => ["sometimes", "accepted"],
                "text" => ["required", "string", "min:10"]
            ]
        );

        if ($validator->fails()) {
            return $this->sendErrorResponse($validator->errors()->all());
        }

        if (!$request->site && !$request->telegram) {
            return $this->sendErrorResponse(['Выберите метод рассылки']);
        }

        if ($request->telegram) {
            $idChannel = '-1001541569040';
            $botToken = '5939917205:AAGvsJ9vfVcRhEGbjLqE0Pujslv6wgvaf6g';

            $message = urlencode($request->text);
           
            try {
                file_get_contents("https://api.telegram.org/bot$botToken/sendMessage?chat_id=$idChannel&text=".$message);
            }
            catch (\Exception $e){
                return $this->sendErrorResponse(['Ошибка отправки уведомленией в телеграмм']);
            }
        }
         
        $notification = Notification::create(
            [
                "site" => $request->site ? "1" : "0",
                "telegram" => $request->site ? "1" : "0",
                "text" => $request->text
            ]
        );

        $this->data = [
            'notification' => $notification
        ];

        return $this->sendResponse();
    }
}