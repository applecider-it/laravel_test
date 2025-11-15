<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redis;

use App\Services\WebSocket\SystemService as WebSocketSystemService;
use App\Services\Channels\ChatChannel;
use App\Services\AI\AiService;

class TestController extends Controller
{
    public function __construct(
        private WebSocketSystemService $webSocketSystemService,
        private AiService $aiService
    ) {}

    public function index()
    {

        Log::info('getMiddleware', [print_r(app('router')->getMiddleware(), true)]);
        Log::info('getMiddlewareGroups', [print_r(app('router')->getMiddlewareGroups(), true)]);

        $currentRoute = Route::current(); // 現在のルート
        // 適用されている全ミドルウェア
        Log::info('gatherMiddleware', [print_r($currentRoute->gatherMiddleware(), true)]);

        Redis::set('redis-test', 'TEST');

        return view('test.index');
    }

    /** Laravelから、AIマイクロサービスへの送信テスト */
    public function ai_test(Request $request)
    {
        $response = $this->aiService->testSend();

        Log::info('response', [$response]);

        return view('test.index');
    }

    /** Laravelから、websocketマイクロサービスへの送信テスト */
    public function websocket_test(Request $request)
    {
        $data = [
            "message" => "システムからの送信 " . date('Y-m-d h:i:s'),
        ];

        $response = $this->webSocketSystemService->sendSystemData(ChatChannel::CHANNEL_ID, $data);

        Log::info('websocket_test response', [$response]);

        return view('test.index');
    }
}
