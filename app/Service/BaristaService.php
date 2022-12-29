<?php

namespace App\Service;

use App\Models\CoffeePot;
use App\Models\User;
use App\Models\UserCoffeePot;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

/**
 * Barista class
 */
class BaristaService extends BaseService
{
    /**
     * Get baristas
     * 
     * @return User
     */
    public function getBaristas()
    {
        $users = User::where("role_id", "2")
            ->orderBy('created_at', "DESC")
            ->with("userCoffeePot.coffeePot")
            ->get();
        
        $coffeePots = CoffeePot::orderBy('created_at', "DESC")
            ->get();

        $this->data = [
            "users" => $users,
            "coffeePots" => $coffeePots
        ];
        
        return $this->sendResponse();
    }

    /**
     * Create profile barista
     * 
     * @param Request $request comment object Request class
     * 
     * @return User
     */
    public function create($request)
    {
        $validator = Validator::make(
            $request->all(), 
            [
                "name" => ["required", "string"],
                "last_name" => ["nullable", "string"],
                "phone" => ["required", "regex:/(\+7)[0-9]{10}/"],
                "password" => ["required", "string"]
            ]
        );
        
        if ($validator->fails()) {
            return $this->sendErrorResponse($validator->errors()->all());
        }

        $coffeePot = CoffeePot::find($request->coffeePot);

        $user = User::create(
            [
                "name" => $request->name,
                "last_name" => $request->last_name,
                "phone" => $request->phone,
                "phone_verified_at" => Carbon::now(),
                "password" => Hash::make($request->password),
                "agreement" => "1",
                "role_id" => "2"
            ]
        );

        if ($coffeePot) {
            UserCoffeePot::create(
                [
                    "user_id" => $user->id,
                    "coffee_pot_id" => $coffeePot->id
                ]
            );
        }

        $this->data = [
            "user" => $user,
            "coffeePot" => $request->coffeePot ? $coffeePot : null
        ];

        $this->code = 201;
        
        return $this->sendResponse();
    }

    /**
     * Update profile barista
     * 
     * @param Request $request comment object Request class
     * @param int     $id      comment id barista
     * 
     * @return User
     */
    public function update($request, int $id)
    {
        $request->validate(
            [
                "name" => ["required", "string"],
                "last_name" => ["nullable", "string"],
                "phone" => ["required", "regex:/(\+7)[0-9]{10}/"],
            ]
        );

        $user = User::where("role_id", 2)->find($id);

        if (!$user) {
            return $this->sendErrorResponse(['Сотрудник не найден']);
        }

        $user->update(
            [
                "name" => $request->name,
                "last_name" => $request->last_name,
                "phone" => $request->phone
            ]
        );

        if ($request->coffeePot !== 0) {
            $coffeePot = CoffeePot::find($request->coffeePot);

            if (!$coffeePot) {
                return $this->sendErrorResponse(['Такой кофейни нет']);
            }

            UserCoffeePot::updateOrCreate(
                [
                    "user_id" => $user->id
                ],
                [
                    "coffee_pot_id" => $coffeePot->id
                ]
            );
        } else {
            UserCoffeePot::where("user_id", $user->id)->delete();
        }

        $this->data = [
            "user" => $user,
            "coffeePot" => $request->coffeePot ? $coffeePot : null
        ];
        
        return $this->sendResponse();
    }

    /**
     * Delete profile barista
     * 
     * @param int $id comment id barista
     * 
     * @return array
     */
    public function delete(int $id)
    {
        $user = User::where("role_id", 2)->find($id);

        if (!$user) {
            return $this->sendErrorResponse(['Сотрудник не найден']);
        }

        UserCoffeePot::where("user_id", $user->id)->delete();

        $user->delete();

        $this->code = 204;

        return $this->sendResponse();
    }
}