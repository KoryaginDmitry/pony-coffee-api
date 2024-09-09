<?php

namespace App\Http\Resources;

use App\Models\BonusTransaction;
use Fillincode\Swagger\Attributes\Property;
use Fillincode\Swagger\Attributes\Resource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin BonusTransaction */
#[Property('count', 'integer', 'Количество бонус')]
#[Property('type', 'string', 'Тип транзакции')]
#[Property('created_at', 'date', 'Дата создания')]
#[Resource(CoffeePotResource::class, 'coffeePot')]
class BonusTransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'count' => $this->count,
            'type' => $this->type->value,
            'coffeePot' => CoffeePotResource::make($this->whenLoaded('coffeePot')),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
