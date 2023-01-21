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

use App\Http\Requests\Phone\PhoneRequest;

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
    public function sendCode(PhoneRequest $request)
    {
        $code = urlencode(
            rand(1000, 9999)
        );

        $id = config('param_config.sms_api_id');

        file_get_contents(
            "https://sms.ru/sms/send?api_id=$id&to=$$request->phone&msg=$code&json=1"
        );

        $this->data = [
            'data' => $code
        ];

        $this->code = 201;

        return $this->sendResponse();
    }
}