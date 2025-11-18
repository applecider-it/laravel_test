<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PushNotification extends Model
{
    protected $fillable = [
        'endpoint',
        'p256dh',
        'auth',
    ];
}
