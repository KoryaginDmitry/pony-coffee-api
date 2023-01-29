<?php
/**
 * Auth service
 * php version 8.1.2
 * 
 * @category Services
 * 
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
namespace App\Services;

use App\Http\Requests\Auth\LoginPhoneRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Support\Helper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * AuthService class
 * 
 * @method array login(LoginRequest $request)
 * @method array register(RegisterRequest $request)
 * @method array logout()
 * 
 * @category Services
 * 
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
class AuthService extends BaseService
{
    /**
     * Authorization method
     * 
     * @param LoginRequest $request
     * 
     * @return array
     */
    public function login(LoginRequest $request) : array
    {   
        $user = User::where('phone', $request->phone)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->sendErrorResponse('Проверьте введенные данные');
        }

        $this->data = $user->createToken('userToken');
        
        return $this->sendResponse();
    }

    /**
     * Phone login
     *
     * @param LoginPhoneRequest $request
     * 
     * @return array
     */
    public function phoneLogin(LoginPhoneRequest $request) : array
    {
        $this->smsCodeCheck($request);

        $user = User::where('phone', $request->phone)->first();

        $this->data = $user->createToken('userToken');
        
        return $this->sendResponse();
    }

    /**
     * Registration
     * 
     * @param RegisterRequest $request
     * 
     * @return array
     */
    public function register(RegisterRequest $request) : array
    {
        $this->data = $request->session()->get($request->phone);
        return $this->sendResponse();
        
        $this->smsCodeCheck($request);
        
        $user = User::create(
            Helper::hashPassword($request->safe()->except('code'))
        );

        $this->data = $user->createToken('userToken');

        $this->code = 201;
        
        return $this->sendResponse();
    }

    /**
     * Logout
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