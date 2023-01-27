<?php

namespace App\Http\Controllers;

use App\Http\Requests\Phone\PhoneRequest;
use App\Http\Requests\Phone\VerificationRequest;
use App\Services\PhoneService;
use Illuminate\Http\JsonResponse;

class PhoneController extends BaseController
{
    /**
     * Service connection
     *
     * @param PhoneService $service Stores in a service
     */
    public function __construct(protected PhoneService $service)
    {
        
    }

    /**
     * Sending confirmation code
     *
     * @param PhoneRequest $request object PhoneRequest
     * 
     * @return JsonResponse
     */
    public function call(PhoneRequest $request) : JsonResponse
    {
        return $this->sendResponse(
            $this->service->call($request)
        );
    }
}
