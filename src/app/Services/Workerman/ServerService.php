<?php

namespace App\Services\Workerman;

use Workerman\Worker;

/**
 * Workermanサーバー管理
 */
class ServerService
{
    /**
     * サーバー起動
     */
    public function start()
    {
        $ws = new Worker("websocket://" . config('myapp.workerman_server_host'));

        // 全接続クライアントを格納
        $clients = [];

        $ws->onConnect = function ($connection) use (&$clients) {
            $clients[$connection->id] = $connection;
            echo "Client {$connection->id} connected\n";
        };

        $ws->onMessage = function ($connection, $str) use (&$clients) {
            echo "Received from {$connection->id}: $str\n";

            $receivedData = json_decode($str, true);

            print_r($receivedData);

            // 全クライアントにメッセージを送信（ブロードキャスト）
            foreach ($clients as $client) {
                $sendData = [
                    'type' => 'newChat',
                    'info' => [
                        'name' => 'Test',
                    ],
                    'id' => 'test',
                    'data' => $receivedData['data']
                ];
                $client->send(json_encode($sendData));
            }
        };

        $ws->onClose = function ($connection) use (&$clients) {
            unset($clients[$connection->id]);
            echo "Client {$connection->id} disconnected\n";
        };

        Worker::runAll();
    }
}
