<?php

namespace App\Http\Controllers;

use App\Service\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct(protected NotificationService $service)
    {
        
    }
    public function getUserNotifications()
    {
        return response()->json([
            "notifications" => $this->service->getUserNotifications()
        ], 200);
    }

    public function read($id)
    {   
        $data = $this->service->read($id);

        return response()->json($data['body'], $data['code']);
    }

    public function getCount()
    {   
        return response()->json([
            "count" => $this->service->getCount()
        ], 200);
    }

    public function getNotificationForAdmin()
    {
        return response()->json($this->service->getNotificationForAdmin(), 200);
    }

    public function createNotification(Request $request)
    {
        $data = $this->service->createNotification($request);

        return response()->json($data['body'], $data['code']);
    }
}
