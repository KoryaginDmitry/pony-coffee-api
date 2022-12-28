<?php

namespace App\Http\Controllers;
;
use App\Service\FeedbackService;
use Illuminate\Http\Request;

class FeedbackController extends BaseController
{   
    public function __construct(protected FeedbackService $service)
    {
        
    }
    public function getFeedback($coffeePot_id = 0)
    {
        return $this->sendResponse(
            $this->service->getFeedback($coffeePot_id)
        );
    }

    public function create(Request $request)
    {
        return $this->sendResponse(
            $this->service->create($request)
        );
    }

    public function createMessage($id, Request $request)
    {   
        return $this->sendResponse(
            $this->service->createMessage($id, $request)
        );
    }
}
