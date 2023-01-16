<?php

/**
 * Profile service
 * php version 8.1.2
 * 
 * @category Services
 * 
 * @author DmitryKoryagin <kor.dima97@maiol.ru>
 */
namespace App\Service;

use App\Models\User;
use App\Support\Helper;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
 * @author DmitryKoryagin <kor.dima97@email.ru>
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
     * @param Request $request object Request class
     * 
     * @return array
     */
    public function updateName(object $request) : array
    {
        $validator = Validator::make(
            $request->all(), 
            [
                "name" => ["request", 'min:5', 'string']
            ]
        );

        if ($validator->fails()) {
            return $this->sendErrorResponse(
                $validator->errors()->all()
            );
        }

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
     * @param Request $request object Request class
     * 
     * @return array
     */
    public function updatePhone(object $request) : array
    {
        $phone_regex = config('param_config.phone_regex');

        if ($request->phone) {
            $request->phone = Helper::editPhoneNumber($request->phone);
        }

        $validator = Validator::make(
            $request->all(), 
            [
                "phone" => ["request", "regex:/$phone_regex/", "unique"]
            ]
        );

        if ($validator->fails()) {
            return $this->sendErrorResponse(
                $validator->errors()->all()
            );
        }

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
     * @param Request $request object Request class
     *
     * @return array
     */
    public function updateEmail(object $request) : array
    {
        $validator = Validator::make(
            $request->all(), 
            [
                "email" => ["request", 'email', 'unique']
            ]
        );

        if ($validator->fails()) {
            return $this->sendErrorResponse(
                $validator->errors()->all()
            );
        }

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
     * @param Request $request object Request class
     * 
     * @return array
     */
    public function newPassword(object $request) : array
    {
        $validator = Validator::make(
            $request->all(), 
            [
                "password" => ["required", "between:8, 255" , "confirmed"],
            ]
        );

        if ($validator->fails()) {
            return $this->sendErrorResponse($validator->errros()->all());
        } 

        $user = auth()->user();

        $user->password = Hash::make($request->password);

        $user->save;

        $this->data = [
            "message" => "Пароль изменен"
        ];
        
        return $this->sendResponse();
    }
}