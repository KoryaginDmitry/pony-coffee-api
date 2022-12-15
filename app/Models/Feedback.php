<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'grade',
        'user_id',
        'coffee_pot_id',
    ];

    protected $hidden = [
        'id',
    ];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
