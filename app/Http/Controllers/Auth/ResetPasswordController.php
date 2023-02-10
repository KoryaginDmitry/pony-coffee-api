<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Code\EmailReqeust;
use App\Http\Requests\Code\PasswordResetRequest;
use App\Services\auth\ResetPasswordService;
use Illuminate\Http\JsonResponse;

/**
 * ResetPasswordController class
 *
 * @category Controllers
 *
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
class ResetPasswordController extends BaseController
{
    public function __construct(protected ResetPasswordService $service )
    {

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