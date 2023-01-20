<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\UserCoffeePot
 *
 * @property int $id
 * @property int $user_id
 * @property int $coffee_pot_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\CoffeePot|null $coffeePot
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|UserCoffeePot newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCoffeePot newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCoffeePot query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCoffeePot whereCoffeePotId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCoffeePot whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCoffeePot whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCoffeePot whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCoffeePot whereUserId($value)
 * @mixin  \Eloquent
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
