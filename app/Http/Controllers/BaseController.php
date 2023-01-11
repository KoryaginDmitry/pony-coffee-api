<?php
/**
 * BaseController controller
 * php version 8.1.2
 * 
 * @category Controllers
 * 
 * @author DmitryKoryagin <kor.dima97@maiol.ru>
 */
namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

/**
 * BaristaController class
 * 
 * @method JsonResponse sendResponse()
 * 
 * @category Controllers
 * 
 * @author DmitryKoryagin <kor.dima97@email.ru>
 */
class BaseController extends Controller
{
    /**
     * SendResponse
     *
     * @param array $response array response
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
