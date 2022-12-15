<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCoffeePot extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'coffee_pot_id',
    ];

    public function coffeePot()
    {
        return $this->belongsTo(CoffeePot::class);
    }
}
