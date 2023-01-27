<?php

namespace App\Http\Controllers;

use App\Services\MailService;
use Illuminate\Http\Request;

class MailController extends BaseController
{
    public function __construct(protected MailService $service)
    {
        
    }

    public function sendCode(Request $request)
    {
        $this->sendResponse(
            $this->service->send($request)
        );
    }
}
