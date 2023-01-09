<?php
/**
 * BaseController controller
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

use Illuminate\Http\JsonResponse;

/**
 * BaristaController class
 * 
 * @method JsonResponse sendResponse()
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
