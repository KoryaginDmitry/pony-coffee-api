<?php

/**
 * Helper
 * php version 8.1.2
 * 
 * @category Helper
 * 
 * @author DmitryKoryagin <kor.dima97@maiol.ru>
 */
namespace App\Support;

use Illuminate\Support\Str;

/**
 * Helpers class
 * 
 * @category Helper
 * 
 * @method static string editPhoneNumber(string $phone)
 * 
 * @author DmitryKoryagin <kor.dima97@email.ru>
 */

class Helper
{
    /**
     * Removes extra characters from a phone number
     *
     * @param string $phone number phone
     * 
     * @return string
     */
    public static function editPhoneNumber(string $phone)
    {
        $phone = Str::remove(['-','(',')'], $phone);

        if (mb_substr($phone, 0, 1) === '8') {
            $phone = Str::replaceFirst('8', '+7', $phone);
        }

        return $phone;
    }
}