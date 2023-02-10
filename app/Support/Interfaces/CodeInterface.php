<?php

namespace App\Support\Interfaces;

/**
 * CodeInterface interface
 *
 * @category interfaces
 *
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
interface CodeInterface
{
    /**
     * Send code
     *
     * @param $request
     * @return void
     */
    public function sendCode($request):void;
}
