<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Database\Factories\MessageFactory;
use Eloquent;

/**
 * App\Models\Message
 *
 * @property int $id
 * @property string $text
 * @property int $user_id
 * @property int $feedback_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $belongToAuthUser
 *
 * @property-read int $belong_to_auth_user
 *
 * @method static Builder|Message newModelQuery()
 * @method static Builder|Message newQuery()
 * @method static Builder|Message query()
 * @method static Builder|Message whereCreatedAt($value)
 * @method static Builder|Message whereFeedbackId($value)
 * @method static Builder|Message whereId($value)
 * @method static Builder|Message whereText($value)
 * @method static Builder|Message whereUpdatedAt($value)
 * @method static Builder|Message whereUserId($value)
 * @method static MessageFactory factory(...$parameters)
 * @mixin  Eloquent
 */
class Message extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'text',
        'user_id',
        'feedback_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'id',
        'user_id',
        'updated_at'
    ];

    /**
     * The virtual attributes
     *
     * @var array<int, string>
     */
    protected $appends = [
        'belongToAuthUser'
    ];

    /**
     * Whether the message belongs to an authorized user
     *
     * @return int
     */
    public function getBelongToAuthUserAttribute() : int
    {
        return $this->attributes['belongToAuthUser'] = auth()->id() === $this->attributes['user_id'];
    }
}
