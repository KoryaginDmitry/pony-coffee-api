<?php

namespace App\Http\Controllers;

use App\Models\CoffeePot;
use App\Models\UserCoffeePot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CoffeePotController extends Controller
{
    public function getAddressCoffeePots()
    {
        $coffeePots = CoffeePot::select('address')->get();
        
        return response()->json($coffeePots, 200);
    }

    public function getCoffeePots()
    {
        $coffeePots = CoffeePot::get();

        return response()->json($coffeePots, 200);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "name" => ["nullable", "string"],
            "address" => ["required", "string"]
        ]);

        if($validator->fails()){
            return response()->json($validator->errors, 422);
        }

        $coffeePot = CoffeePot::create([
            "name" => $request->name,
            "address" => $request->address
        ]);

        return response()->json($coffeePot, 201);
    }

    public function update($id, Request $request)
    {   
        $validator = Validator::make($request->all(),[
            "name" => ["nullable", "string"],
            "address" => ["required", "string"]
        ]);
        
        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $coffeePot = CoffeePot::find($id);

        if(!$coffeePot){
            return response()->json([
                "message" => "Такой кофеточки нет в БД"
            ], 422);
        }

        $coffeePot->update([
            "name" => $request->name,
            "address" => $request->address
        ]);

        return response()->json($coffeePot, 200);
    }

    public function delete($id)
    {
        $coffeePot = CoffeePot::find($id);

        if(!$coffeePot){
            return response()->json([
                "message" => "Такой кофе точки нет в БД"
            ], 422);
        }

        UserCoffeePot::where("coffee_pot_id", $id)->delete();

        $coffeePot->delete();

        return response()->json([], 204);
    }
}
