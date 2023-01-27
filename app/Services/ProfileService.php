<?php

/**
 * Profile service
 * php version 8.1.2
 * 
 * @category Services
 * 
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
namespace App\Services;

use App\Http\Requests\Profile\ProfileEmailRequest;
use App\Http\Requests\Profile\ProfileNameRequest;
use App\Http\Requests\Profile\ProfilePasswordRequest;
use App\Http\Requests\Profile\ProfilePhoneRequest;
use App\Models\Phone;
use App\Models\User;
use App\Support\Helper;
use Illuminate\Support\Facades\Hash;

/**
 * ProfileService class
 * 
 * @method array user()
 * @method array updateName(object $request)
 * @method array updatePhone(object $request)
 * @method array updateEmail(object $request)
 * @method array newPassword(object $request)
 * 
 * @category Services
 * 
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
class ProfileService extends BaseService
{
    /**
     * Get auth user
     *
     * @return array
     */
    public function user() : array
    {   
        $this->data = [
            'user' => auth()->user()
        ];
    
        return $this->sendResponse();
    }

    /**
     * Update name auth user
     *
     * @param ProfileNameRequest $request object ProfileNameRequest class
     * 
     * @return array
     */
    public function updateName(ProfileNameRequest $request) : array
    {
        $user = User::find(auth()->id());

        $this->data = [
            'user' => $user->update($request->validated())
        ];

        return $this->sendResponse();
    }

    /**
     * Update phone auth user
     *
     * @param ProfilePhoneRequest $request object ProfilePhoneRequest class
     * 
     * @return array
     */
    public function updatePhone(ProfilePhoneRequest $request) : array
    {
        $this->smsCodeCheck($request);

        $user = User::find(auth()->id());

        $this->data = [
            'phone' => $user->update($request->validated())
        ];

        return $this->sendResponse();
    }

    /**
     * Update email auth user
     * 
     * @param ProfileEmailRequest $request object ProfileEmailRequest class
     *
     * @return array
     */
    public function updateEmail(ProfileEmailRequest $request) : array
    {
        $user = User::find(auth()->id());

        $this->data = [
            'user' => $user->update($request->validated())
        ];

        return $this->sendResponse();
    }

    /**
     * Update password auth user
     *
     * @param ProfilepasswordRequest $request object ProfilepasswordRequest class
     * 
     * @return array
     */
    public function newPassword(ProfilePasswordRequest $request) : array
    {
        $user = User::find(auth()->id());

        $user->update(
            Helper::hashPassword($request->validated())
        );

        $this->data = [
            "message" => "Пароль изменен"
        ];
        
        return $this->sendResponse();
    }
}