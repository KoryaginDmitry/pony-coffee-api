<?php
/**
 * CodeVerificate service
 * php version 8.1.2
 * 
 * @category Services
 * 
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
namespace App\Services;

use App\Http\Requests\Code\EmailReqeust;
use App\Http\Requests\Code\PasswordResetRequest;
use App\Http\Requests\Code\PhoneRequest;
use App\Mail\VerificateMail;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

/**
 * CodeVerificateService class
 * 
 * @method array call(PhoneRequest $request)
 * @method array sendEmailCode(EmailReqeust $request)
 * @method array forgotPassword(EmailReqeust $request)
 * @method array resetPassword(PasswordResetRequest $request)
 * 
 * @category Services
 * 
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
class CodeVerificateService extends BaseService
{
    /**
     * Makes a call to the specified number
     * 
     * @param PhoneRequest $request
     *
     * @return array
     */
    public function call(PhoneRequest $request) : array
    {   
        $response = $this->sendHttpRequest(
            'https://sms.ru/sms/code/call',
            [
                'api_id' => config('services.sms.api_id'),
                'phone' => $request->phone,
                'ip' => $request->ip(),
            ]
        );
        
        session([$request->phone => $response->object()->code]);

        $this->code = 201;

        return $this->sendResponse();
    }

    /**
     * Send code to email
     *
     * @param EmailReqeust $request
     * 
     * @return array
     */
    public function sendEmailCode(EmailReqeust $request) : array
    {
        $code = mt_rand(10000, 99999);

        session([$request->email => $code]);

        Mail::to($request->email)->send(new VerificateMail($code));

        return $this->sendResponse();
    }

    /**
     * Sends a password reset link
     *
     * @param EmailReqeust $request
     * 
     * @return array
     */
    public function forgotPassword(EmailReqeust $request) : array
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
            function ($user, $password) {
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