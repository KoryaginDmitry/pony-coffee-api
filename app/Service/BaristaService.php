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
use PhpParser\Node\Stmt\TryCatch;

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
     * @return array
     */
    public function getBaristas() : array
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
     * Get barista
     * 
     * @param int $id id barista user
     * 
     * @return array
     */
    public function getBarista(int $id) : array
    {
        $user = User::where("role_id", "2")
            ->with("userCoffeePot.coffeePot")
            ->find($id);

        if (!$user) {
            return $this->sendErrorResponse(['Такого баристы нет']);
        }
        
        $coffeePots = CoffeePot::orderBy('created_at', "DESC")
            ->get();

        $this->data = [
            "user" => $user,
            "coffeePots" => $coffeePots
        ];
        
        return $this->sendResponse();
    }

    /**
     * Create profile barista
     * 
     * @param object $request object Request class
     * 
     * @return array
     */
    public function create(object $request) : array
    {
        $validator = Validator::make(
            $request->all(), 
            [
                "name" => ["required", "string"],
                "last_name" => ["nullable", "string"],
                "phone" => ["required", "regex:/(\+7)[0-9]{10}/"],
                "password" => ["required", "string", "confirmed"],
                "coffeePot_id" => ["required", "exists:coffee_pots,id"]
            ]
        );
        
        if ($validator->fails()) {
            return $this->sendErrorResponse(
                $validator->errors()->all()
            );
        }

        $coffeePot = CoffeePot::find($request->coffeePot_id);

        try {
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
        } catch (\Throwable $th) {
            return $this->sendErrorResponse(
                [
                    "Ошибка создания пользователя"
                ],
                500
            );
        }
        

        UserCoffeePot::create(
            [
                "user_id" => $user->id,
                "coffee_pot_id" => $coffeePot->id
            ]
        );

        $this->data = [
            "user" => $user,
            "coffeePot" => $coffeePot
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
     * @return array
     */
    public function update(object $request, int $id) : array
    {
        $validator = Validator::make(
            $request->all(),
            [
                "name" => ["required", "string"],
                "last_name" => ["nullable", "string"],
                "phone" => ["required", "regex:/(\+7)[0-9]{10}/"],
                "coffeePot_id" => ["required", "exists:coffee_pots,id"]
            ]
        );
        
        if ($validator->fails()) {
            return $this->sendErrorResponse(
                $validator->errors()->all()
            );
        }

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

        $coffeePot = CoffeePot::find($request->coffeePot_id);

        UserCoffeePot::updateOrCreate(
            [
                "user_id" => $user->id
            ],
            [
                "coffee_pot_id" => $coffeePot->id
            ]
        );

        $this->data = [
            "user" => $user,
            "coffeePot" => $coffeePot
        ];
        
        return $this->sendResponse();
    }

    /**
     * Delete profile barista
     * 
     * @param int $id id barista
     * 
     * @return array
     */
    public function delete(int $id) : array
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