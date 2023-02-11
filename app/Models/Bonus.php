<?php

namespace App\Models;

use Carbon\Carbon;
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
 *
 * @property-read string $burnt
 * @property-read string $create_date
 * @property-read string $update_date
 *
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
 * @method static \Database\Factories\BonusFactory factory(...$parameters)
 * @mixin  \Eloquent
 */
class Bonus extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id_create',
        'user_id',
        'user_id_wrote',
        'usage',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'id',
        'updated_at'
    ];

    /**
     * Get create date attribute
     *
     * @return string
     */
    public function getCreateDateAttribute() : string
    {
        return $this->attributes['date'] = Carbon::create(
            $this->attributes['created_at']
        )->format('d-m-Y');
    }

    /**
     * Get date usage attribute
     *
     * @return string
     */
    public function getUpdateDateAttribute() : string
    {
        return $this->attributes['date'] = Carbon::create(
            $this->attributes['updated_at']
        )->format('d-m-Y');
    }

    /**
     * Get burnt attribute
     *
     * @return string
     */
    public function getBurntAttribute() : string
    {
        $dateDiff = Carbon::now()
            ->diffInDays(
                Carbon::create($this->attributes['created_at'])
            );

        return $this->attributes['date'] = !($dateDiff > self::getLifetime());
    }

    /**
     * Get lifetime bonus
     *
     * @return int
     */
    public static function getLifetime() : int
    {
        return config('options.bonus.lifetime');
    }

    /**
     * Get write-off quantity
     *
     * @return int
     */
    public static function getWriteOffQuantity() : int
    {
        return config('options.bonus.writeOffQuantity');
    }
}
