<?php

namespace App\Services\Workerman;

use Workerman\Worker;

use Workerman\Connection\TcpConnection;
use Workerman\Protocols\Http\Request;

use App\Services\WebSocket\AuthService;

/**
 * Workermanサーバー管理
 */
class ServerService
{
    public function __construct(
        private AuthService $authService
    ) {}

    /**
     * サーバー起動
     */
    public function start()
    {
        $ws = new Worker("websocket://" . config('myapp.workerman_server_host'));

        // 全接続クライアントを格納
        $clients = [];

        $ws->onWebSocketConnect = function (TcpConnection $connection, Request $httpRequest) use (&$clients) {
            $token = $httpRequest->get('token');
            $channel = $httpRequest->get('channel');

            echo "token {$token}\n";
            echo "channel {$channel}\n";

            if (!$token) {
                $connection->close();
                return;
            }

            $payload = $this->authService->parseJwt($token);

            echo "payload:\n";
            print_r($payload);

            if ($payload) {
                // 認証成功
                $connection->user = $payload; // 接続にユーザー情報を保持
                $clients[$connection->id] = $connection;

                echo "Client {$connection->id} connected\n";
                echo "Client Count " . count($clients) . "\n";
            } else {
                $connection->close();
            }
        };

        $ws->onMessage = function (TcpConnection $connection, $str) use (&$clients) {
            echo "Received from {$connection->id}: $str\n";

            $sender = $connection->user;
            echo "Sender\n";
            print_r($sender);

            $receivedData = json_decode($str, true);

            print_r($receivedData);

            // 全クライアントにメッセージを送信（ブロードキャスト）
            foreach ($clients as $client) {
                echo "Send to {$client->user['name']} \n";
                $sendData = [
                    'type' => 'newChat',
                    'info' => [
                        'name' => $sender['name'],
                    ],
                    'id' => $sender['id'],
                    'data' => $receivedData['data']
                ];
                $client->send(json_encode($sendData));
            }
        };

        $ws->onClose = function (TcpConnection $connection) use (&$clients) {
            unset($clients[$connection->id]);
            echo "Client {$connection->id} disconnected\n";
            echo "Client Count " . count($clients) . "\n";
        };

        Worker::runAll();
    }
}
