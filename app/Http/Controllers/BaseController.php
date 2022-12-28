<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    protected function sendResponse($response)
    {
        return response()->json(
            [   
                'data' => $response['data'],
                'errors' => $response['errors'],
                'status' => $response['status']
            ],
            $response['code']);
    }
}
