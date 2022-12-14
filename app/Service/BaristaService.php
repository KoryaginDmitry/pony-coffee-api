<?php

/**
 * Barista service
 * php version 8.1.2
 * 
 * @category Services
 * 
 * @author DmitryKoryagin <kor.dima97@maiol.ru>
 * 
 */
namespace App\Service;

use App\Models\CoffeePot;
use App\Models\User;
use App\Models\UserCoffeePot;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

/**
 * BaristaService class
 * 
 * @method array getBaristas()
 * @method array create()
 * @method array update()
 * @method array delete()
 * 
 * @category Services
 * 
 * @author DmitryKoryagin <kor.dima97@email.ru>
 */
class BaristaService extends BaseService
{
    /**
     * Get baristas
     * 
     * @return mixed
     */
    public function getBaristas() : mixed
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
     * @param object $request object Request class
     * 
     * @return mixed
     */
    public function create(object $request) : mixed
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
     * @param object $request object Request class
     * @param int    $id      id barista
     * 
     * @return User
     */
    public function update(object $request, int $id)
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
            return $this->sendErrorResponse(['?????????????????? ???? ????????????']);
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
                return $this->sendErrorResponse(['?????????? ?????????????? ??????']);
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
     * @param int $id id barista
     * 
     * @return mixed
     */
    public function delete(int $id) : mixed
    {
        $user = User::where("role_id", 2)->find($id);

        if (!$user) {
            return $this->sendErrorResponse(['?????????????????? ???? ????????????']);
        }

        UserCoffeePot::where("user_id", $user->id)->delete();

        $user->delete();

        $this->code = 204;

        return $this->sendResponse();
    }
}