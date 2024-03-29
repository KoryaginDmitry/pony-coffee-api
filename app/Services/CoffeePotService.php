<?php

namespace App\Services;

use App\Http\Requests\CoffeePot\CoffeePotRequest;
use App\Models\CoffeePot;

/**
 * CoffeePotService class
 *
 * @category Services
 *
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
class CoffeePotService extends BaseService
{
    /**
     * Gets complete data of coffee shops
     *
     * @return array
     */
    public function getCoffeePots() : array
    {
        $this->data = [
            "coffeePots" => CoffeePot::get()
        ];

        return $this->sendResponse();
    }

    /**
     * Gets one coffee shop
     *
     * @param CoffeePot $coffeePot
     *
     * @return array
     */
    public function getCoffeePot(CoffeePot $coffeePot) : array
    {
        $this->data = [
            "coffeePot" => $coffeePot
        ];

        return $this->sendResponse();
    }

    /**
     * Create coffee shop
     *
     * @param CoffeePotRequest $request
     *
     * @return array
     */
    public function create(CoffeePotRequest $request) : array
    {
        $this->data = [
            'coffeePot' => CoffeePot::create(
                $request->validated()
            )
        ];

        $this->code = 201;

        return $this->sendResponse();
    }

    /**
     * Update coffee shop
     *
     * @param CoffeePot        $coffeePot object CoffeePot
     * @param CoffeePotRequest $request   object CoffeePotRequest
     *
     * @return array
     */
    public function update(CoffeePot $coffeePot, CoffeePotRequest $request) : array
    {
        $coffeePot->update(
            $request->validated()
        );

        $this->data = [
            'coffeePot' => $coffeePot
        ];

        return $this->sendResponse();
    }

    /**
     * Delete coffee shop
     *
     * @param CoffeePot $coffeePot object CoffeePot
     *
     * @return array
     */
    public function delete(CoffeePot $coffeePot) : array
    {
        $coffeePot->delete();

        $this->code = 204;

        return $this->sendResponse();
    }
}
