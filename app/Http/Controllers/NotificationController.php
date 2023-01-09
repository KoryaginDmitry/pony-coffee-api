<?php
/**
 * Notifications controller
 * php version 8.1.2
 * 
 * @category Controllers
 * 
 * @package Category
 * 
 * @author DmitryKoryagin <kor.dima97@maiol.ru>
 * 
 * @license http://href.com MIT
 * 
 * @link http://href.com
 */
namespace App\Http\Controllers;

use App\Service\NotificationService;
use Illuminate\Http\Request;

/**
 * NotificationController class
 * 
 * @method array getUserNotifications()
 * @method array read()
 * @method array getCount()
 * @method array getNotificationForAdmin()
 * @method array createNotification()
 * 
 * @category Controllers
 * 
 * @package Category
 * 
 * @author DmitryKoryagin <kor.dima97@email.ru>
 * 
 * @license http://href.com MIT
 * 
 * @link http://href.com
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
     * @return array
     */
    public function getUserNotifications() : array
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
     * @return array
     */
    public function read(int $id) : array
    {   
        return $this->sendResponse(
            $this->service->read($id)
        );
    }

    /**
     * Get count notifications for user
     *
     * @return array
     */
    public function getCount() : array
    {   
        return $this->sendResponse(
            $this->service->getCount()
        );
    }

    /**
     * Get notifications for admin
     *
     * @return array
     */
    public function getNotificationForAdmin() : array
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
     * @return array
     */
    public function createNotification(Request $request) : array
    {
        return $this->sendResponse(
            $this->service->createNotification($request)
        );
    }
}
