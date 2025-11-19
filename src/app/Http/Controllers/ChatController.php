<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

use App\Services\WebSocket\AuthService as WebSocketAuthService;

/**
 * チャット管理コントローラー
 * 
 * ドキュメント
 * /documents/features/chat.md
 */
class ChatController extends Controller
{
    public function __construct(
        private WebSocketAuthService $webSocketAuthService
    ) {}

    public function index()
    {
        $user = auth()->user();

        $token = $this->webSocketAuthService->createUserJwt($user);

        return view('chat.index', compact('token'));
    }

    /** nodeからのコールバックテスト用のAPI */
    public function callback_test(Request $request)
    {
        // 確認用のトレース

        Log::info('callback_test実行');
        Log::info('auth()->user()', [auth()->user()]);
        Log::info('$request->all', [$request->all()]);

        $content = $request->input('content');
        Log::info('$content', [$content]);

        Log::info('getMiddleware', [print_r(app('router')->getMiddleware(), true)]);
        Log::info('getMiddlewareGroups', [print_r(app('router')->getMiddlewareGroups(), true)]);

        // 適用されている全ミドルウェア
        Log::info('gatherMiddleware', [print_r(Route::current()->gatherMiddleware(), true)]);

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
