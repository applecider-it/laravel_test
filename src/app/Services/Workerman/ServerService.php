<?php

namespace App\Services\Workerman;

use Workerman\Worker;

use Workerman\Connection\TcpConnection;
use Workerman\Protocols\Http\Request;

use App\Services\WebSocket\AuthService;

use App\Models\User;

/**
 * Workermanサーバー管理
 * 
 * 若干不安定
 */
class ServerService
{
    // 全接続クライアントを格納
    private array $clients = [];

    public function __construct(
        private AuthService $authService
    ) {}

    /**
     * サーバー起動
     */
    public function start()
    {
        $ws = new Worker("websocket://" . config('myapp.workerman_server_host'));

        $ws->onWebSocketConnect = function (TcpConnection $connection, Request $httpRequest) {
            $this->onWebSocketConnect($connection, $httpRequest);
        };

        $ws->onMessage = function (TcpConnection $connection, $str) {
            $this->onMessage($connection, $str);
        };

        $ws->onClose = function (TcpConnection $connection) {
            $this->onClose($connection);
        };

        Worker::runAll();
    }

    /**
     * コネクト時
     */
    public function onWebSocketConnect(TcpConnection $connection, Request $httpRequest)
    {
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
            $this->clients[$connection->id] = $connection;

            echo "Client {$connection->id} connected\n";
            echo "Client Count " . count($this->clients) . "\n";
        } else {
            $connection->close();
        }
    }

    /**
     * クローズ時
     */
    public function onClose(TcpConnection $connection)
    {
        unset($this->clients[$connection->id]);
        echo "Client {$connection->id} disconnected\n";
        echo "Client Count " . count($this->clients) . "\n";
    }

    /**
     * メッセージ受け取り時
     */
    public function onMessage(TcpConnection $connection, $str)
    {
        echo "Received from {$connection->id}: $str\n";

        $sender = $connection->user;
        echo "Sender\n";
        print_r($sender);

        $receivedData = json_decode($str, true);

        print_r($receivedData);

        $this->broadcast($sender, $receivedData);
    }

    /**
     * ブロードキャスト
     */
    public function broadcast(array $sender, array $receivedData)
    {
        // Laravelのコードの実行例
        // 下手に使うとメモリやパフォーマンスが大変なことになると思うので、
        // 基本的にはキューをつかうだけのほうが無難かも
        echo "Laravel Test\n";
        $user = User::find($sender['id']);
        if ($user) {
            echo "Sender Email: {$user->email}\n";
        }

        // 全クライアントにメッセージを送信（ブロードキャスト）
        foreach ($this->clients as $client) {
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
    }
}
