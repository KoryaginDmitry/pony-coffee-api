<?php

/**
 * Notifications service
 * php version 8.1.2
 * 
 * @category Services
 * 
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
namespace App\Services;

use App\Http\Requests\Notification\CreateNotificationRequest;
use App\Mail\NewsletterMail;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * NotificationService class
 * 
 * @method array getUserNotifications()
 * @method array|NotFoundHttpException read(Notification $notification)
 * @method array getCount()
 * @method array getNotificationForAdmin()
 * @method array createNotification(CreateNotificationRequest $request)
 * 
 * @category Services
 * 
 * @author DmitryKoryagin <kor.dima97@mail.ru>
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

        $this->data = [
            'notifications' => Notification::where("site", "1")
                ->whereNull("users_read_id")
                ->orWhere("users_read_id", "NOT LIKE", "%[$user_id]%")
                ->orderBy("created_at", "DESC")
                ->get()
        ];

        return $this->sendResponse();
    }

    /**
     * Read notification
     *
     * @param Notification $notification
     * 
     * @throws NotFoundHttpException
     * 
     * @return array
     */
    public function read(Notification $notification) : array|NotFoundHttpException
    {
        $user_id = auth()->id();

        if (Str::contains($notification->users_read, $user_id)) {
            return throw new NotFoundHttpException();
        }

        $notification->users_read_id = trim(
            $notification->users_read_id . ",[" . $user_id . "]", ","
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
        
        $this->data = [
            'count' => Notification::where("site", "1")
                ->whereNull("users_read_id")
                ->orWhere("users_read_id", "NOT LIKE", "%[$user_id]%")
                ->count()
        ];
    
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
     * @param CreateNotificationRequest $request
     * 
     * @return array
     */
    public function createNotification(CreateNotificationRequest $request) : array
    {
        if ($request->telegram) {
            $botToken = config('services.telegram.bot_token');

            $this->sendHttpRequest(
                "https://api.telegram.org/bot$botToken/sendMessage",
                [
                    'chat_id' => config('services.telegram.channel_id'),
                    'text' => $request->text
                ]
            );
        }

        if ($request->email) {
            $users = User::where('role_id', 3)
                ->whereNotNull('email_verified_at')
                ->get();
            
            Mail::to($users)->send(new NewsletterMail($request->text));
        }
    
        $this->data = [
            'notification' => Notification::create(
                $request->validated()
            )
        ];

        return $this->sendResponse();
    }
}