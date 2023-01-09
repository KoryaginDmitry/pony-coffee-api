<?php
/**
 * Auth service
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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

/**
 * AuthService class
 * 
 * @method array login()
 * @method array register()
 * @method array logout()
 * @method array login()
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
class AuthService extends BaseService
{
    /**
     * Authorization method
     * 
     * @param object $request object Request method
     * 
     * @return mixed
     */
    public function login(object $request) : mixed
    {   
        $validator = Validator::make(
            $request->all(), 
            [
                "phone" => [
                    "required",
                    "regex:/((\+7)|8)[0-9]{10}/",
                    "exists:users"
                ],
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
     * @return mixed
     */
    public function register(object $request) : mixed
    {
        $validator = Validator::make(
            $request->all(),
            [
                "name" => ["required", "string", "max:255"],
                "phone" => ["required", "regex:/(\+7)[0-9]{10}/", "unique:users"],
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
                "phone" => $request->phone,
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
     * @return mixed
     */ 
    public function logout() : mixed
    {
        DB::table('oauth_access_tokens')
            ->where('user_id', auth()->id())
            ->delete();

        $this->code = 204;

        return $this->sendResponse();
    }
}