<?php

namespace App\Support\Classes\SendCode;

use App\Support\Interfaces\CodeInterface;
use App\Support\Traits\SendHttpRequest;
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Client\RequestException;

/**
 * PhoneCode class
 *
 * @category Support
 *
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
class PhoneCode implements CodeInterface
{
    use SendHttpRequest;

    /**
     * Call to phone number
     *
     * @param $request
     * @return void
     * @throws RequestException
     */
    public function sendCode($request): void
    {
        $api_id = config('services.sms.api_id');

        $this->sendRequest(
            'https://sms.ru/sms/code/call',
            [
                'api_id' => $api_id,
                'phone' => $request->phone,
                'ip' => $request->ip(),
            ]
        );

        Redis::command('set', [$request->phone, $this->body->code, "EX", "600"]);
    }
}
