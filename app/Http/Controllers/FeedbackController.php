<?php

namespace App\Http\Controllers;
;
use App\Service\FeedbackService;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{   
    public function __construct(protected FeedbackService $service)
    {
        
    }
    public function getFeedback($coffeePot_id = 0)
    {
        $data = $this->service->getFeedback($coffeePot_id);

        return response()->json($data['body'], $data['code']);
    }

    public function create(Request $request)
    {
        $data = $this->service->getFeedback($request);

        return response()->json($data['body'], $data['code']);
    }

    public function createMessage($id, Request $request)
    {   
        $data = $this->service->getFeedback($id, $request);

        return response()->json($data['body'], $data['code']);
    }
}
