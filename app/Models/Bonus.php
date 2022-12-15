<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bonus extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id_create',
        'user_id',
        'user_id_wrote',
        'usage',
    ];
}
