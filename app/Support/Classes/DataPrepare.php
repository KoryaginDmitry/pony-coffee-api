<?php

namespace App\Support\Classes;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * DataPrepare class
 *
 * @category Support
 *
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
class DataPrepare
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
