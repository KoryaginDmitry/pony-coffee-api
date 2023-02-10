<?php

namespace App\Services\Auth;

use App\Services\BaseService;
use App\Support\Interfaces\CodeInterface;

/**
 * SendCodeService class
 *
 * @category Services
 *
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
class SendCodeService extends BaseService
{
    /**
     * @param CodeInterface $codeClass
     * @param $request
     * @return array
     */
    public function sendCode(CodeInterface $codeClass, $request) : array
    {
        $codeClass->sendCode($request);

        $this->code = 201;

        return $this->sendResponse();
    }
}
