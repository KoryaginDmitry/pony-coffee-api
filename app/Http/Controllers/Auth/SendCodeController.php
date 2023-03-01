<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Code\EmailRequest;
use App\Http\Requests\Code\PhoneRequest;
use App\Services\Auth\SendCodeService;
use App\Support\Classes\SendCode\EmailCode;
use App\Support\Classes\SendCode\PhoneCode;
use Illuminate\Http\JsonResponse;

/**
 * SendCodeController class
 *
 * @category Controllers
 *
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
class SendCodeController extends Controller
{
    /**
     * Service connection
     *
     * @param SendCodeService $service
     */
    public function __construct(protected SendCodeService $service)
    {

    }

    /**
     * Makes a call to the specified number
     *
     * @param PhoneRequest $request
     * @param PhoneCode $sender
     * @return JsonResponse
     */
    public function call(PhoneRequest $request, PhoneCode $sender) : JsonResponse
    {
        return $this->sendResponse(
            $this->service->sendCode($sender, $request)
        );
    }

    /**
     * Send code to email
     *
     * @param EmailRequest $request
     * @param EmailCode $sender
     * @return JsonResponse
     */
    public function sendEmailCode(EmailRequest $request, EmailCode $sender) : JsonResponse
    {
        return $this->sendResponse(
            $this->service->sendCode($sender, $request)
        );
    }


}
