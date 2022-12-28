<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserCoffeePot
 *
 * @property int $id
 * @property int $user_id
 * @property int $coffee_pot_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\CoffeePot|null $coffeePot
 * @method static \Illuminate\Database\Eloquent\Builder|UserCoffeePot newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCoffeePot newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCoffeePot query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCoffeePot whereCoffeePotId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCoffeePot whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCoffeePot whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCoffeePot whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCoffeePot whereUserId($value)
 * @mixin \Eloquent
 */
class UserCoffeePot extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'coffee_pot_id',
    ];

    public function coffeePot()
    {
        return $this->belongsTo(CoffeePot::class);
    }
}
