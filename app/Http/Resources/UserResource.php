<?php

namespace App\Http\Resources;

use App\Models\User;
use Fillincode\Swagger\Attributes\Property;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin User */
#[Property('name', 'string', 'Имя')]
#[Property('last_name', 'string', 'Фамилия')]
class UserResource extends JsonResource
{
    protected ?string $token = null;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'last_name' => $this->last_name,
            'token' => $this->when($this->token, $this->token),
        ];
    }

    public function setToken(string $token): void
    {
        $this->token = $token;
    }
}
