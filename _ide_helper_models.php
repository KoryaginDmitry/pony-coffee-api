<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
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
 * @property-read string $burnt
 * @property-read string $create_date
 * @property-read string $update_date
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
	class Bonus extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CoffeePot
 *
 * @property int $id
 * @property string|null $name
 * @property string $address
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CoffeePot newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CoffeePot newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CoffeePot query()
 * @method static \Illuminate\Database\Eloquent\Builder|CoffeePot whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CoffeePot whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CoffeePot whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CoffeePot whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CoffeePot whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserCoffeePot[] $userCoffeePot
 * @property-read int|null $user_coffee_pot_count
 */
	class CoffeePot extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Feedback
 *
 * @property int $id
 * @property string|null $grade
 * @property int $user_id
 * @property int $coffee_pot_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Message[] $messages
 * @property-read int|null $messages_count
 * @property-read \App\Models\CoffeePot|null $coffeePot
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback query()
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereCoffeePotId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereGrade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereUserId($value)
 * @mixin \Eloquent
 * @property-read \App\Models\User|null $user
 */
	class Feedback extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Message
 *
 * @property int $id
 * @property string $text
 * @property int $user_id
 * @property int $feedback_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $belongToAuthUser
 * @property-read int $belong_to_auth_user
 * @method static \Illuminate\Database\Eloquent\Builder|Message newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Message newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Message query()
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereFeedbackId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereUserId($value)
 * @mixin \Eloquent
 */
	class Message extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Notification
 *
 * @property int $id
 * @property string $site
 * @property string $telegram
 * @property string $text
 * @property string|null $users_read_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Notification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification query()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereSite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereTelegram($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereUsersReadId($value)
 * @mixin \Eloquent
 */
	class Notification extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Role
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\RoleFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string|null $last_name
 * @property string $phone
 * @property string|null $phone_verified_at
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string $agreement
 * @property int $role_id
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Bonus[] $bonuses
 * @property-read int|null $bonuses_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Bonus[] $bonusesCreate
 * @property-read int|null $bonuses_create_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Bonus[] $bonusesWrote
 * @property-read int|null $bonuses_wrote_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property-read int|null $clients_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\Role|null $role
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[] $tokens
 * @property-read int|null $tokens_count
 * @property-read \App\Models\UserCoffeePot|null $userCoffeePot
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAgreement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhoneVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class User extends \Eloquent {}
}

namespace App\Models{
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
 * @property-read \App\Models\User|null $user
 */
	class UserCoffeePot extends \Eloquent {}
}

