<?php

namespace App\Dto\Request\Review;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class ReviewDto extends DataTransferObject
{
    public int $grade;

    public string $text;

    public ?int $coffee_pot_id;

    /**
     * @throws UnknownProperties
     */
    public static function fromRequest(Request $request): ReviewDto
    {
        return new self([
            'grade' => $request->get('grade'),
            'text' => $request->get('text'),
            'coffee_pot_id' => $request->get('coffee_pot_id'),
        ]);
    }
}
