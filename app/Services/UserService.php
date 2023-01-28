<?php

namespace App\Services;

use App\Http\Requests\User\UserCreateRequest;
use App\Models\User;

class UserService extends BaseService
{
    /**
     * Return users and relationship bonuses
     *
     * @return array
     */
    public function users() : array
    {
        $this->data = [
            "users" => User::where('role_id', 3)
                ->withCount('activeBonuses')
                ->get()
        ];

        return $this->sendResponse();
    }

    /**
     * Create user
     *
     * @param UserCreateRequest $request
     * 
     * @return array
     */
    public function userCreate(UserCreateRequest $request) : array
    {
        $this->data = [
            'user' => User::create($request->safe()->except('code'))
        ];

        return $this->sendResponse();
    }
}