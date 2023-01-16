<?php

/**
 * Notifications service
 * php version 8.1.2
 * 
 * @category Services
 * 
 * @author DmitryKoryagin <kor.dima97@maiol.ru>
 */
namespace App\Service;

use App\Models\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Request;

/**
 * NotificationService class
 * 
 * @method array getUserNotifications()
 * @method array read(int $id)
 * @method array getCount()
 * @method array getNotificationForAdmin()
 * @method array createNotification(object $request)
 * 
 * @category Services
 * 
 * @author DmitryKoryagin <kor.dima97@email.ru>
 */
class NotificationService extends BaseService
{
    /**
     * Get notifications for auth user 
     *
     * @return array
     */
    public function getUserNotifications() : array
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
     * Read notification
     *
     * @param int $id id notification
     * 
     * @return array
     */
    public function read(int $id) : array
    {
        $user_id = auth()->id();

        $notification = Notification::where(
            'users_read_id',
            'NOT LIKE',
            "[$user_id]"
        )
            ->orWhere('users_read_id', null)
            ->find($id);

        if (!$notification) {
            return $this->sendErrorResponse(['Ошибка получения уведомления']);
        }

        $notification->users_read_id = trim(
            $notification->users_read_id . ",[" . $user_id . "]",
            ","
        );

        $notification->save();

        $this->code = 204;

        return $this->sendResponse();
    }

    /**
     * Get count notifications for auth user
     *
     * @return array
     */
    public function getCount() : array
    {
        $user_id = auth()->id();
        
        $this->data['count'] = Notification::where("site", "1")
            ->where("users_read_id", null)
            ->orWhere("users_read_id", "NOT LIKE", "%[$user_id]%")
            ->count();
    
        return $this->sendResponse();
    }

    /**
     * Get all notifications for admin
     *
     * @return array
     */
    public function getNotificationForAdmin() : array
    {
        $this->data = [
            "notifications" => Notification::get()
        ];

        return $this->sendResponse();
    }

    /**
     * Create notification
     *
     * @param object $request object Request class
     * 
     * @return array
     */
    public function createNotification(object $request) : array
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
            $idChannel = config('param_config.channel_id');
            $botToken = config('param_config.bot_token');

            $message = urlencode($request->text);
           
            try {
                file_get_contents(
                    "https://api.telegram.org/bot$botToken/sendMessage?chat_id=$idChannel&text=".$message
                );
            }
            catch (\Exception $e){
                return $this->sendErrorResponse(
                    [
                        'Ошибка отправки уведомленией в телеграмм'
                    ]
                );
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