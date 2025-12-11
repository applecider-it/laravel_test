<?php

namespace App\Services\WebSocket;

use Illuminate\Support\Facades\Redis;

/**
 * WebSocketのシステム管理
 */
class SystemService
{
    private const BROADCAST_REDIS_PUBLISH_CHANNEL = 'broadcast';

    public function __construct() {}

    /**
     * RedisにWebSocketサーバー連携情報出力
     */
    public function publish(string $channel, array $data)
    {
        $sendData = [
            'channel' => $channel,
            'data' => $data,
        ];

        Redis::publish(self::BROADCAST_REDIS_PUBLISH_CHANNEL, json_encode($sendData));
    }
}
