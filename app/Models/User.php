<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'phone',
        'email',
        'password',
        'agreement',
        'role_id',
        'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        //'password',
        'remember_token',
        'role_id',
        'role',
        'agreement'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function countActiveBonuses()
    {  
        $count = $this->bonuses()
                ->where("usage", "0")
                ->where(DB::raw("DATEDIFF(NOW(), created_at)"), "<", "30")
                ->get()
                ->count();
        
        return $count;
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function bonuses()
    {
        return $this->hasMany(Bonus::class);
    }

    public function bonusesCreate()
    {
        return $this->hasMany(Bonus::class, "user_id_create", "id");
    }

    public function bonusesWrote()
    {
        return $this->hasMany(Bonus::class, "user_id_wrote", "id");
    }

    public function userCoffeePot()
    {
        return $this->hasOne(UserCoffeePot::class);
    }
}
