<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use WebSocket\Client;
use Firebase\JWT\JWT;

class TestController extends Controller
{
    public function index()
    {
        return view('test.index');
    }

    /** Laravelから、AIマイクロサービスへの送信テスト */
    public function ai_test(Request $request)
    {
        $text = 'Hello AI';

        // FastAPIのエンドポイントにPOST
        $response = Http::post('http://localhost:8090/predict', [
            'text' => $text
        ]);

        Log::info('response', [$response->json()]);

        return view('test.index');
    }

    /** Laravelから、websocketマイクロサービスへの送信テスト */
    public function websocket_test(Request $request)
    {
        $token = JWT::encode([
            'sub' => 'system',
            'name' => 'System',
            'iat' => time(),
            'exp' => time() + 60 * 60 * 12, // 12時間
        ], env('WS_JWT_SECRET'), 'HS256');

        $client = new Client("ws://127.0.0.1:8080?token={$token}"); // Node の WebSocket サーバ

        $client->send(json_encode(["message" => "hello from Laravel"]));
        $response = $client->receive();

        if ($response) {
            Log::info('websocket_test response', [$response]);
        } else {
            Log::info('websocket_test response is null');
        }

        $client->close();

        return view('test.index');
    }
}
