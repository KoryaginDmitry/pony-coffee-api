<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'sms',
        'site',
        'telegram',
        'text',
        'user_read_id',
    ];
}
