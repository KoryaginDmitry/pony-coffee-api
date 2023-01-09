<?php
/**
 * Bariasta controller
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

use App\Service\BaristaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * BaristaController class
 * 
 * @method JsonResponse get()
 * @method JsonResponse create()
 * @method JsonResponse update()
 * @method JsonResponse delete()
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
class BaristaProfileController extends BaseController
{
    /**
     * Connect service class
     *
     * @param BaristaService $service comment service param
     */
    public function __construct(protected BaristaService $service)
    {
        
    }
    
    /**
     * Method get users baristas
     *
     * @return JsonResponse
     */
    public function get() : JsonResponse
    {   
        return $this->sendResponse(
            $this->service->getBaristas()
        );
    }

    /**
     * Method create user barista
     *
     * @param Request $request comment object Request class
     * 
     * @return JsonResponse
     */
    public function create(Request $request) : JsonResponse
    {
        return $this->sendResponse(
            $this->service->create($request)
        );
    }

    /**
     * Method update user barista
     *
     * @param Request $request comment object Request class
     * @param int     $id      comment id barista
     * 
     * @return JsonResponse
     */
    public function update(Request $request, int $id) : JsonResponse
    {
        return $this->sendResponse(
            $this->service->update($request, $id)
        );
    }

    /**
     * Method delete user barista
     *
     * @param int $id comment id user barista
     * 
     * @return JsonResponse
     */
    public function delete(int $id) : JsonResponse
    {
        return $this->sendResponse(
            $this->service->delete($id)
        );
    }
}
