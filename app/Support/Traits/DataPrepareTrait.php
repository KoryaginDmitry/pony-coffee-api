<?php

namespace App\Support\Traits;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

trait DataPrepareTrait
{
    /**
     * Removes extra characters from a phone number
     *
     * @param string|null $phone
     * @return string|null
     */
    public function editPhoneNumber(string|null $phone) : string|null
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
     * @param array $data
     * @return array
     */
    public function passwordHash(array $data) : array
    {
        if ($data['password']) {
            $data['password'] = Hash::make($data['password']);
        }

        return $data;
    }
}
