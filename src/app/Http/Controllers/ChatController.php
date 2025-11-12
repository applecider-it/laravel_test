<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Log;

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
        ]);
    }
}
