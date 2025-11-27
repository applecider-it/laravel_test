<?php

namespace App\Services\WebSocket;

use Firebase\JWT\JWT;
use WebSocket\Client;

/**
 * WebSocketのシステム管理
 */
class SystemService
{
    /** システムからの送信と判別するためのID。ユーザーの場合はIDが数値になる。 */
    public const SYSTEM_ID = 'system';

    public function __construct(
        private AuthService $authService
    ) {}

    /**
     * WebSocketにシステム管理者からの送信
     * 
     * 接続後すぐに閉じる
     */
    public function sendSystemData(string $channel, array $data)
    {
        $sendData = [
            "data" => $data,
        ];

        $token = $this->authService->createSystemJwt();

        $host = config('myapp.ws_server_host');
        $client = new Client("ws://{$host}?token={$token}&channel={$channel}");
        $client->send(json_encode($sendData));
        $response = $client->receive();
        $client->close();

        return $response;
    }
}
