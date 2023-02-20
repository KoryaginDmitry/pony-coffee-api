<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Database\Factories\UserCoffeePotFactory;
use Eloquent;

/**
 * App\Models\UserCoffeePot
 *
 * @property int $id
 * @property int $user_id
 * @property int $coffee_pot_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read CoffeePot|null $coffeePot
 * @property-read User|null $user
 *
 * @method static Builder|UserCoffeePot newModelQuery()
 * @method static Builder|UserCoffeePot newQuery()
 * @method static Builder|UserCoffeePot query()
 * @method static Builder|UserCoffeePot whereCoffeePotId($value)
 * @method static Builder|UserCoffeePot whereCreatedAt($value)
 * @method static Builder|UserCoffeePot whereId($value)
 * @method static Builder|UserCoffeePot whereUpdatedAt($value)
 * @method static Builder|UserCoffeePot whereUserId($value)
 * @method static UserCoffeePotFactory factory(...$parameters)
 * @mixin  Eloquent
 */
class UserCoffeePot extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'coffee_pot_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'id',
        'user_id',
        'coffee_pot_id',
        'created_at',
        'updated_at',
    ];

    /**
     * Relationship coffee pot
     *
     * @return BelongsTo
     */
    public function coffeePot() : BelongsTo
    {
        return $this->belongsTo(CoffeePot::class);
    }

    /**
     * Relationship user
     *
     * @return BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
