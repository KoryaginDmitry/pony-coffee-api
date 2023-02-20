<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Database\Factories\FeedbackFactory;
use Illuminate\Database\Eloquent\Collection;
use Eloquent;

/**
 * App\Models\Feedback
 *
 * @property int $id
 * @property string|null $grade
 * @property int $user_id
 * @property int $coffee_pot_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read Collection|Message[] $messages
 * @property-read int|null $messages_count
 * @property-read CoffeePot|null $coffeePot
 * @property-read User|null $user
 *
 * @method static Builder|Feedback newModelQuery()
 * @method static Builder|Feedback newQuery()
 * @method static Builder|Feedback query()
 * @method static Builder|Feedback whereCoffeePotId($value)
 * @method static Builder|Feedback whereCreatedAt($value)
 * @method static Builder|Feedback whereGrade($value)
 * @method static Builder|Feedback whereId($value)
 * @method static Builder|Feedback whereUpdatedAt($value)
 * @method static Builder|Feedback whereUserId($value)
 * @method static FeedbackFactory factory(...$parameters)
 * @mixin  Eloquent
 */
class Feedback extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'grade',
        'user_id',
        'coffee_pot_id',
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
     * HasMany Messages
     *
     * @return HasMany
     */
    public function messages() : HasMany
    {
        return $this->hasMany(Message::class);
    }

    /**
     * HasOne coffeePot
     *
     * @return BelongsTo
     */
    public function coffeePot() : BelongsTo
    {
        return $this->belongsTo(CoffeePot::class);
    }

    /**
     * Relationship
     *
     * @return BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
