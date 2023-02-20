<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;
use Database\Factories\CoffeePotFactory;
use Illuminate\Support\Carbon;
use Eloquent;

/**
 * App\Models\CoffeePot
 *
 * @property int $id
 * @property string|null $name
 * @property string $address
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read Collection|UserCoffeePot[] $userCoffeePot
 * @property-read int|null $user_coffee_pot_count
 *
 * @method static Builder|CoffeePot newModelQuery()
 * @method static Builder|CoffeePot newQuery()
 * @method static Builder|CoffeePot query()
 * @method static Builder|CoffeePot whereAddress($value)
 * @method static Builder|CoffeePot whereCreatedAt($value)
 * @method static Builder|CoffeePot whereId($value)
 * @method static Builder|CoffeePot whereName($value)
 * @method static Builder|CoffeePot whereUpdatedAt($value)
 * @method static CoffeePotFactory factory(...$parameters)
 * @mixin  Eloquent
 */
class CoffeePot extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'address',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'updated_at'
    ];

    /**
     * Relationship
     *
     * @return HasMany
     */
    public function userCoffeePot(): HasMany
    {
        return $this->hasMany(UserCoffeePot::class);
    }

    /**
     * Relationship
     *
     * @return HasMany
     */
    public function feedbacks() : HasMany
    {
        return $this->hasMany(Feedback::class);
    }
}
