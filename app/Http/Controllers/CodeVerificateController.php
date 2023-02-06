<?php
/**
 * CodeVerificate controller
 * php version 8.1.2
 * 
 * @category Controllers
 * 
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
namespace App\Http\Controllers;

use App\Http\Requests\Code\EmailReqeust;
use App\Http\Requests\Code\PasswordResetRequest;
use App\Http\Requests\Code\PhoneRequest;
use App\Services\CodeVerificateService;
use Illuminate\Http\JsonResponse;

/**
 * CodeVerificateController class
 * 
 * @method JsonResponse call(PhoneRequest $request)
 * @method JsonResponse sendEmailCode(EmailReqeust $request)
 * @method JsonResponse forgotPassword(EmailReqeust $request)
 * @method JsonResponse resetPassword(PasswordResetRequest $request)
 * 
 * @category Controllers
 * 
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
class CodeVerificateController extends BaseController
{
    /**
     * Service connection
     *
     * @param PhoneService $service
     */
    public function __construct(protected CodeVerificateService $service)
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
            $this->service->call($request)
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
            $this->service->sendEmailCode($request)
        );
    }

    /**
     * Sends a password reset link
     *
     * @param EmailReqeust $request
     * 
     * @return JsonResponse
     */
    public function forgotPassword(EmailReqeust $request) : JsonResponse
    {
        return $this->sendResponse(
            $this->service->forgotPassword($request)
        );
    }

    /**
     * Reset password
     *
     * @param PasswordResetRequest $request
     * 
     * @return JsonResponse
     */
    public function resetPassword(PasswordResetRequest $request) : JsonResponse
    {
        return $this->sendResponse(
            $this->service->resetPassword($request)
        );
    }
}
