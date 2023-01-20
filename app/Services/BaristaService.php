<?php

/**
 * Barista service
 * php version 8.1.2
 * 
 * @category Services
 * 
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 * 
 */
namespace App\Services;

use App\Http\Requests\Barista\CreateRequest;
use App\Http\Requests\Barista\UpdateRequest;
use App\Models\CoffeePot;
use App\Models\User;
use App\Models\UserCoffeePot;
use Illuminate\Support\Facades\Hash;

/**
 * BaristaService class
 * 
 * @method array getBaristas()
 * @method array getBaristas(int $id)
 * @method array create(object $request)
 * @method array update(object $request, int $id)
 * @method array delete(int $id)
 * 
 * @category Services
 * 
 * @author DmitryKoryagin <kor.dima97@mail.ru>
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
     * @param User $barista barista user
     * 
     * @return array
     */
    public function getBarista(User $barista) : array
    {
        $coffeePots = CoffeePot::orderBy('created_at', "DESC")->get();

        $this->data = [
            "user" => $barista->fresh('userCoffeePot'),
            "coffeePots" => $coffeePots
        ];
        
        return $this->sendResponse();
    }

    /**
     * Create profile barista
     * 
     * @param CreateRequest $request object CreateRequest
     * 
     * @return array
     */
    public function create(CreateRequest $request) : array
    {
        $coffeePot = CoffeePot::find($request->coffeePot_id);

        $data = $request->safe()->except(['coffeePot_id']);
        
        $data['password'] = Hash::make($request->password);

        $barista = User::create(
            $data
        );
        
        $barista->userCoffeePot()->create(
            [
                'coffee_pot_id' => $coffeePot->id
            ]
        );

        $this->data = [
            "user" => $barista,
            "coffeePot" => $coffeePot
        ];

        $this->code = 201; 
        
        return $this->sendResponse();
    }

    /**
     * Update profile barista
     * 
     * @param UpdateRequest $request object UpdateRequest
     * @param User          $barista user barista
     * 
     * @return array
     */
    public function update(UpdateRequest $request, User $barista) : array
    {
        $barista->update(
            $request->safe()->except(['coffeePot_id'])
        );

        $coffeePot = CoffeePot::find($request->coffeePot_id);

        $barista->userCoffeePot()->updateOrCreate(
            [
                "coffee_pot_id" => $coffeePot->id
            ]
        );

        $this->data = [
            "user" => $barista,
            "coffeePot" => $coffeePot
        ];
        
        return $this->sendResponse();
    }

    /**
     * Delete profile barista
     * 
     * @param User $barista barista user
     * 
     * @return array
     */
    public function delete(User $barista) : array
    {
        $barista->delete();

        $this->code = 204;

        return $this->sendResponse();
    }
}