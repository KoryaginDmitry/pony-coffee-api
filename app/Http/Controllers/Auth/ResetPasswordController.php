<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Code\EmailRequest;
use App\Http\Requests\Code\PasswordResetRequest;
use App\Services\Auth\ResetPasswordService;
use Illuminate\Http\JsonResponse;

/**
 * ResetPasswordController class
 *
 * @category Controllers
 *
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
class ResetPasswordController extends Controller
{
    public function __construct(protected ResetPasswordService $service )
    {

    }

    /**
     * Sends a password reset link
     *
     * @param EmailRequest $request
     *
     * @return JsonResponse
     */
    public function forgotPassword(EmailRequest $request) : JsonResponse
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
