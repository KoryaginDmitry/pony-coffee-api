<?php

namespace App\Http\Controllers;

use App\Service\AuthService;
use Illuminate\Http\Request;

class AuthController extends BaseController
{
    public function __construct(protected AuthService $service)
    {
        
    }

    public function login(Request $request)
    {   
        return $this->sendResponse(
            $this->service->login($request)
        );
    }

    public function register(Request $request)
    {
        return $this->sendResponse(
            $this->service->register($request)
        );
    }

    public function logout()
    {
        return $this->sendResponse(
            $this->service->logout()
        );
    }
}
