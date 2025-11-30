<?php

namespace App\Services\Workerman;

use Firebase\JWT\JWT;
use WebSocket\Client;

use App\Services\WebSocket\AuthService;

/**
 * WebSocket（WM）のシステム管理
 */
class SystemService
{
    public function __construct(
        private AuthService $authService
    ) {}

    /**
     * WebSocket（WM）にシステム管理者からの送信
     * 
     * 接続後すぐに閉じる
     */
    public function sendSystemData(string $channel, array $data)
    {
        $sendData = [
            "data" => $data,
        ];

        $token = $this->authService->createSystemJwt();

        $host = config('myapp.workerman_server_host');
        $client = new Client("ws://{$host}?token={$token}&channel={$channel}");
        $client->send(json_encode($sendData));
        $client->close();
    }
}
