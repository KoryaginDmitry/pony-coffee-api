<?php

namespace App\Support\Classes\SendCode;

use App\Mail\VerificationMail;
use App\Support\Interfaces\CodeInterface;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;
use Exception;

/**
 * EmailCode class
 *
 * @category Support
 *
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
class EmailCode implements CodeInterface
{
    /**
     * Sending verification code to email
     *
     * @param $request
     * @return void
     * @throws Exception
     */
    public function sendCode($request): void
    {
        $code = random_int(10000, 99999);

        Redis::command('set', [$request->email, $code, "EX", "600"]);

        Mail::to($request->email)->send(new VerificationMail($code));
    }
}
