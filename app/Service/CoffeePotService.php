<?php

/**
 * Coffee pot service
 * php version 8.1.2
 * 
 * @category Services
 * 
 * @package Category
 * 
 * @author DmitryKoryagin <kor.dima97@maiol.ru>
 * 
 * @license http://href.com MIT
 * 
 * @link http://href.com
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
 * @package Category
 * 
 * @author DmitryKoryagin <kor.dima97@email.ru>
 * 
 * @license http://href.com MIT
 * 
 * @link http://href.com
 */
class CoffeePotService extends BaseService
{
    /**
     * Get address coffee pots
     *
     * @return mixed
     */
    public function getAddressCoffeePots() : mixed
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
     * @return mixed
     */
    public function getCoffeePots() : mixed
    {
        $coffeePots = CoffeePot::get();

        $this->data = [
            "coffeePots" => $coffeePots
        ];
        
        return $this->sendResponse();
    }

    /**
     * Create coffee pot
     *
     * @param object $request object Request class
     * 
     * @return mixed
     */
    public function create($request) : mixed
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
     * @return mixed
     */
    public function update(int $id, object $request) : mixed
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
     * @return mixed
     */
    public function delete(int $id) : mixed
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