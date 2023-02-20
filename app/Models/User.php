<?php

namespace App\Models;

use App\Support\Traits\UserRoleTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Database\Factories\UserFactory;
use Eloquent;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string|null $last_name
 * @property string $phone
 * @property string|null $phone_verified_at
 * @property string|null $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string $agreement
 * @property int $role_id
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read Collection|Bonus[] $bonuses
 * @property-read int|null $bonuses_count
 * @property-read Collection|Bonus[] $bonusesCreate
 * @property-read int|null $bonuses_create_count
 * @property-read Collection|Bonus[] $bonusesWrote
 * @property-read int|null $bonuses_wrote_count
 * @property-read Collection|\Laravel\Passport\Client[] $clients
 * @property-read int|null $clients_count
 * @property-read DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read Role|null $role
 * @property-read Collection|\Laravel\Passport\Token[] $tokens
 * @property-read int|null $tokens_count
 * @property-read UserCoffeePot|null $userCoffeePot
 * @property-read Collection|Bonus[] $activeBonuses
 * @property-read int|null $active_bonuses_count
 * @property-read Collection|Bonus[] $burntBonuses
 * @property-read int|null $burnt_bonuses_count
 * @property-read Collection|Bonus[] $usingBonuses
 * @property-read int|null $using_bonuses_count
 *
 * @method static UserFactory factory(...$parameters)
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereAgreement($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereLastName($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User wherePhone($value)
 * @method static Builder|User wherePhoneVerifiedAt($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereRoleId($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @mixin  Eloquent
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, UserRoleTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'phone',
        'phone_verified_at',
        'email',
        'email_verified_at',
        'password',
        'agreement',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'role_id',
        'agreement',
        'created_at',
        'updated_at',
        'role'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get active bonuses
     *
     * @return HasMany
     */
    public function activeBonuses() : HasMany
    {
        return $this->hasMany(Bonus::class)
            ->where('usage', '0')
            ->where(
                DB::raw("DATEDIFF(NOW(), created_at)"), "<", Bonus::getLifetime()
            );
    }

    /**
     * Get using bonuses
     *
     * @return HasMany
     */
    public function usingBonuses() : HasMany
    {
        return $this->hasMany(Bonus::class)->where('usage', '1');
    }

    /**
     * Get burnt bonuses
     *
     * @return HasMany
     */
    public function burntBonuses() : HasMany
    {
        return $this->hasMany(Bonus::class)
            ->where('usage', '0')
            ->where(
                DB::raw("DATEDIFF(NOW(), created_at)"), ">", Bonus::getLifetime()
            );
    }

    /**
     * Relationship all user bonuses
     *
     * @return HasMany
     */
    public function bonuses() : HasMany
    {
        return $this->hasMany(Bonus::class);
    }

    /**
     * Relationship role
     *
     * @return BelongsTo
     */
    public function role() : BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get bonuses created by this user
     *
     * @return HasMany
     */
    public function bonusesCreate() : HasMany
    {
        return $this->hasMany(Bonus::class, "user_id_create", "id");
    }

    /**
     * Get bonuses wrote by this user
     *
     * @return HasMany
     */
    public function bonusesWrote() : HasMany
    {
        return $this->hasMany(Bonus::class, "user_id_wrote", "id");
    }

    /**
     * Relationship user coffee pot
     *
     * @return HasOne
     */
    public function userCoffeePot() : HasOne
    {
        return $this->hasOne(UserCoffeePot::class);
    }

    /**
     * Relationship
     *
     * @return HasMany
     */
    public function feedbacks() : HasMany
    {
        return $this->hasMany(Feedback::class);
    }

    /**
     * Return last message
     *
     * @return HasMany
     */
    public function messages() : HasMany
    {
        return $this->hasMany(Message::class);
    }
}
