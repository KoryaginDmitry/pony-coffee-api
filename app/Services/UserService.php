<?php

namespace App\Services;

use App\Http\Requests\User\ProfileEmailRequest;
use App\Http\Requests\User\ProfileNameRequest;
use App\Http\Requests\User\ProfilePasswordRequest;
use App\Http\Requests\User\ProfilePhoneRequest;
use App\Http\Requests\User\UserCreateRequest;
use App\Models\User;
use App\Support\Traits\DataPrepareTrait;

/**
 * UserController class
 *
 * @category Controllers
 *
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
class UserService extends BaseService
{
    use DataPrepareTrait;

    /**
     * Update user
     *
     * @param array $data data for update user
     *
     * @return User
     */
    private function _update(array $data) : User
    {
        $user = User::find(auth()->id());

        $user->update($data);

        return $user;
    }

    /**
     * Get users and relationship bonuses for barista profile
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
     * Creating a user through a barista profile
     *
     * @param UserCreateRequest $request
     *
     * @return array
     */
    public function userCreate(UserCreateRequest $request) : array
    {
        $this->data = [
            'user' => User::create(
                $request->safe()->except('code')
            )
        ];

        $this->code = 201;

        return $this->sendResponse();
    }

    /**
     * Get auth user
     *
     * @return array
     */
    public function authUser() : array
    {
        $this->data = [
            'user' => auth()->user()
        ];

        return $this->sendResponse();
    }

    /**
     * Update name auth user
     *
     * @param ProfileNameRequest $request
     *
     * @return array
     */
    public function updateName(ProfileNameRequest $request) : array
    {
        $this->data = [
            'user' => $this->_update(
                $request->validated()
            )
        ];

        return $this->sendResponse();
    }

    /**
     * Update phone auth user
     *
     * @param ProfilePhoneRequest $request
     *
     * @return array
     */
    public function updatePhone(ProfilePhoneRequest $request) : array
    {
        $this->data = [
            'user' => $this->_update(
                $request->safe()->except('code')
            )
        ];

        return $this->sendResponse();
    }

    /**
     * Update email auth user
     *
     * @param ProfileEmailRequest $request
     *
     * @return array
     */
    public function updateEmail(ProfileEmailRequest $request) : array
    {
        $this->data = [
            'user' => $this->_update(
                $request->safe()->except('code')
            )
        ];

        return $this->sendResponse();
    }

    /**
     * Update password auth user
     *
     * @param ProfilepasswordRequest $request
     *
     * @return array
     */
    public function newPassword(ProfilePasswordRequest $request) : array
    {
        $user = User::find(auth()->id());

        $user->update(
            $this->passwordHash($request->validated())
        );

        $this->data = [
            "message" => "Пароль изменен"
        ];

        return $this->sendResponse();
    }
}
