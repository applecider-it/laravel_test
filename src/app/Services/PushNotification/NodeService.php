<?php

namespace App\Services\PushNotification;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

use App\Models\PushNotification;

/**
 * プッシュ通知のnodeとの連携管理
 */
class NodeService
{
    const string PUSH_QUEUE_REDIS_KEY = 'push_queue';

    /**
     * PushNotificationモデルからnode用のRedisに積む
     * 
     * 現在のキューの数を返す。
     */
    public function push($message, PushNotification $notification): int
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
