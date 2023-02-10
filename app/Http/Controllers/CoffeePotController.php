<?php

namespace App\Http\Controllers;

use App\Http\Requests\CoffeePot\CoffeePotRequest;
use App\Models\CoffeePot;
use App\Services\CoffeePotService;
use Illuminate\Http\JsonResponse;

/**
 * CoffeePotController class
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
