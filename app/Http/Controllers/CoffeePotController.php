<?php
/**
 * CoffeePotController class
 * php version 8.1.2
 * 
 * @category Controllers
 * 
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */

namespace App\Http\Controllers;

use App\Http\Requests\CoffeePot\CoffeePotRequest;
use App\Models\CoffeePot;
use App\Services\CoffeePotService;
use Illuminate\Http\JsonResponse;

/**
 * CoffeePotController class
 * 
 * @method JsonResponse getAddressCoffeePots()
 * @method JsonResponse getCoffeePots()
 * @method JsonResponse getCoffeePot(CoffeePot $coffeePot)
 * @method JsonResponse create(CoffeePotRequest $request)
 * @method JsonResponse update(CoffeePot $coffeePot, CoffeePotRequest $request)
 * @method JsonResponse delete(CoffeePot $coffeePot)
 * 
 * @category Controllers
 * 
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
class CoffeePotController extends BaseController
{
    /**
     * Service connection
     *
     * @param CoffeePotService $service
     */
    public function __construct(protected CoffeePotService $service)
    {
        
    }

    /**
     * Gets only addresses and id of coffee shops
     *
     * @return JsonResponse
     */
    public function getAddressCoffeePots() : JsonResponse
    {
        return $this->sendResponse(
            $this->service->getAddressCoffeePots()
        );
    }

    /**
     * Gets complete data of coffee shops
     *
     * @return JsonResponse
     */
    public function getCoffeePots() : JsonResponse
    {
        return $this->sendResponse(
            $this->service->getCoffeePots()
        );
    }

    /**
     * Gets one coffee shop
     *
     * @param CoffeePot $coffeePot
     * 
     * @return JsonResponse
     */
    public function getCoffeePot(CoffeePot $coffeePot) : JsonResponse
    {
        return $this->sendResponse(
            $this->service->getCoffeePot($coffeePot)
        );
    }

    /**
     * Create coffee shop
     *
     * @param CoffeePotRequest $request
     * 
     * @return JsonResponse
     */
    public function create(CoffeePotRequest $request) : JsonResponse
    {
        return $this->sendResponse(
            $this->service->create($request)
        );
    }

    /**
     * Update coffee shop
     *
     * @param CoffeePot        $coffeePot
     * @param CoffeePotRequest $request
     * 
     * @return JsonResponse
     */
    public function update(CoffeePot $coffeePot, CoffeePotRequest $request) : JsonResponse
    {   
        return $this->sendResponse(
            $this->service->update($coffeePot, $request)
        );
    }

    /**
     * Delete coffee shop
     *
     * @param CoffeePot $coffeePot
     * 
     * @return JsonResponse
     */
    public function delete(CoffeePot $coffeePot) : JsonResponse
    {
        return $this->sendResponse(
            $this->service->delete($coffeePot)
        );
    }
}
