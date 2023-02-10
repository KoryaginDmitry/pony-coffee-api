<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Code\EmailReqeust;
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
class SendCodeController extends BaseController
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
     *
     * @return JsonResponse
     */
    public function call(PhoneRequest $request) : JsonResponse
    {
        return $this->sendResponse(
            $this->service->sendCode(new PhoneCode(), $request)
        );
    }

    /**
     * Send code to email
     *
     * @param EmailReqeust $request
     *
     * @return JsonResponse
     */
    public function sendEmailCode(EmailReqeust $request) : JsonResponse
    {
        return $this->sendResponse(
            $this->service->sendCode(new EmailCode(), $request)
        );
    }


}
