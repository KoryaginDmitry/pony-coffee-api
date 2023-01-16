<?php
/**
 * Auth service
 * php version 8.1.2
 * 
 * @category Services
 * 
 * @author DmitryKoryagin <kor.dima97@maiol.ru>
 */
namespace App\Service;

use App\Models\User;
use App\Support\Helper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

/**
 * AuthService class
 * 
 * @method array login(object $request)
 * @method array register(object $request)
 * @method array logout()
 * 
 * @category Services
 * 
 * @author DmitryKoryagin <kor.dima97@email.ru>
 */
class AuthService extends BaseService
{
    /**
     * Authorization method
     * 
     * @param object $request object Request method
     * 
     * @return array
     */
    public function login(object $request) : array
    {   
        $phone_regex = config('param_config.phone_regex');

        $request->phone = Helper::editPhoneNumber($request->phone);

        $validator = Validator::make(
            $request->all(), 
            [
                "phone" => ["required", "regex:/$phone_regex/"],
                "password" => ["required", "string"]
            ]
        );

        $user = User::where('phone', $request->phone)->first();

        if ($validator->fails() || !Hash::check($request->password, $user->password)) {
            return $this->sendErrorResponse(['Проверьте введенные данные']);
        }

        $token = $user->createToken('userToken');

        $this->data = $token;
        
        return $this->sendResponse();
    }

    /**
     * Registration method
     * 
     * @param object $request object Request class
     * 
     * @return array
     */
    public function register(object $request) : array
    {
        $phone_regex = config('param_config.phone_regex');

        $request->phone = Helper::editPhoneNumber($request->phone);

        $validator = Validator::make(
            $request->all(),
            [
                "name" => ["required", "string", "max:255"],
                "phone" => ["required", "regex:/$phone_regex/", "unique:users"],
                "password" => ["required", "between:8, 255" , "confirmed"],
                "agreement" => ["required", "accepted"]
            ]
        );

        if ($validator->fails()) {
            return $this->sendErrorResponse($validator->errors()->all());
        }

        $user = User::create(
            [
                "name" => $request->name,
                "phone" => Helper::editPhoneNumber($request->phone),
                "password" => Hash::make($request->password),
                "agreement" => $request->agreement ? "1" : "0", 
                "role_id" => 3
            ]
        );

        if (!$user) {
            return $this->sendErrorResponse(['Ошибка регистрации'], 500);
        }

        $token = $user->createToken('userToken');

        $this->data = $token;

        $this->code = 201;
        
        return $this->sendResponse();
    }

    /**
     * Logout method
     * 
     * @return array
     */ 
    public function logout() : array
    {
        DB::table('oauth_access_tokens')
            ->where('user_id', auth()->id())
            ->delete();

        $this->code = 204;

        return $this->sendResponse();
    }
}