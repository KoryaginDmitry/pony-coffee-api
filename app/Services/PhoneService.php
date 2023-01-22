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
use App\Http\Requests\Phone\VerificationRequest;
use App\Models\Phone;
use App\Models\PhoneCode;

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
     * Send sms
     *
     * @param string $to      number phone
     * @param string $message text message
     * 
     * @return void
     */
    private function _sendMessage(string $to, string $message) : void
    {
        $id = config('param_config.sms_api_id');
        
        $message = urlencode($message);

        try {
            file_get_contents(
                "https://sms.ru/sms/send?api_id=$id&to=$to&msg=$message&json=1"
            );
        } catch (\Throwable $th) {
            //
        }
        
    } 
    /**
     * Sending confirmation code
     * 
     * @param PhoneRequest $request object PhoneRequest
     *
     * @return array
     */
    public function sendCode(PhoneRequest $request)
    {   
        $code = rand(1000, 9999);

        $this->_sendMessage($request->phone, $code);

        $phone = Phone::firstOrCreate(
            $request->validated()
        );

        $phone->codes()->create(
            [
                'code' => $code
            ]
        );

        $this->code = 201;

        return $this->sendResponse();
    }

    /**
     * Phone number verification during registration
     *
     * @param VerificationRequest $request object VerificationRequest
     * 
     * @return array
     */
    public function verification(VerificationRequest $request) : array
    {   
        $phone = Phone::where('phone', $request->phone)->first();

        $lastCode = PhoneCode::where('phone_id', $phone->id)->latest()->first();

        if ($lastCode->code != $request->code) {
            return $this->sendErrorResponse(['Код недействителен']);
        }

        $phone->confirmation = 1;
        
        $phone->user_id = null;

        $phone->save();

        $phone->codes()->delete();

        return $this->sendResponse();
    }
}