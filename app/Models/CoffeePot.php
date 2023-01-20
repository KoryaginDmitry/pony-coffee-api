<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\CoffeePot
 *
 * @property int $id
 * @property string|null $name
 * @property string $address
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|CoffeePot newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CoffeePot newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CoffeePot query()
 * @method static \Illuminate\Database\Eloquent\Builder|CoffeePot whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CoffeePot whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CoffeePot whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CoffeePot whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CoffeePot whereUpdatedAt($value)
 * @mixin  \Eloquent
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
     * Relation userCoffeePot
     *
     * @return HasMany
     */
    public function userCoffeePot() : HasMany
    {
        return $this->hasMany(UserCoffeePot::class);
    }
}
