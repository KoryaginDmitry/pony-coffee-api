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
     * @param CoffeePotService $service Service variable
     */
    public function __construct(protected CoffeePotService $service)
    {
        
    }

    /**
     * Method get address coffee pots
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
     * Method get coffee pots
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
     * Method get coffee pot
     *
     * @param CoffeePot $coffeePot object CoffeePot
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
     * Method create coffee pot
     *
     * @param CoffeePotRequest $request object CoffeePotRequest
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
     * Method update coffee pot
     *
     * @param CoffeePot        $coffeePot object CoffeePot
     * @param CoffeePotRequest $request   object CoffeePotRequest
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
     * Method delete coffee pot
     *
     * @param CoffeePot $coffeePot object CoffeePot
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
