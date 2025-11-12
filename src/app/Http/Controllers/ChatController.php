<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

class ChatController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $token = JWT::encode([
            'sub' => $user->id,
            'name' => $user->name,
            'iat' => time(),
            'exp' => time() + 60 * 60 * 12, // 12時間
        ], env('WS_JWT_SECRET'), 'HS256');

        return view('chat.index', compact('token'));
    }

    /** nodeからのコールバックテスト用のAPI */
    public function callback_test(Request $request)
    {
        Log::info('callback_test実行');
        Log::info('auth()->user()', [auth()->user()]);
        Log::info('$request->all', [$request->all()]);

        $content = $request->input('content');
        Log::info('$content', [$content]);

        Log::info('getMiddleware', [print_r(app('router')->getMiddleware(), true)]);
        Log::info('getMiddlewareGroups', [print_r(app('router')->getMiddlewareGroups(), true)]);

        $currentRoute = Route::current(); // 現在のルート
        // 適用されている全ミドルウェア
        Log::info('gatherMiddleware', [print_r($currentRoute->gatherMiddleware(), true)]);

        $userId = null;

        $token = $request->bearerToken(); // Authorization: Bearer <token>
        try {
            $payload = JWT::decode($token, new Key(env('WS_JWT_SECRET'), 'HS256'));
            $userId = $payload->sub;
            $userName = $payload->name;

            Log::info('userId: ' . $userId);
            Log::info('userName: ' . $userName);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid token'], 401);
        }

        return response()->json([
            'auth_user' => auth()->user(),
            'test_abc' => 123,
            'userId' => $userId,
            'content' => $content,
        ]);
    }
}
