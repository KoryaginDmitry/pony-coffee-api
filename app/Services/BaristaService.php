<?php

namespace App\Services;

use App\Http\Requests\Barista\CreateRequest;
use App\Http\Requests\Barista\UpdateRequest;
use App\Models\CoffeePot;
use App\Models\User;
use App\Models\UserCoffeePot;
use App\Support\Classes\DataPrepare;

/**
 * BaristaService class
 *
 * @category Services
 *
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
class BaristaService extends BaseService
{
    /**
     * Get all baristas
     *
     * @return array
     */
    public function getBaristas() : array
    {
        $this->data = [
            "users" => User::where("role_id", "2")
                ->orderBy('created_at', "DESC")
                ->with("userCoffeePot.coffeePot")
                ->get(),

            "coffeePots" => CoffeePot::orderBy('created_at', "DESC")
                ->get()
        ];

        return $this->sendResponse();
    }

    /**
     * Get one barista
     *
     * @param User $barista
     *
     * @return array
     */
    public function getBarista(User $barista) : array
    {
        $this->data = [
            "user" => $barista->fresh('userCoffeePot.coffeePot'),
            "coffeePots" => CoffeePot::orderBy('created_at', "DESC")->get()
        ];

        return $this->sendResponse();
    }

    /**
     * Create profile barista
     *
     * @param CreateRequest $request
     *
     * @return array
     */
    public function create(CreateRequest $request) : array
    {
        $barista = User::create(
            DataPrepare::hashPassword(
                $request->safe()->except('coffee_pot_id')
            )
        );

        $barista->userCoffeePot()->create(
            $request->safe()->only('coffee_pot_id')
        );

        $this->data = [
            "user" => $barista,
            "coffeePot" => CoffeePot::find($request->coffee_pot_id)
        ];

        $this->code = 201;

        return $this->sendResponse();
    }

    /**
     * Update profile barista
     *
     * @param UpdateRequest $request
     * @param User          $barista
     *
     * @return array
     */
    public function update(UpdateRequest $request, User $barista) : array
    {
        $barista->update(
            $request->safe()->except('coffee_pot_id')
        );

        UserCoffeePot::updateOrCreate(
            [
                'user_id' => $barista->id
            ],
            [
                "coffee_pot_id" => $request->coffee_pot_id
            ]
        );

        $this->data = [
            "user" => $barista,
            "coffeePot" => CoffeePot::find($request->coffee_pot_id)
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
