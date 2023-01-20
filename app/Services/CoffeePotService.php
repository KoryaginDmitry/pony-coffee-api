<?php

/**
 * Coffee pot service
 * php version 8.1.2
 * 
 * @category Services
 * 
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
namespace App\Services;

use App\Http\Requests\CoffeePot\CoffeePotRequest;
use App\Models\CoffeePot;

/**
 * CoffeePotService class
 * 
 * @method array getAddressCoffeePots()
 * @method array getCoffeePots()
 * @method array getCoffeePot(CoffeePot $coffeepot)
 * @method array create(CoffeePotRequest $request)
 * @method array update(CoffeePot $coffeePot, CoffeePotRequest $request)
 * @method array delete(CoffeePot $coffeePot)
 * 
 * @category Services
 * 
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
class CoffeePotService extends BaseService
{
    /**
     * Get address coffee pots
     *
     * @return array
     */
    public function getAddressCoffeePots() : array
    {
        $this->data = [
            "coffeePots" => CoffeePot::select('id', 'address')->get()
        ];
        
        return $this->sendResponse();
    }

    /**
     * Get coffee pots
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
     * Get coffee pot
     *
     * @param CoffeePot $coffeePot object CoffeePot
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
     * Create coffee pot
     *
     * @param CoffeePotRequest $request object CoffeePotRequest
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
     * Update coffee pot
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
     * Delete coffee pot 
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