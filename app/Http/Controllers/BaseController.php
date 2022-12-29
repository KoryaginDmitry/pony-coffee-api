<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Base controller class
 * 
 * @method array sendResponse()
 */
class BaseController extends Controller
{
    /**
     * SendResponse
     *
     * @param array $response commetn description
     * 
     * @return array
     */
    protected function sendResponse($response)
    {
        return response()->json(
            [   
                'data' => $response['data'],
                'errors' => $response['errors'],
                'status' => $response['status']
            ],
            $response['code']
        );
    }
}
