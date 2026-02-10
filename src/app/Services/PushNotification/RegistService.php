<?php

namespace App\Services\PushNotification;

use Illuminate\Support\Facades\Log;

use App\Models\User;

/**
 * プッシュ通知の登録管理
 */
class RegistService
{
    public function __construct() {}

    /**
     * Userモデルからnode用のRedisに積む
     * 
     * 現在のキューの数を返す。
     */
    public function registPushNotifications(User $user, string $endpoint, string $p256dh, string $auth): void
    {
        $user->pushNotifications()->create([
            'endpoint' => $endpoint,
            'p256dh' => $p256dh,
            'auth' => $auth,
        ]);
    }
}
