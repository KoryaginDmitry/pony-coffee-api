<?php

namespace App\Service;

use App\Models\CoffeePot;
use App\Models\UserCoffeePot;
use Illuminate\Support\Facades\Validator;

class CoffeePotService extends BaseService
{
    public function getAddressCoffeePots()
    {
        $coffeePots = CoffeePot::select('id', 'address')->get();
        
        $this->data = [
            "coffeePots" => $coffeePots
        ];
        
        return $this->sendResponse();
    }

    public function getCoffeePots()
    {
        $coffeePots = CoffeePot::get();

        $this->data = [
            "coffeePots" => $coffeePots
        ];
        
        return $this->sendResponse();
    }

    public function create($request)
    {
        $validator = Validator::make($request->all(),[
            "name" => ["nullable", "string"],
            "address" => ["required", "string"]
        ]);

        if($validator->fails()){
            return $this->sendErrorResponse($validator->errors()->all());
        }

        $coffeePot = CoffeePot::create([
            "name" => $request->name,
            "address" => $request->address
        ]);

        $this->data = [
            'coffeePot' => $coffeePot
        ];

        $this->code = 201;
        
        return $this->sendResponse();
    }

    public function update($id, $request)
    {   
        $validator = Validator::make($request->all(),[
            "name" => ["nullable", "string"],
            "address" => ["required", "string"]
        ]);
        
        if($validator->fails()){
            return $this->sendErrorResponse($validator->errors()->all());
        }

        $coffeePot = CoffeePot::find($id);

        if(!$coffeePot){
            return $this->sendErrorResponse(['Такой кофейни нет']);
        }

        $coffeePot->update([
            "name" => $request->name,
            "address" => $request->address
        ]);

        $this->data = [
            'coffeePot' => $coffeePot
        ];
        
        return $this->sendResponse();
    }

    public function delete($id)
    {
        $coffeePot = CoffeePot::find($id);

        if(!$coffeePot){
            return $this->sendErrorResponse(['Такой кофейни нет']);
        }

        UserCoffeePot::where("coffee_pot_id", $id)->delete();

        $coffeePot->delete();

        $this->code = 204;
        
        return $this->sendResponse();
    }
}