<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Bonus
 *
 * @property int $id
 * @property int $user_id_create
 * @property int $user_id
 * @property int|null $user_id_wrote
 * @property string $usage
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Bonus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bonus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bonus query()
 * @method static \Illuminate\Database\Eloquent\Builder|Bonus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bonus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bonus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bonus whereUsage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bonus whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bonus whereUserIdCreate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bonus whereUserIdWrote($value)
 * @mixin \Eloquent
 */
class Bonus extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id_create',
        'user_id',
        'user_id_wrote',
        'usage',
    ];
}
