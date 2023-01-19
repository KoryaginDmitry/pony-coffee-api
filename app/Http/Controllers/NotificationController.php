<?php
/**
 * Notifications controller
 * php version 8.1.2
 * 
 * @category Controllers
 * 
 * @author DmitryKoryagin <kor.dima97@maiol.ru>
 */
namespace App\Http\Controllers;

use App\Services\NotificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * NotificationController class
 * 
 * @method JsonResponse getUserNotifications()
 * @method JsonResponse read(int $id)
 * @method JsonResponse getCount()
 * @method JsonResponse getNotificationForAdmin()
 * @method JsonResponse createNotification(Request $request)
 * 
 * @category Controllers
 * 
 * @author DmitryKoryagin <kor.dima97@email.ru>
 */
class NotificationController extends BaseController
{
    /**
     * Construct method
     * 
     * Connetcion service class
     *
     * @param NotificationService $service param service class
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
     * @param int $id id notification
     * 
     * @return JsonResponse
     */
    public function read(int $id) : JsonResponse
    {   
        return $this->sendResponse(
            $this->service->read($id)
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
     * @param Request $request object Request class
     * 
     * @return JsonResponse
     */
    public function createNotification(Request $request) : JsonResponse
    {
        return $this->sendResponse(
            $this->service->createNotification($request)
        );
    }
}
