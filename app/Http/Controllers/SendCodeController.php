<?php

namespace App\Http\Controllers;

use App\Http\Requests\Code\EmailReqeust;
use App\Http\Requests\Code\PhoneRequest;
use App\Services\CodeService;
use Illuminate\Http\JsonResponse;

class SendCodeController extends BaseController
{
    /**
     * Service connection
     *
     * @param PhoneService $service Stores in a service
     */
    public function __construct(protected CodeService $service)
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

    /**
     * Sending code
     *
     * @param EmailReqeust $request
     * 
     * @return JsonResponse
     */
    public function sendMailCode(EmailReqeust $request) : JsonResponse
    {
        return $this->sendResponse(
            $this->service->sendMailCode($request)
        );
    }
}
