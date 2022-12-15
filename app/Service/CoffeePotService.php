<?php

namespace App\Service;

use App\Models\CoffeePot;
use App\Models\UserCoffeePot;
use Illuminate\Support\Facades\Validator;

class CoffeePotService
{
    public function getAddressCoffeePots()
    {
        $coffeePots = CoffeePot::select('id', 'address')->get();
        
        return [
            "body" => $coffeePots,
            "code" => 200
        ];
    }

    public function getCoffeePots()
    {
        $coffeePots = CoffeePot::get();

        return [
            "body" => $coffeePots,
            "code" => 200
        ];
    }

    public function create($request)
    {
        $validator = Validator::make($request->all(),[
            "name" => ["nullable", "string"],
            "address" => ["required", "string"]
        ]);

        if($validator->fails()){
            return [
                "body" => $validator->errors(),
                "code" => 422
            ];
        }

        $coffeePot = CoffeePot::create([
            "name" => $request->name,
            "address" => $request->address
        ]);

        return [
            "body" => $coffeePot,
            "code" => 201
        ];
    }

    public function update($id, $request)
    {   
        $validator = Validator::make($request->all(),[
            "name" => ["nullable", "string"],
            "address" => ["required", "string"]
        ]);
        
        if($validator->fails()){
            return [
                "body" => $validator->errors(),
                "code" => 422
            ];
        }

        $coffeePot = CoffeePot::find($id);

        if(!$coffeePot){
            return [
                "body" => [
                    "message" => "Такой кофе точки нет в БД"
                ],
                "code" => 422
            ];
        }

        $coffeePot->update([
            "name" => $request->name,
            "address" => $request->address
        ]);

        return [
            "body" => $coffeePot,
            "code" => 200
        ];
    }

    public function delete($id)
    {
        $coffeePot = CoffeePot::find($id);

        if(!$coffeePot){
            return [
                "body" => [
                    "message" => "Такой кофе точки нет в БД"
                ],
                "code" => 422
            ];
        }

        UserCoffeePot::where("coffee_pot_id", $id)->delete();

        $coffeePot->delete();

        return [
            "body" => [],
            "code" => 204
        ];
    }
}