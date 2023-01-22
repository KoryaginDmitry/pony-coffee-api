<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Phone extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'phone',
        'confirmation',
        'phone_verified_at'
    ];

    /**
     * Relationship
     *
     * @return HasMany
     */
    public function codes() : HasMany
    {
        return $this->hasMany(PhoneCode::class);
    }
}
