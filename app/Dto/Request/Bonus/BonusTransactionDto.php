<?php

namespace App\Dto\Request\Bonus;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class BonusTransactionDto extends DataTransferObject
{
    public int $count;

    public int $user_id;

    public int $coffee_pot_id;

    /**
     * @throws UnknownProperties
     */
    public static function fromRequest(Request $request): BonusTransactionDto
    {
        return new self([
            'count' => $request->get('count'),
            'user_id' => $request->get('user_id'),
            'coffee_pot_id' => $request->get('coffee_pot_id'),
        ]);
    }
}
