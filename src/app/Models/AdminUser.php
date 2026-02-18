<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * 管理者モデル
 * 
 * ドキュメント
 * /documents/Models/AdminUser.md
 */
class AdminUser extends Authenticatable
{
    protected $fillable = [
        'name',
        'email',
        'password'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at',
    ];
}
