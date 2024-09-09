<?php

namespace App\Enums;

enum BonusTranslationEnum: string
{
    case Accrual = 'accrual';
    case WroteOff = 'write-off';

    public static function getValues(): array
    {
        foreach (self::cases() as $case) {
            $result[] = $case->value;
        }

        return $result ?? [];
    }
}
