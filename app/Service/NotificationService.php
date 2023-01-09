<?php

/**
 * Notifications service
 * php version 8.1.2
 * 
 * @category Services
 * 
 * @package Category
 * 
 * @author DmitryKoryagin <kor.dima97@maiol.ru>
 * 
 * @license http://href.com MIT
 * 
 * @link http://href.com
 */
namespace App\Service;

use App\Models\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Request;

/**
 * NotificationService class
 * 
 * @method mixed getUserNotifications()
 * @method mixed read()
 * @method mixed getCount()
 * @method mixed getNotificationForAdmin()
 * @method mixed createNotification()
 * 
 * @category Services
 * 
 * @package Category
 * 
 * @author DmitryKoryagin <kor.dima97@email.ru>
 * 
 * @license http://href.com MIT
 * 
 * @link http://href.com
 */
class NotificationService extends BaseService
{
    /**
     * Get notifications for auth user 
     *
     * @return mixed
     */
    public function getUserNotifications() : mixed
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
     * @return mixed
     */
    public function read(int $id) : mixed
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
     * @return mixed
     */
    public function getCount() : mixed
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
     * @return mixed
     */
    public function getNotificationForAdmin() : mixed
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
     * @return mixed
     */
    public function createNotification(object $request) : mixed
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