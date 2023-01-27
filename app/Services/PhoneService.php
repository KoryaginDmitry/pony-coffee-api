<?php
/**
 * Phone service
 * php version 8.1.2
 * 
 * @category Services
 * 
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
namespace App\Services;

use App\Exceptions\LimitSmsException;
use App\Http\Requests\Phone\PhoneRequest;
use Illuminate\Support\Facades\DB;

/**
 * PhoneService class
 * 
 * @category Services
 * 
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
class PhoneService extends BaseService
{
    /**
     * Sending confirmation code
     * 
     * @param PhoneRequest $request object PhoneRequest
     *
     * @return array
     */
    public function sendCode(PhoneRequest $request) : array
    {   
        $code = mt_rand(1000, 9999);

        $request->session()->put($request->phone, $code);

        $this->sendHttpRequest(
            'https://sms.ru/sms/send',
            [
                'api_id' => config('services.sms.api_id'),
                'to' => $request->phone,
                'msg' => urlencode($code),
                'json' => 1
            ]
        );

        $this->code = 201;

        return $this->sendResponse();
    }
}