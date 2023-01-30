<?php
/**
 * Base controller
 * php version 8.1.2
 * 
 * @category Controllers
 * 
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

/**
 * BaseController class
 * 
 * @method JsonResponse sendResponse(array $response)
 * 
 * @category Controllers
 * 
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
class BaseController extends Controller
{
    /**
     * SendResponse
     *
     * @param array $response
     * 
     * @return JsonResponse
     */
    protected function sendResponse(array $response) : JsonResponse
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
