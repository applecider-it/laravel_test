<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

use App\Services\WebSocket\AuthService as WebSocketAuthService;
use App\Http\Controllers\Controller;
use App\Services\Development\TraceService;

/**
 * 開発者向けAPI管理コントローラー
 */
class DevelopmentController extends Controller
{
    public function __construct(
        private WebSocketAuthService $webSocketAuthService,
        private TraceService $traceService
    ) {}

    /** node chatからのコールバックテスト用のAPI */
    public function chat_callback_test(Request $request)
    {
        // 確認用のトレース

        Log::info('callback_test実行');
        Log::info('auth()->user()', [auth()->user()]);
        Log::info('$request->all', [$request->all()]);

        $content = $request->input('content');
        Log::info('$content', [$content]);

        $this->traceService->traceMiddlewareInfo();

        // ここからロジック

        $userId = null;

        $token = $request->bearerToken(); // Authorization: Bearer <token>
        $data = $this->webSocketAuthService->parseJwt($token);

        if (! $data) return response()->json(['error' => 'Invalid token'], 401);

        Log::info('data: ', [$data]);

        return response()->json([
            'auth_user' => auth()->user(),
            'test_abc' => 123,
            'userId' => $userId,
            'content' => $content,
        ]);
    }
}
