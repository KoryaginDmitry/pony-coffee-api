<?php

namespace App\Models;

use Database\Factories\CoffeePotFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\CoffeePot
 *
 * @property int $id
 * @property string|null $name
 * @property string $address
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, User> $employers
 * @property-read int|null $employers_count
 * @property-read Collection<int, Review> $reviews
 * @property-read int|null $reviews_count
 *
 * @method static CoffeePotFactory factory($count = null, $state = [])
 * @method static Builder|CoffeePot newModelQuery()
 * @method static Builder|CoffeePot newQuery()
 * @method static Builder|CoffeePot query()
 * @method static Builder|CoffeePot whereAddress($value)
 * @method static Builder|CoffeePot whereCreatedAt($value)
 * @method static Builder|CoffeePot whereId($value)
 * @method static Builder|CoffeePot whereName($value)
 * @method static Builder|CoffeePot whereUpdatedAt($value)
 *
 * @mixin Eloquent
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

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function employers(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
