<?php

namespace App\Service;

use App\Models\CoffeePot;
use App\Models\User;
use App\Models\UserCoffeePot;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class BaristaService
{
    public function get()
    {
        $users = User::where("role_id", "2")
            ->orderBy('created_at', "DESC")
            ->with("userCoffeePot.coffeePot")
            ->get();
        
        $coffeePots = CoffeePot::orderBy('created_at', "DESC")
            ->get();

        return [
            "body" => [
                "users" => $users, 
                "coffeePots" => $coffeePots
            ],
            "code" => 200
        ];
    }

    public function create($request)
    {
        $validator = Validator::make($request->all(), [
            "name" => ["required", "string"],
            "last_name" => ["nullable", "string"],
            "phone" => ["required", "regex:/(\+7)[0-9]{10}/"],
            "password" => ["required", "string"]
        ]);
        
        if($validator->fails()){
            return [
                "body" => $validator->errors(),
                "code" => 422
            ];
        }

        $coffeePot = CoffeePot::find($request->coffeePot);

        $user = User::create([
            "name" => $request->name,
            "last_name" => $request->last_name,
            "phone" => $request->phone,
            "phone_verified_at" => Carbon::now(),
            "password" => Hash::make($request->password),
            "agreement" => "1",
            "role_id" => "2"
        ]);

        if($coffeePot){
            UserCoffeePot::create([
                "user_id" => $user->id,
                "coffee_pot_id" => $coffeePot->id
            ]);
        }

        return [
            "body" => [
                "user" => $user,
                "coffeePot" => $request->coffeePot ? $coffeePot : null
            ],
            "code" =>201
        ];
    }

    public function update($request, $id)
    {
        $request->validate([
            "name" => ["required", "string"],
            "last_name" => ["nullable", "string"],
            "phone" => ["required", "regex:/(\+7)[0-9]{10}/"],
        ]);

        $user = User::where("role_id", 2)->find($id);

        if(!$user){
            return [
                "body" => [
                    "message" => "Такого баристы нет" 
                ],
                "code" => 422
            ];
        }

        $user->update([
            "name" => $request->name,
            "last_name" => $request->last_name,
            "phone" => $request->phone
        ]);

        if($request->coffeePot != 0){
            $coffeePot = CoffeePot::find($request->coffeePot);

            UserCoffeePot::updateOrCreate(
                [
                    "user_id" => $user->id
                ],
                [
                    "coffee_pot_id" => $coffeePot->id
                ]
            );
        }
        else {
            UserCoffeePot::where("user_id", $user->id)->delete();
        }

        return [
            "body" => [
                "user" => $user,
                "coffeePot" => $request->coffeePot ? $coffeePot : null
            ],
            "code" => 200
        ];
    }

    public function delete($id)
    {
        $user = User::where("role_id", 2)->find($id);

        if(!$user){
            return [
                "body" => [
                    "message" => "Такого баристы нет" 
                ],
                "code" => 422
            ];
        }

        UserCoffeePot::where("user_id", $user->id)->delete();

        $user->delete();

        return [
            "body" => [],
            "code" => 204
        ];
    }
}