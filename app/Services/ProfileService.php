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

use App\Models\User;
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
     * @param App\Http\Requests\Profile\ProfileNameRequest $request object Request class
     * 
     * @return array
     */
    public function updateName(object $request) : array
    {
        $user = User::find(auth()->id());

        $user->name = $request->name;

        $user->save();

        $this->data = [
            'user' => $user
        ];

        return $this->sendResponse();
    }

    /**
     * Update phone auth user
     *
     * @param App\Http\Requests\Profile\ProfilePhoneRequest $request object Request class
     * 
     * @return array
     */
    public function updatePhone(object $request) : array
    {
        $user = User::find(auth()->id());

        $user->phone = $request->phone;

        $user->phone_verified_at = null;

        $user->save();

        $this->data = [
            'user' => $user
        ];

        return $this->sendResponse();
    }

    /**
     * Update email auth user
     * 
     * @param App\Http\Requests\Profile\ProfileEmailRequest $request object Request class
     *
     * @return array
     */
    public function updateEmail(object $request) : array
    {
        $user = User::find(auth()->id());

        $user->email = $request->email;

        $user->email_verified_at = null;

        $user->save();

        $this->data = [
            'user' => $user
        ];

        return $this->sendResponse();
    }

    /**
     * Update password auth user
     *
     * @param App\Http\Requests\Profile\ProfilepasswordRequest $request object Request class
     * 
     * @return array
     */
    public function newPassword(object $request) : array
    {
        $user = User::find(auth()->id());

        $user->password = Hash::make($request->password);

        $user->save();

        $this->data = [
            "message" => "Пароль изменен"
        ];
        
        return $this->sendResponse();
    }
}