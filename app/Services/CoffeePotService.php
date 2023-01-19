<?php

/**
 * Coffee pot service
 * php version 8.1.2
 * 
 * @category Services
 * 
 * @author DmitryKoryagin <kor.dima97@maiol.ru>
 */
namespace App\Services;

use App\Models\CoffeePot;
use App\Models\UserCoffeePot;

/**
 * CoffeePotService class
 * 
 * @method array getAddressCoffeePots()
 * @method array getCoffeePots()
 * @method array getCoffeePot(int $id)
 * @method array create(object $request)
 * @method array update(int $id, object $request)
 * @method array delete(int $id)
 * 
 * @category Services
 * 
 * @author DmitryKoryagin <kor.dima97@email.ru>
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
     * @param int $id id coffee pot
     * 
     * @return array
     */
    public function getCoffeePot(int $id) : array
    {   
        $coffeePot = CoffeePot::findOrFail($id);

        $this->data = [
            "coffeePot" => $coffeePot
        ];
        
        return $this->sendResponse();
    }

    /**
     * Create coffee pot
     *
     * @param object $request object Request class
     * 
     * @return array
     */
    public function create(object $request) : array
    {
        $this->validate(
            $request->all(),
            [
                "name" => ["nullable", "string"],
                "address" => ["required", "string"]  
            ]
        );

        $coffeePot = CoffeePot::create(
            [
                "name" => $request->name,
                "address" => $request->address
            ]
        );

        $this->data = [
            'coffeePot' => $coffeePot
        ];

        $this->code = 201;
        
        return $this->sendResponse();
    }

    /**
     * Update coffee pot
     *
     * @param int    $id      id coffee pot
     * @param object $request object request class
     * 
     * @return array
     */
    public function update(int $id, object $request) : array
    {   
        $this->validate(
            $request->all(),
            [
                "name" => ["nullable", "string"],
                "address" => ["required", "string"]
            ]
        );

        $coffeePot = CoffeePot::findOrFail($id);

        $coffeePot->update(
            [
                "name" => $request->name,
                "address" => $request->address
            ]
        );

        $this->data = [
            'coffeePot' => $coffeePot
        ];
        
        return $this->sendResponse();
    }

    /**
     * Delete coffee pot 
     *
     * @param int $id id coffee pot
     * 
     * @return array
     */
    public function delete(int $id) : array
    {
        $coffeePot = CoffeePot::findOrFail($id);

        UserCoffeePot::where("coffee_pot_id", $id)->delete();

        $coffeePot->delete();

        $this->code = 204;
        
        return $this->sendResponse();
    }
}