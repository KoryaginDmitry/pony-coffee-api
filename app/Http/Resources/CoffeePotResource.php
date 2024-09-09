<?php

namespace App\Http\Resources;

use App\Models\CoffeePot;
use Fillincode\Swagger\Attributes\Property;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin CoffeePot */
#[Property('name', 'string', 'Название')]
#[Property('address', 'string', 'Адрес')]
class CoffeePotResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'address' => $this->address,
        ];
    }
}
