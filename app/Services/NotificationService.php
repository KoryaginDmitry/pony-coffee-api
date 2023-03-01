<?php

namespace App\Services;

use App\Http\Requests\Notification\CreateNotificationRequest;
use App\Mail\NewsletterMail;
use App\Models\Notification;
use App\Models\User;
use App\Support\Traits\SendHttpRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\Client\RequestException;

/**
 * NotificationService class
 *
 * @category Services
 *
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
class NotificationService extends BaseService
{
    use SendHttpRequest;
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
     * @return array
     * @throws NotFoundHttpException
     *
     */
    public function read(Notification $notification) : array
    {
        $user_id = auth()->id();

        if (Str::contains($notification->users_read_id, $user_id)) {
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
     * @throws RequestException
     * @return array
     */
    public function createNotification(CreateNotificationRequest $request) : array
    {
        if ($request->telegram) {
            $botToken = config('services.telegram.bot_token');
            $chat_id = config('services.telegram.channel_id');

            $this->sendRequest(
                "https://api.telegram.org/bot$botToken/sendMessage",
                [
                    'chat_id' => $chat_id,
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

        $this->code = 201;

        $this->data = [
            'notification' => Notification::create(
                $request->validated()
            )
        ];

        return $this->sendResponse();
    }
}
