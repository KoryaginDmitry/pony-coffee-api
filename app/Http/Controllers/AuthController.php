<?php
/**
 * Auth controller
 * php version 8.1.2
 * 
 * @category Controllers
 * 
 * @author DmitryKoryagin <kor.dima97@maiol.ru>
 */
namespace App\Http\Controllers;

use App\Service\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * AuthController class
 * 
 * @method JsonResponse login()
 * @method JsonResponse register()
 * @method JsonResponse logout()
 * @method JsonResponse login()
 * 
 * @category Controllers
 * 
 * @author DmitryKoryagin <kor.dima97@email.ru>
 */
class AuthController extends BaseController
{
    /**
     * Server connection
     *
     * @param AuthService $service comment connection service class
     */
    public function __construct(protected AuthService $service)
    {
        
    }

    /**
     * Login
     *
     * @param Request $request comment Request class odject
     * 
     * @return JsonResponse
     */
    public function login(Request $request) : JsonResponse
    {   
        return $this->sendResponse(
            $this->service->login($request)
        );
    }

    /**
     * Register
     *
     * @param Request $request comment Request class odject
     * 
     * @return JsonResponse
     */
    public function register(Request $request) : JsonResponse
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
