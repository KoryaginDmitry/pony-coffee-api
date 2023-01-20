<?php
/**
 * Bariasta controller
 * php version 8.1.2
 * 
 * @category Controllers
 * 
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
namespace App\Http\Controllers;

use App\Http\Requests\Barista\CreateRequest;
use App\Http\Requests\Barista\UpdateRequest;
use App\Models\User;
use App\Services\BaristaService;
use Illuminate\Http\JsonResponse;

/**
 * BaristaController class
 * 
 * @method JsonResponse get()
 * @method JsonResponse getBarista(User $barista)
 * @method JsonResponse create(CreateRequest $request)
 * @method JsonResponse update(UpdateRequest $request, User $barista)
 * @method JsonResponse delete(User $barista)
 * 
 * @category Controllers
 * 
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
class BaristaProfileController extends BaseController
{
    /**
     * Service connection
     *
     * @param BaristaService $service Service variable
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
     * Method get one user barista
     *  
     * @param User $barista brista user
     * 
     * @return JsonResponse
     */
    public function getBarista(User $barista) : JsonResponse
    {   
        return $this->sendResponse(
            $this->service->getBarista($barista)
        );
    }

    /**
     * Method create user barista
     *
     * @param CreateRequest $request object CreateRequest
     * 
     * @return JsonResponse
     */
    public function create(CreateRequest $request) : JsonResponse
    {
        return $this->sendResponse(
            $this->service->create($request)
        );
    }

    /**
     * Method update user barista
     *
     * @param UpdateRequest $request object UpdateRequest
     * @param User          $barista barista user
     * 
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, User $barista) : JsonResponse
    {
        return $this->sendResponse(
            $this->service->update($request, $barista)
        );
    }

    /**
     * Method delete user barista
     *
     * @param User $barista barista user
     * 
     * @return JsonResponse
     */
    public function delete(User $barista) : JsonResponse
    {
        return $this->sendResponse(
            $this->service->delete($barista)
        );
    }
}
