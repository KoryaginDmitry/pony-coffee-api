<?php

/**
 * Coffee pot service
 * php version 8.1.2
 * 
 * @category Services
 * 
 * @author DmitryKoryagin <kor.dima97@maiol.ru>
 */
namespace App\Service;

use App\Models\CoffeePot;
use App\Models\UserCoffeePot;
use Illuminate\Support\Facades\Validator;

/**
 * CoffeePotService class
 * 
 * @method mixed getAddressCoffeePots()
 * @method mixed getCoffeePots()
 * @method mixed create()
 * @method mixed update()
 * @method mixed delete()
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
        $coffeePots = CoffeePot::select('id', 'address')->get();
        
        $this->data = [
            "coffeePots" => $coffeePots
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
        $coffeePots = CoffeePot::get();

        $this->data = [
            "coffeePots" => $coffeePots
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

        $coffeePot = CoffeePot::find($id);

        if (!$coffeePot) {
            return $this->sendErrorResponse(['Такой кофейни нет']);
        }

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
    public function create($request) : array
    {
        $validator = Validator::make(
            $request->all(),
            [
                "name" => ["nullable", "string"],
                "address" => ["required", "string"]
            ]
        );

        if ($validator->fails()) {
            return $this->sendErrorResponse($validator->errors()->all());
        }

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
        $validator = Validator::make(
            $request->all(),
            [
                "name" => ["nullable", "string"],
                "address" => ["required", "string"]
            ]
        );
        
        if ($validator->fails()) {
            return $this->sendErrorResponse($validator->errors()->all());
        }

        $coffeePot = CoffeePot::find($id);

        if (!$coffeePot) {
            return $this->sendErrorResponse(['Такой кофейни нет']);
        }

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
        $coffeePot = CoffeePot::find($id);

        if (!$coffeePot) {
            return $this->sendErrorResponse(['Такой кофейни нет']);
        }

        UserCoffeePot::where("coffee_pot_id", $id)->delete();

        $coffeePot->delete();

        $this->code = 204;
        
        return $this->sendResponse();
    }
}