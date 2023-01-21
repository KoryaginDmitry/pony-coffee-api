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

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * AuthService class
 * 
 * @method array login(object $request)
 * @method array register(object $request)
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
     * @param object $request object LoginRequest
     * 
     * @return array
     */
    public function login(object $request) : array
    {   
        $user = User::firstWhere('phone', $request->phone);

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->sendErrorResponse('Проверьте введенные данные');
        }

        $token = $user->createToken('userToken');

        $this->data = $token;
        
        return $this->sendResponse();
    }

    /**
     * Registration method
     * 
     * @param object $request object RegisterRequest
     * 
     * @return array
     */
    public function register(object $request) : array
    {
        $request->password = Hash::make($request->password);
        
        $user = User::create(
            $request->validated()
        );

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