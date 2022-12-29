<?php

namespace App\Http\Controllers;

use App\Service\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends BaseController
{
    public function __construct(protected NotificationService $service)
    {
        
    }
    
    public function getUserNotifications()
    {   
        return $this->sendResponse(
            $this->service->getUserNotifications()
        );
    }

    public function read($id)
    {   
        return $this->sendResponse(
            $this->service->read($id)
        );
    }

    public function getCount()
    {   
        return $this->sendResponse(
            $this->service->getCount()
        );
    }

    public function getNotificationForAdmin()
    {
        return $this->sendResponse(
            $this->service->getNotificationForAdmin()
        );
    }

    public function createNotification(Request $request)
    {
        return $this->sendResponse(
            $this->service->createNotification($request)
        );
    }
}
