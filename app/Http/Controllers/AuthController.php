<?php
/**
 * Auth controller
 * php version 8.1.2
 * 
 * @category Controllers
 * 
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

/**
 * AuthController class
 * 
 * @method JsonResponse login(LoginRequest $request)
 * @method JsonResponse register(RegisterRequest $request)
 * @method JsonResponse logout()
 * 
 * @category Controllers
 * 
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
class AuthController extends BaseController
{
    /**
     * Service connection
     *
     * @param AuthService $service Service variable
     */
    public function __construct(protected AuthService $service)
    {
        
    }

    /**
     * Login
     *
     * @param LoginRequest $request LoginRequest class odject
     * 
     * @return JsonResponse
     */
    public function login(LoginRequest $request) : JsonResponse
    {   
        return $this->sendResponse(
            $this->service->login($request)
        );
    }

    /**
     * Register
     *
     * @param RegisterRequest $request RegisterRequest class odject
     * 
     * @return JsonResponse
     */
    public function register(RegisterRequest $request) : JsonResponse
    {
        return $this->sendResponse(
            $this->service->register($request)
        );
    }

    /**
     * Logoout
     *
     * @return JsonResponse
     */
    public function logout() : JsonResponse
    {
        return $this->sendResponse(
            $this->service->logout()
        );
    }
}
