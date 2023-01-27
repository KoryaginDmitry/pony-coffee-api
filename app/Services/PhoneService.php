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

        $request->session()->put($request->phone, $response->object()->code);

        $this->code = 201;

        return $this->sendResponse();
    }
}