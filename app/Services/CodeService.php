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

use App\Http\Requests\Code\EmailReqeust;
use App\Http\Requests\Code\PhoneRequest;
use App\Mail\VerificateMail;
use Illuminate\Support\Facades\Mail;

/**
 * PhoneService class
 * 
 * @category Services
 * 
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
class CodeService extends BaseService
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
        
        session([$request->phone => $response->object()->code]);

        $this->code = 201;

        return $this->sendResponse();
    }

    /**
     * Send code verification
     *
     * @param EmailReqeust $request
     * 
     * @return array
     */
    public function sendMailCode(EmailReqeust $request) : array
    {
        $code = mt_rand(10000, 99999);

        session([$request->email => $code]);

        Mail::to($request->email)->send(new VerificateMail($code));

        return $this->sendResponse();
    }
}