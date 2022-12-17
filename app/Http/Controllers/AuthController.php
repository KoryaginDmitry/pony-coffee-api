<?php

namespace App\Http\Controllers;

use App\Service\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(protected AuthService $service)
    {
        
    }

    public function login(Request $request)
    {   
        $data = $this->service->login($request);

        return response()->json($data['body'], $data['code']);
    }

    public function register(Request $request)
    {
        $data = $this->service->register($request);

        return response()->json($data['body'], $data['code']);
    }

    public function logout()
    {
        
    }
}
