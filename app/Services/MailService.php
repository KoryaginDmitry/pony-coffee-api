<?php

/**
 * Home service
 * php version 8.1.2
 * 
 * @category Services
 * 
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
namespace App\Services;

use App\Mail\MailVerification;
use Illuminate\Support\Facades\Mail;

/**
 * HomeService class
 * 
 * @method array get()
 * 
 * @category Services
 * 
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
class MailService extends BaseService
{
    public function send($request)
    {
        Mail::to($request->email)->send(new MailVerification('new message'));

        return $this->sendResponse();
    }
}