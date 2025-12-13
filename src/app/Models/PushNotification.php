<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * プッシュ通知登録情報モデル
 * 
 * ドキュメント
 * /documents/Models/PushNotification.md
 */
class PushNotification extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'endpoint',
        'p256dh',
        'auth',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
