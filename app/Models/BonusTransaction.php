<?php

namespace App\Models;

use App\Enums\BonusTranslationEnum;
use App\Observers\BonusTransactionObserver;
use Database\Factories\BonusTransactionFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\BonusTransaction
 *
 * @property int $id
 * @property int $user_id
 * @property int $barista_id
 * @property int $coffee_pot_id
 * @property BonusTranslationEnum $type
 * @property int $count
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User|null $barista
 * @property-read CoffeePot|null $coffeePot
 * @property-read User|null $user
 *
 * @method static BonusTransactionFactory factory($count = null, $state = [])
 * @method static Builder|BonusTransaction newModelQuery()
 * @method static Builder|BonusTransaction newQuery()
 * @method static Builder|BonusTransaction query()
 * @method static Builder|BonusTransaction whereBaristaId($value)
 * @method static Builder|BonusTransaction whereCoffeePotId($value)
 * @method static Builder|BonusTransaction whereCount($value)
 * @method static Builder|BonusTransaction whereCreatedAt($value)
 * @method static Builder|BonusTransaction whereId($value)
 * @method static Builder|BonusTransaction whereType($value)
 * @method static Builder|BonusTransaction whereUpdatedAt($value)
 * @method static Builder|BonusTransaction whereUserId($value)
 *
 * @mixin Eloquent
 */
#[ObservedBy(BonusTransactionObserver::class)]
class BonusTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'barista_id',
        'coffee_pot_id',
        'type',
        'count',
    ];

    protected $casts = [
        'type' => BonusTranslationEnum::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function barista(): BelongsTo
    {
        return $this->belongsTo(User::class, 'barista_id');
    }

    public function coffeePot(): BelongsTo
    {
        return $this->belongsTo(CoffeePot::class);
    }
}
