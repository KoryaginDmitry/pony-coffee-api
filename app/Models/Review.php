<?php

namespace App\Models;

use Database\Factories\ReviewFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Review
 *
 * @property int $id
 * @property int $user_id
 * @property int $coffee_pot_id
 * @property int $grade
 * @property string $text
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read CoffeePot|null $coffeePot
 * @property-read User|null $user
 *
 * @method static ReviewFactory factory($count = null, $state = [])
 * @method static Builder|Review newModelQuery()
 * @method static Builder|Review newQuery()
 * @method static Builder|Review query()
 * @method static Builder|Review whereCoffeePotId($value)
 * @method static Builder|Review whereCreatedAt($value)
 * @method static Builder|Review whereGrade($value)
 * @method static Builder|Review whereId($value)
 * @method static Builder|Review whereText($value)
 * @method static Builder|Review whereUpdatedAt($value)
 * @method static Builder|Review whereUserId($value)
 *
 * @mixin Eloquent
 */
class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'coffee_pot_id',
        'grade',
        'text',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function coffeePot(): BelongsTo
    {
        return $this->belongsTo(CoffeePot::class);
    }
}
