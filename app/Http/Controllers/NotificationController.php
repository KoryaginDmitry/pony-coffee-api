<?php

namespace App\Http\Controllers;

use App\Http\Requests\Notification\CreateNotificationRequest;
use App\Models\Notification;
use App\Services\NotificationService;
use Illuminate\Http\JsonResponse;

/**
 * NotificationController class
 *
 * @category Controllers
 *
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
class NotificationController extends BaseController
{
    /**
     * Service connection
     *
     * @param NotificationService $service
     */
    public function __construct(protected NotificationService $service)
    {

    }

    /**
     * Get notifications for auth user
     *
     * @return JsonResponse
     */
    public function getUserNotifications() : JsonResponse
    {
        return $this->sendResponse(
            $this->service->getUserNotifications()
        );
    }

    /**
     * Read notification
     *
     * @param Notification $notification
     *
     * @return JsonResponse
     */
    public function read(Notification $notification) : JsonResponse
    {
        return $this->sendResponse(
            $this->service->read($notification)
        );
    }

    /**
     * Get count notifications for user
     *
     * @return JsonResponse
     */
    public function getCount() : JsonResponse
    {
        return $this->sendResponse(
            $this->service->getCount()
        );
    }

    /**
     * Get all notifications
     *
     * @return JsonResponse
     */
    public function getNotificationForAdmin() : JsonResponse
    {
        return $this->sendResponse(
            $this->service->getNotificationForAdmin()
        );
    }

    /**
     * Create notification
     *
     * @param CreateNotificationRequest $request
     *
     * @return JsonResponse
     */
    public function createNotification(CreateNotificationRequest $request) : JsonResponse
    {
        return $this->sendResponse(
            $this->service->createNotification($request)
        );
    }
}
