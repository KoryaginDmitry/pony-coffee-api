<?php

namespace App\Http\Controllers;

use App\Service\ProfileService;
use Illuminate\Http\Request;


class ProfileController extends Controller
{
    public function __construct(protected ProfileService $service)
    {
        
    }

    public function getUser()
    {
        return response()->json([
            "user" => $this->service->user()
        ], 200);
    }

    public function update(Request $request)
    {   
        $response = $this->service->update($request);

        return response()->json($response['body'], $response['code']);
    }
}
