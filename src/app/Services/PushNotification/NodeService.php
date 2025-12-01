<?php

namespace App\Services\PushNotification;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

use App\Models\User;
use App\Models\PushNotification;

/**
 * プッシュ通知のnodeとの連携管理
 */
class NodeService
{
    const string PUSH_QUEUE_REDIS_KEY = 'push_queue';

    /**
     * Userモデルからnode用のRedisに積む
     * 
     * 現在のキューの数を返す。
     */
    public function pushByUser($message, User $user): int
    {
        $pushNotifications = $user->pushNotifications()->take(3)->get();

        $cnt = 0;
        foreach ($pushNotifications as $pushNotification) {
            $cnt = $this->pushByPushNotification(
                $message,
                $pushNotification
            );
        }

        return $cnt;
    }

    /**
     * PushNotificationモデルからnode用のRedisに積む
     * 
     * 現在のキューの数を返す。
     */
    private function pushByPushNotification($message, PushNotification $notification): int
    {
        $data = [
            'message' => $message,
            'endpoint' => $notification->endpoint,
            'p256dh' => $notification->p256dh,
            'auth' => $notification->auth
        ];

        //print_r($data);

        return Redis::rpush(self::PUSH_QUEUE_REDIS_KEY, json_encode($data));
    }

    /**
     * キューをクリアする
     */
    public function clear(): void
    {
        Redis::del(self::PUSH_QUEUE_REDIS_KEY);
    }
}
