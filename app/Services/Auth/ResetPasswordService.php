<?php

namespace App\Services\Auth;

use App\Http\Requests\Code\EmailRequest;
use App\Http\Requests\Code\PasswordResetRequest;
use App\Services\BaseService;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

/**
 * ResetPasswordService class
 *
 * @category Services
 *
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
class ResetPasswordService extends BaseService
{
    /**
     * Sends a password reset link
     *
     * @param EmailRequest $request
     *
     * @return array
     */
    public function forgotPassword(EmailRequest $request) : array
    {
        $status = Password::sendResetLink(
            $request->validated()
        );

        if ($status === Password::RESET_LINK_SENT) {
            $this->data = [
                'status' => __($status)
            ];

            return $this->sendResponse();
        }

        return $this->sendErrorResponse(['email' => __($status)]);
    }

    /**
     * Reset password
     *
     * @param PasswordResetRequest $request
     *
     * @return array
     */
    public function resetPassword(PasswordResetRequest $request) : array
    {
        $status = Password::reset(
            $request->validated(),
            static function ($user, $password) {
                $user->forceFill(
                    [
                        'password' => Hash::make($password)
                    ]
                )->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            $this->data = [
                'status' => __($status)
            ];

            return $this->sendResponse();
        }

        return $this->sendErrorResponse(['email' => [__($status)]]);
    }
}
