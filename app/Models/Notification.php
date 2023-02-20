<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Database\Factories\NotificationFactory;
use Eloquent;

/**
 * App\Models\Notification
 *
 * @property int $id
 * @property string $site
 * @property string $telegram
 * @property string $text
 * @property string|null $users_read_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $email
 *
 * @method static Builder|Notification newModelQuery()
 * @method static Builder|Notification newQuery()
 * @method static Builder|Notification query()
 * @method static Builder|Notification whereCreatedAt($value)
 * @method static Builder|Notification whereId($value)
 * @method static Builder|Notification whereSite($value)
 * @method static Builder|Notification whereTelegram($value)
 * @method static Builder|Notification whereText($value)
 * @method static Builder|Notification whereUpdatedAt($value)
 * @method static Builder|Notification whereUsersReadId($value)
 * @method static NotificationFactory factory(...$parameters)
 * @method static Builder|Notification whereEmail($value)
 * @mixin  Eloquent
 */
class Notification extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'site',
        'telegram',
        'text',
        'user_read_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'users_read_id',
        'updated_at'
    ];
}
