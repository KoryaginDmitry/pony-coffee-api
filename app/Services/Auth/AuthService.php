<?php

namespace App\Services\Auth;

use App\Http\Requests\Auth\LoginEmailRequest;
use App\Http\Requests\Auth\LoginPhoneRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Services\BaseService;
use App\Support\Traits\DataPrepareTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * AuthService class
 *
 * @category Services
 *
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
class AuthService extends BaseService
{
    use DataPrepareTrait;

    /**
     * Creates a token for the user and returns data for the response
     *
     * @param User $user
     *
     * @return array
     */
    private function _createResponse(User $user) : array
    {
        if (env('APP_ENV') !== 'testing') {
            $this->data = $user->createToken('userToken');
        }

        $this->code = 201;

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
        return $this->_createResponse(
            User::where('phone', $request->phone)->first()
        );
    }

    /**
     * Login to the site with an email and code
     *
     * @param LoginEmailRequest $request
     *
     * @return array
     */
    public function emailLogin(LoginEmailRequest $request) : array
    {
        return $this->_createResponse(
            User::where('email', $request->email)->first()
        );
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
        return $this->_createResponse(
            User::create(
                $this->passwordHash($request->safe()->except('code'))
            )
        );
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
