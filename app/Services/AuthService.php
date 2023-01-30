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

use App\Http\Requests\Auth\LoginEmailRequest;
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
 * @method array _createResponse(User $user)
 * @method array login(LoginRequest $request)
 * @method array phoneLogin(LoginRequest $request)
 * @method array emailLogin(LoginEmailRequest $request)
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
     * Creates a token for the user and returns data for the response
     *
     * @param User $user
     * 
     * @return array
     */
    private function _createResponse(User $user) : array
    {
        $this->data = $user->createToken('userToken');

        return $this->sendResponse();
    }

    /**
     * Login to the site with a phone number and password
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

        return $this->_createResponse($user);
    }

    /**
     * Login to the site with a phone number and code
     *
     * @param LoginPhoneRequest $request
     * 
     * @return array
     */
    public function phoneLogin(LoginPhoneRequest $request) : array
    {
        $this->codeCheck($request->phone, $request->code); 

        $user = User::where('phone', $request->phone)->first();

        return $this->_createResponse($user);
    }

    /**
     * Login to the site with a email and code
     *
     * @param LoginEmailRequest $request
     * 
     * @return array
     */
    public function emailLogin(LoginEmailRequest $request) : array
    {
        $this->codeCheck($request->email, $request->code);

        $user = User::where('email', $request->email)->first();

        return $this->_createResponse($user);
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
        $this->codeCheck($request->phone, $request->code);
        
        $user = User::create(
            Helper::hashPassword($request->safe()->except('code'))
        );

        $this->code = 201;
        
        return $this->_createResponse($user);
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