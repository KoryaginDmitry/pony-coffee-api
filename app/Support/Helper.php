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

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Helpers class
 * 
 * @category Helper
 * 
 * @method static string editPhoneNumber(string $phone)
 * @method static array hashPassword(array $data)
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
     * @return string|null
     */
    public static function editPhoneNumber(mixed $phone) : string|null
    {   
        if (!$phone) {
            return null;
        }

        $phone = Str::remove(['-','(',')'], $phone);

        $firstSim = mb_substr($phone, 0, 1);

        if ($firstSim === '8' || $firstSim === '7') {
            $phone = Str::replaceFirst($firstSim, '+7', $phone);
        }

        return $phone;
    }

    /**
     * Hashes the password parameter in the resulting array
     *
     * @param array $data array to hash
     * 
     * @return array
     */
    public static function hashPassword(array $data) : array
    {
        if ($data['password']) {
            $data['password'] = Hash::make($data['password']);
        }

        return $data;
    }
}