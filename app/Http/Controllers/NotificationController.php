<?php
/**
 * Notifications controller
 * php version 8.1.2
 * 
 * @category Controllers
 * 
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
namespace App\Http\Controllers;

use App\Http\Requests\Notification\CreateNotificationRequest;
use App\Models\Notification;
use App\Services\NotificationService;
use Illuminate\Http\JsonResponse;

/**
 * NotificationController class
 * 
 * @method JsonResponse getUserNotifications()
 * @method JsonResponse read(Notifiction $notifiction)
 * @method JsonResponse getCount()
 * @method JsonResponse getNotificationForAdmin()
 * @method JsonResponse createNotification(CreateNotificationRequest $request)
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
     * @param NotificationService $service Service variable
     */
    public function __construct(protected NotificationService $service)
    {
        
    }
    
    /**
     * Get notification for user
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
     * Read notification user
     *
     * @param Notifiction $notification Notification object
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
     * Get notifications for admin
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
     * @param CreateNotificationRequest $request object CreateNotificqtionRequest
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
