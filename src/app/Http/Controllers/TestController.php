<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use WebSocket\Client;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Route;

use App\Services\WebSocket\SystemService as WebSocketSystemService;

class TestController extends Controller
{
    public function __construct(
        private WebSocketSystemService $webSocketSystemService
    ) {}

    public function index()
    {

        Log::info('getMiddleware', [print_r(app('router')->getMiddleware(), true)]);
        Log::info('getMiddlewareGroups', [print_r(app('router')->getMiddlewareGroups(), true)]);

        $currentRoute = Route::current(); // 現在のルート
        // 適用されている全ミドルウェア
        Log::info('gatherMiddleware', [print_r($currentRoute->gatherMiddleware(), true)]);

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
        $data = [
            "data" => [
                "message" => "hello from Laravel",
            ],
            "channel" => "chat",
        ];

        $response = $this->webSocketSystemService->sendSystemData($data);

        Log::info('websocket_test response', [$response]);

        return view('test.index');
    }
}
