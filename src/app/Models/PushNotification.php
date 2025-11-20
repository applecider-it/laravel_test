<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * プッシュ通知登録情報モデル
 * 
 * ドキュメント
 * /documents/Models/PushNotification.md
 */
class PushNotification extends Model
{
    protected $fillable = [
        'endpoint',
        'p256dh',
        'auth',
    ];
}
