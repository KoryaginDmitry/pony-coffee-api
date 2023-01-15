<?php
/**
 * Bariasta controller
 * php version 8.1.2
 * 
 * @category Controllers
 * 
 * @author DmitryKoryagin <kor.dima97@maiol.ru>
 */
namespace App\Http\Controllers;

use App\Service\BaristaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * BaristaController class
 * 
 * @method JsonResponse get()
 * @method JsonResponse getBarista()
 * @method JsonResponse create()
 * @method JsonResponse update()
 * @method JsonResponse delete()
 * 
 * @category Controllers
 * 
 * @author DmitryKoryagin <kor.dima97@email.ru>
 */
class BaristaProfileController extends BaseController
{
    /**
     * Connect service class
     *
     * @param BaristaService $service service param
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
     * Method get one user baristas
     *  
     * @param int $id id barista
     * 
     * @return JsonResponse
     */
    public function getBarista(int $id) : JsonResponse
    {   
        return $this->sendResponse(
            $this->service->getBarista($id)
        );
    }

    /**
     * Method create user barista
     *
     * @param Request $request object Request class
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
     * @param Request $request object Request class
     * @param int     $id      id barista
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
     * @param int $id id user barista
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
