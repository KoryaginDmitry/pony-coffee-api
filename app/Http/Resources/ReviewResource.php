<?php

namespace App\Http\Resources;

use App\Models\Review;
use Fillincode\Swagger\Attributes\Property;
use Fillincode\Swagger\Attributes\Resource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Review */
#[Property('id', 'integer', 'ID отзыва')]
#[Property('coffee_pot_id', 'integer', 'ID кофейни')]
#[Property('user_id', 'integer', 'ID автора отзыва')]
#[Property('grade', 'integer', 'Оценка')]
#[Property('text', 'string', 'Текст отзыва')]
#[Resource(UserResource::class)]
#[Resource(CoffeePotResource::class)]
class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'coffee_pot_id' => $this->coffee_pot_id,
            'user_id' => $this->user_id,
            'grade' => $this->grade,
            'text' => $this->text,
            'user' => UserResource::make($this->whenLoaded('user')),
            'coffeePot' => CoffeePotResource::make($this->whenLoaded('coffeePot')),
        ];
    }
}
