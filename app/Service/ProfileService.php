<?php

/**
 * Profile service
 * php version 8.1.2
 * 
 * @category Services
 * 
 * @package Category
 * 
 * @author DmitryKoryagin <kor.dima97@maiol.ru>
 * 
 * @license http://href.com MIT
 * 
 * @link http://href.com
 */
namespace App\Service;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

/**
 * ProfileService class
 * 
 * @method mixed user()
 * @method mixed update()
 * @method mixed newPassword()
 * 
 * @category Services
 * 
 * @package Category
 * 
 * @author DmitryKoryagin <kor.dima97@email.ru>
 * 
 * @license http://href.com MIT
 * 
 * @link http://href.com
 */
class ProfileService extends BaseService
{
    /**
     * Get auth user
     *
     * @return mixed
     */
    public function user() : mixed
    {   
        $this->data = [
            'user' => auth()->user()
        ];
    
        return $this->sendResponse();
    }

    /**
     * Update auth user
     *
     * @param Request $request object Request class
     * 
     * @return mixed
     */
    public function update($request) : mixed
    {   
        $id = auth()->id();

        $validator = Validator::make(
            $request->all(), 
            [
                "name" => ["required", "string", "min:3"],
                "last_name" => ["nullable", "string"],
                "phone" => ["required", "regex:/(\+7)[0-9]{10}/", "unique:users,phone," . $id],
                "email" => ["nullable", "email", "unique:users,email," . $id]
            ]
        );

        if ($validator->fails()) {
            return $this->sendErrorResponse($validator->errors()->all());
        }   

        $user = User::find($id);
        
        if ($user->email != $request->email) {
            $user->email = $request->email;
            $user->email_verified_at = null;
        }

        if ($user->phone != $request->phone) {
            $user->phone = $request->phone;
            $user->phone_verified_at = null;
        }

        $user->name = $request->name;
        $user->last_name = $request->last_name ?: null;
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
     * @return mixed
     */
    public function newPassword($request) : mixed
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