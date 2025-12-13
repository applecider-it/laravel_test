<?php

namespace App\Services\WebSocket;

use Illuminate\Support\Facades\Redis;

/**
 * WebSocketのシステム管理
 */
class SystemService
{
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

        Redis::publish(config('myapp.ws_broadcast_redis_publish_channel'), json_encode($sendData));
    }
}
